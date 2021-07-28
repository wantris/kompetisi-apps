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

class eventEksternalController extends Controller
{
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
            $pengguna = Pengguna::with('participantRef')->find(Session::get('id_pengguna'));
            if ($pengguna->nim) {
                $pengguna->nama_mhs = $pengguna->nim;
                $mhs = $this->getMahasiswaByNim($pengguna->nim);
                $pengguna->nama_mhs = $mhs->nama;
            }
            $check_regis = $this->checkIsRegis($pengguna, $event->id_event_eksternal);
            $registrations = $this->getAllRegisInByEvent($event);
            $feeds = $this->getAllDocPendaftaran($event->id_event_eksternal);
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

        $pengguna = Pengguna::find(Session::get('id_pengguna'));

        if ($pengguna->is_mahasiswa) {
            $penggunaRef = $pengguna->nim;
        } else {
            $penggunaRef = $pengguna->participant_id;
        }

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
                if ($pengguna->is_mahasiswa) {
                    $ted->nim = $pengguna->nim;
                } else {
                    $ted->participant_id = $pengguna->participant_id;
                }
                $ted->role = "ketua";
                $ted->status = "Done";
                $ted->save();

                // Anggota
                foreach ($request->anggota as $key => $item) {
                    $anggota = Pengguna::find($item);

                    // insert to temporary team detail
                    $ted = new TimEventDetail();
                    $ted->tim_event_id = $tim->id_tim_event;
                    if ($anggota->is_mahasiswa) {
                        $ted->nim = $anggota->nim;
                    } else {
                        $ted->participant_id = $anggota->participant_id;
                    }
                    $ted->role = "anggota";
                    $ted->status = "Pending";
                    $ted->save();

                    // send email
                    try {
                        if ($pengguna->is_mahasiswa) {
                            $nama = $this->getMahasiswaByNim($pengguna->nim)->nama;
                        } else {
                            $nama = $pengguna->participantRef->nama_participant;
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
            $regis->nim = $penggunaRef;
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
            $pengguna = Pengguna::find(Session::get('id_pengguna'));

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
            $pengguna = Pengguna::find(Session::get('id_pengguna'));

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


    public function checkIsRegis($pengguna, $id_eventeksternal)
    {
        $event = EventEksternal::find($id_eventeksternal);
        if ($event->role == "Team") {
            $check_regis = TimEvent::whereHas('eventEksternalRegisRef', function ($query) use ($id_eventeksternal) {
                $query->where('event_eksternal_id', $id_eventeksternal);
            })->whereHas('timDetailRef', function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                }
            })->first();
        } else {
            if ($pengguna->is_mahasiswa) {
                $check_regis = EventEksternalRegistration::where('nim', $pengguna->nim)
                    ->where('event_eksternal_id', $event->id_event_eksternal)->first();
            }
        }

        return $check_regis;
    }

    public function getAllRegisInByEvent($event)
    {
        $registrations = EventEksternalRegistration::with('timRef')->where('event_eksternal_id', $event->id_event_eksternal)->get();

        if ($registrations->count() > 0) {
            if ($event->role != "Team") {
                foreach ($registrations as $item) {
                    $item->nama_mhs = null;
                    if ($item->nim) {
                        $item->nama_mhs = $item->nim;
                        try {
                            $mhs = $this->getMahasiswaByNim($item->nim);
                            $item->nama_mhs = $mhs->nama;
                        } catch (\Throwable $err) {
                        }
                    }
                }
            } else {
                foreach ($registrations as $item) {
                    foreach ($item->timRef->timDetailRef as $detail) {
                        if ($detail->role == "ketua") {
                            $detail->nama_mhs = null;
                            if ($detail->nim) {
                                $detail->nama_mhs = $detail->nim;
                                try {
                                    $mhs = $this->getMahasiswaByNim($detail->nim);
                                    $detail->nama_mhs = $mhs->nama;
                                } catch (\Throwable $err) {
                                }
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
    }

    public function getAllDocPendaftaran($id_eventeksternal)
    {
        $feeds = FileEventEksternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventeksternal) {
            $q->where('event_eksternal_id', '=', $id_eventeksternal);
        })->where('tipe', 'pendaftaran')->get();

        return $feeds;
    }


    public function searchPengguna($id)
    {
        // Cari pengguna yang tidak ada dalam tim detail dan yang tidak terdaftar pada tim $id
        $invites = Pengguna::with('participantRef')->where('id_pengguna', '!=', Session::get('id_pengguna'))
            ->where(function ($query) {
                $query->where('is_mahasiswa', 1);
            })->get();

        // get name mahasiswa from api
        foreach ($invites as $item2) {
            $item2->nama_mhs = null;
            if ($item2->nim) {
                try {
                    // Get nama mahasiswa
                    $item2->nama_mhs = $this->getMahasiswaByNim($item2->nim)->nama;
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
