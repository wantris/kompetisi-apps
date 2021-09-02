<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ormawa;
use App\KategoriEvent;
use App\Pengguna;
use App\EventEksternalRegistration;
use App\EventEksternal;
use App\EventEksternalFavourite;
use App\EventInternalFavourite;
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
use App\TahapanEventEksternal;
use App\TahapanEventEksternalRegis;
use Illuminate\Support\Facades\Cache;

class eventEksternalController extends Controller
{
    protected $api_mahasiswa;
    protected $api_dosen;
    protected $pengguna;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->api_mahasiswa = new ApiMahasiswaController;
            $this->api_dosen = new ApiDosenController;
            $this->pengguna = Pengguna::find(Session::get('id_pengguna'));
            return $next($request);
        });
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

        // get all favourite data
        $favs = $this->getAllFavourite();

        return view('peserta.eventeksternal.index', compact(
            'ormawas',
            'kategoris',
            'navTitle',
            'event_eksternals',
            'active_regis',
            'inactive_regis',
            'favs'
        ));
    }

    public function detail($slug)
    {

        $event = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();

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


            return view('peserta.eventeksternal.detail', compact(
                'navTitle',
                'event',
                'slug',
                'pengguna',
                'check_regis',
                'registrations',
                'feeds'
            ));
        }

        return redirect()->back()->with('failed', 'Terjadi kegagalan');
    }

    public function register(Request $request, $slug)
    {
        $event = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();

        $pengguna = $this->pengguna;

        // registrasi event
        if ($event->role == "Team") {
            $tim = new TimEvent();
            $tim->status = 0;
            $tim->save();

            if ($tim) {

                $eir = new EventEksternalRegistration();
                $eir->event_eksternal_id = $event->id_event_eksternal;
                $eir->tim_event_id = $tim->id_tim_event;
                $eir->status = 0;
                $eir->save();

                // Save to step
                $tahapan = TahapanEventEksternal::where('event_eksternal_id', $event->id_event_eksternal)->where('nama_tahapan', 'Pendaftaran')->first();
                if ($tahapan) {
                    $tahapan_regis = new TahapanEventEksternalRegis();
                    $tahapan_regis->tahapan_event_eksternal_id = $tahapan->id_tahapan_event_eksternal;
                    $tahapan_regis->event_eksternal_regis_id = $eir->id_event_eksternal_registration;
                    $tahapan_regis->save();
                }

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

                        Mail::to($pengguna->email)->send(new invitationTeamMail($nama, $event->nama_event, $ted->id_tim_event_detail));
                    } catch (\Throwable $err) {
                    }
                }

                return redirect()->route('peserta.team.index')->with('success', 'Pendaftaran event berhasil');
            }
        } else {

            $regis = new EventEksternalRegistration();
            $regis->event_eksternal_id = $event->id_event_eksternal;
            $regis->nim = $pengguna->nim;
            $regis->status = 0;
            $regis->save();

            $tahapan = TahapanEventEksternal::where('event_internal_id', $event->id_event_eksternal)->where('nama_tahapan', 'Pendaftaran')->first();
            if ($tahapan) {
                $tahapan_regis = new TahapanEventEksternalRegis();
                $tahapan_regis->tahapan_event_eksternal_id = $tahapan->id_tahapan_event_eksternal;
                $tahapan_regis->event_eksternal_regis_id = $regis->id_event_eksternal_registration;
                $tahapan_regis->save();
            }

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

        $event = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();

        if ($event) {
            $navTitle = '<span claorss="micon dw dw-up-chevron-1 mr-2"></span>Timeline ' . $slug;
            $tls = Timeline::where('event_eksternal_id', $event->id_event_eksternal)->get();

            return view('peserta.eventeksternal.timeline', compact('navTitle', 'tls', 'slug'));
        }
    }

    public function notification($slug)
    {
        $event = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();
        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Pengumuman ' . $slug;
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
            $check_regis = TimEvent::with('eventEksternalRegisRef.sertifikatRef', 'eventEksternalRegisRef.tahapanRegisRef')->whereHas('eventEksternalRegisRef', function ($query) use ($id_eventeksternal) {
                $query->where('event_eksternal_id', $id_eventeksternal);
            })->whereHas('timDetailRef', function ($query) use ($pengguna) {
                $query->where('nim', $pengguna->nim);
            })->first();
        } else {
            $check_regis = EventEksternalRegistration::with('tahapanRegisRef', 'sertifikatRef')->where('nim', $pengguna->nim)
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
        $api_mahasiswa = $this->api_mahasiswa;

        $mahasiswas = Cache::remember('all_mahasiswa', 120, function () use ($api_mahasiswa) {
            $mahasiswas = Pengguna::where('is_mahasiswa', 1)->where('id_pengguna', '!=', Session::get('id_pengguna'))->get();

            $mahasiswas->each(function ($item, $key) use ($api_mahasiswa) {
                $item->mahasiswaRef = null;
                $mhs = $api_mahasiswa->getMahasiswaSomeField($item->nim);
                if ($mhs) {
                    $item->mahasiswaRef = $mhs;
                }
            });

            return $mahasiswas;
        });

        $new_mahasiswas = collect();
        $year = \Carbon\Carbon::now()->year;

        foreach ($mahasiswas as $item) {
            $cut_prodi = $item->mahasiswaRef->program_studi_kode[0] . $item->mahasiswaRef->program_studi_kode[1];

            if ($cut_prodi == "D4") {
                $minus_year = $year - 4;
                if ($item->tahun_index >= $minus_year && $item->tahun_index <= $year) {
                    $new_mahasiswas->push($item);
                }
            } elseif ($cut_prodi == "D3") {
                $minus_year = $year - 3;
                if ($item->mahasiswaRef->tahun_index >= $minus_year && $item->mahasiswaRef->tahun_index <= $year) {
                    $new_mahasiswas->push($item);
                }
            }
        }

        return response()->json($new_mahasiswas);
    }

    public function getAllFavourite()
    {
        $favs = EventEksternalFavourite::with('eventEksternalRef')->where('pengguna_id', Session::get('id_pengguna'))->get();

        return $favs;
    }

    public function checkIsFavourite($id_eventeksternal)
    {
        $fav = EventEksternalFavourite::where('pengguna_id', Session::get('id_pengguna'))->where('event_eksternal_id', $id_eventeksternal)->first();
        if ($fav) {
            $data = (object)[
                'status' => true,
                'data' => $fav
            ];
        } else {
            $data = (object)[
                'status' => false,
                'data' => null
            ];
        }
        return response()->json($data);
    }

    public function addFavourite($id_eventeksternal)
    {
        try {
            $fav = new EventEksternalFavourite();
            $fav->pengguna_id = Session::get('id_pengguna');
            $fav->event_eksternal_id = $id_eventeksternal;
            $fav->save();

            if ($fav) {
                $data = (object)[
                    'status' => true,
                    'data' => $fav
                ];
            } else {
                $data = (object)[
                    'status' => false,
                    'data' => null
                ];
            }
            return response()->json($data);
        } catch (\Throwable $err) {
            return response()->json($err);
        }
    }

    public function removeFavourite($id_eventeksternal)
    {
        try {
            $fav = EventEksternalFavourite::where('pengguna_id', Session::get('id_pengguna'))->where('event_eksternal_id', $id_eventeksternal)->first();

            if ($fav) {
                EventEksternalFavourite::destroy($fav->id_event_eksternal_favourites);
            }

            $data = (object)[
                'status' => false,
                'data' => null
            ];
            return response()->json($data);
        } catch (\Throwable $err) {
            return response()->json($err);
        }
    }
}
