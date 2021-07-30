<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ormawa;
use App\KategoriEvent;
use App\Pengguna;
use App\EventEksternalRegistration;
use App\EventEksternal;
use App\FileEventEksternalDetail;
use App\FileEventEksternalRegistration;
use App\Timeline;
use App\TimEvent;
use App\Pengumuman;
use App\TimEventDetail;
use Illuminate\Support\Facades\Mail;
use App\Mail\invitationTeamMail;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Controllers\endpoint\ApiDosenController;

class eventEksternalController extends Controller
{
    protected $api_mahasiswa;
    protected $api_dosen;
    protected $pengguna;

    public function __construct()
    {
        $this->api_mahasiswa = new ApiMahasiswaController;
        $this->api_dosen = new ApiDosenController;
        $this->pengguna = Pengguna::find(Session::get('id_pengguna'));
    }

    public function index()
    {
        $ormawas = Ormawa::all();

        $kategoris = KategoriEvent::all();
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Event Eksternal';

        $event_eksternals = EventEksternal::with('kategoriRef', 'tipePesertaRef')->where('status', 1)->get();

        // get Active event registration by session login
        $active_regis = $this->getEventActiveBySession();


        // get Inactive event registration by session login
        $inactive_regis = $this->getEventInactiveBySession();

        return view('peserta.eventeksternal.index', compact(
            'ormawas',
            'kategoris',
            'navTitle',
            'event_eksternals',
            'active_regis',
            'inactive_regis'
        ));
    }

    public function detail($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $event = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Event ' . $event->nama_event;
            $pengguna = $this->pengguna;


            if ($pengguna->nim) {
                $pengguna->mahasiswaRef = null;
                $mhs = $this->api_mahasiswa->getMahasiswaByNim($pengguna->nim);
                $pengguna->mahasiswaRef = $mhs;
            }

            $check_regis = $this->checkIsRegis($pengguna, $event);

            $registrations = $this->getAllRegisInByEvent($event);
            $feeds = $this->getAllDocPendaftaran($event);
            $search = $this->searchPengguna($event->id_event_eksternal);


            return view('peserta.eventeksternal.detail', compact(
                'navTitle',
                'event',
                'slug',
                'pengguna',
                'check_regis',
                'registrations',
                'feeds',
                'search'
            ));
        }

        return redirect()->back()->with('failed', 'Terjadi kegagalan');
    }

    public function register(Request $request, $slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);
        $event = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        $pengguna = $this->pengguna;

        // registrasi event
        $is_win = array('is_win' => '0', 'position' => null);

        if ($event->role == "Team") {
            $tim = new TimEvent();
            $tim->status = 0;
            $tim->save();

            if ($tim) {

                $eir = new EventEksternalRegistration();
                $eir->event_eksternal_id = $event->id_event_eksternal;
                $eir->tim_event_id = $tim->id_tim_event;
                $eir->is_win = json_encode($is_win);
                $eir->status = 0;
                $eir->save();

                $ted = new TimEventDetail();
                $ted->tim_event_id = $tim->id_tim_event;
                $ted->nim = $pengguna->nim;
                $ted->role = "ketua";
                $ted->status = "Done";
                $ted->save();

                // Anggota
                foreach ($request->anggota as $key => $item) {
                    $anggota = Pengguna::find($item);

                    // insert to temporary team detail
                    $ted = new TimEventDetail();
                    $ted->tim_event_id = $tim->id_tim_event;
                    $ted->nim = $anggota->nim;
                    $ted->role = "anggota";
                    $ted->status = "Pending";
                    $ted->save();

                    // send email
                    try {
                        $mhs = $this->api_mahasiswa->getMahasiswaByNim($pengguna->nim)->mahasiswa_nama;
                        if ($mhs) {
                            $nama = $mhs->mahasiswa_nama;
                        } else {
                            $nama = $pengguna->nim;
                        }

                        Mail::to($pengguna->email)->send(new invitationTeamMail($nama, $removeSlug, $ted->id_tim_event_detail));
                    } catch (\Throwable $err) {
                    }
                }

                return redirect()->route('peserta.team.index')->with('success', 'Pendaftaran event berhasil');
            }
        } else {

            $regis = new EventEksternalRegistration();
            $regis->event_eksternal_id = $event->id_event_eksternal;
            $regis->nim = $pengguna->nim;
            $regis->is_win = json_encode($is_win);
            $regis->save();

            return redirect()->route('peserta.eventeksternal.index');
        }
    }

    public function uploadFile(Request $req, $id_regis)
    {
        // dd($request->all());
        if ($req->file('file')) {
            $resorceFile = $req->file('file');
            $nameFile   = "berkas_pendaftaran_" . rand(0000, 9999) . "." . $resorceFile->getClientOriginalExtension();
            $resorceFile->move(\base_path() . "/public/assets/file/berkas_pendaftaran_eksternal/", $nameFile);
        }

        $file = new FileEventEksternalRegistration();
        $file->event_eksternal_regis_id = $id_regis;
        $file->filename = $nameFile;
        $file->save();

        return redirect()->back()->with('success', 'Upload berkas berhasil');
    }

    public function timeline($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $event = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        if ($event) {
            $navTitle = '<span claorss="micon dw dw-up-chevron-1 mr-2"></span>Timeline ' . $removeSlug;
            $tls = Timeline::where('event_eksternal_id', $event->id_event_eksternal)->get();

            return view('peserta.eventeksternal.timeline', compact('navTitle', 'tls', 'slug'));
        }
    }

    public function notification($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $event = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();
        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Pengumuman ' . $removeSlug;
            $pengumumans = Pengumuman::where('event_eksternal_id', $event->id_event_eksternal)->get();

            return view('peserta.eventeksternal.notification', compact('slug', 'navTitle', 'event', 'pengumumans'));
        }
        return redirect()->back()->with('faield', 'Maaf terjadi error');
    }

    public function eventFavorite()
    {
    }

    public function getEventActiveBySession()
    {
        $active_regis = collect();

        if (Session::get('id_pengguna') != null) {
            $pengguna = $this->pengguna;

            $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                } else {
                    $query->where('participant_id', $pengguna->participant_id);
                }
                $query->where('status', 'Done');
            })->get();

            if ($tims->count() > 0) {
                foreach ($tims as $tim) {
                    $active_regis_tim = EventEksternalRegistration::with('eventEksternalRef')->where('tim_event_id', $tim->id_tim_event)
                        ->whereHas('eventEksternalRef', function ($query) {
                            $query->where('status', 1);
                        })->first();

                    if ($active_regis_tim) {
                        $active_regis->push($active_regis_tim);
                    }
                }
            }

            $active_regis_individu = EventEksternalRegistration::with('eventEksternalRef')->where(function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                } else {
                    $query->where('is_participant', $pengguna->participant_id);
                }
            })->whereHas('eventEksternalRef', function ($query) {
                $query->where('status', 1);
            })->first();

            if ($active_regis_individu) {
                $active_regis->push($active_regis_individu);
            }
        }

        return $active_regis;
    }


    public function getEventInactiveBySession()
    {
        $inactive_regis = collect();

        if (Session::get('id_pengguna') != null) {
            $pengguna = $this->pengguna;

            $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                } else {
                    $query->where('participant_id', $pengguna->participant_id);
                }
                $query->where('status', 'Done');
            })->get();

            if ($tims->count() > 0) {
                foreach ($tims as $tim) {
                    $inactive_regis_tim = EventEksternalRegistration::with('eventEksternalRef')->where('tim_event_id', $tim->id_tim_event)
                        ->whereHas('eventEksternalRef', function ($query) {
                            $query->where('status', 0);
                        })->first();

                    if ($inactive_regis_tim) {
                        $inactive_regis->push($inactive_regis_tim);
                    }
                }
            }

            $active_regis_individu = EventEksternalRegistration::with('eventEksternalRef')->where(function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                } else {
                    $query->where('is_participant', $pengguna->participant_id);
                }
            })->whereHas('eventEksternalRef', function ($query) {
                $query->where('status', 0);
            })->first();

            if ($active_regis_individu) {
                $inactive_regis->push($active_regis_individu);
            }
        }

        return $inactive_regis;
    }


    public function checkIsRegis($pengguna, $event)
    {
        $id_eventeksternal = $event->id_event_eksternal;

        if ($event->role == "Team") {
            $check_regis = TimEvent::whereHas('eventEksternalRegisRef', function ($query) use ($id_eventeksternal) {
                $query->where('event_eksternal_id', $id_eventeksternal);
            })->whereHas('timDetailRef', function ($query) use ($pengguna) {
                $query->where('nim', $pengguna->nim);
            })->first();
        } else {
            $check_regis = EventEksternalRegistration::where('nim', $pengguna->nim)
                ->where('event_eksternal_id', $id_eventeksternal)->first();
        }

        return $check_regis;
    }

    public function getAllRegisInByEvent($event)
    {
        $registrations = EventEksternalRegistration::with('timRef')->where('event_eksternal_id', $event->id_event_eksternal)->get();

        if ($registrations->count() > 0) {
            if ($event->role != "Team") {
                foreach ($registrations as $item) {
                    $item->nama_mhs = $item->nim;
                    $mhs = $this->api_mahasiswa->getMahasiswaByNim($item->nim);
                    if ($mhs) {
                        $item->nama_mhs = $mhs->mahasiswa_nama;
                    }
                }
            } else {
                foreach ($registrations as $item) {
                    foreach ($item->timRef->timDetailRef as $detail) {
                        if ($detail->role == "ketua") {
                            $detail->nama_mhs = $detail->nim;
                            $mhs = $this->api_mahasiswa->getMahasiswaByNim($detail->nim);
                            if ($mhs) {
                                $detail->nama_mhs = $mhs->mahasiswa_nama;
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
    }

    public function getAllDocPendaftaran($event)
    {
        $id_eventeksternal = $event->id_event_eksternal;

        $feeds = FileEventEksternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventeksternal) {
            $q->where('event_eksternal_id', '=', $id_eventeksternal);
        })->where('tipe', 'pendaftaran')->get();

        return $feeds;
    }


    public function searchPengguna($id)
    {
        // Cari pengguna yang tidak ada dalam tim detail dan yang tidak terdaftar pada tim $id
        $invites = Pengguna::where('id_pengguna', '!=', Session::get('id_pengguna'))
            ->where(function ($query) {
                $query->where('is_mahasiswa', 1);
            })->get();

        // get name mahasiswa from api
        foreach ($invites as $item2) {
            $item2->mahasiswaRef = null;
            if ($item2->nim) {
                try {
                    // Get nama mahasiswa
                    $item2->mahasiswaRef = $this->api_mahasiswa->getMahasiswaByNim($item2->nim);
                } catch (\Throwable $err) {
                }
            }
        }

        return $invites;
    }

    public function getMahasiswaByNim($nim)
    {
        try {
            $client = new Client();
            $url = env("SOURCE_API") . "mahasiswa/detail/" . $nim;
            $rMhs = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $mhs = json_decode($rMhs->getBody());

            return $mhs;
        } catch (\Throwable $err) {
        }
    }
}
