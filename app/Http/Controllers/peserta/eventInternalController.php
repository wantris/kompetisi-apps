<?php

namespace App\Http\Controllers\peserta;

use App\EventInternal;
use App\EventInternalFavourite;
use App\EventInternalRegistration;
use App\Http\Controllers\Controller;
use App\KategoriEvent;
use App\Ormawa;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Pengguna;
use App\Pengumuman;
use App\TimEvent;
use App\Timeline;
use App\FileEventInternalDetail;
use App\FileEventInternalRegistration;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Controllers\endpoint\ApiDosenController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class eventInternalController extends Controller
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
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Event Internal';

        if (Session::get('id_pengguna') != null) {

            $pengguna = $this->pengguna;
            $active_regis = collect();
            $inactive_regis = collect();

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
                    $active_regis_tim = EventInternalRegistration::with('eventInternalRef')->where('tim_event_id', $tim->id_tim_event)->whereHas('eventInternalRef', function ($query) {
                        $query->where('status', 1);
                    })->first();

                    $inactive_regis_tim = EventInternalRegistration::with('eventInternalRef')->where('tim_event_id', $tim->id_tim_event)->whereHas('eventInternalRef', function ($query) {
                        $query->where('status', 0);
                    })->first();

                    if ($active_regis_tim) {
                        $active_regis->push($active_regis_tim);
                    }

                    if ($inactive_regis_tim) {
                        $inactive_regis->push($inactive_regis_tim);
                    }
                }
            }

            $active_regis_individu = EventInternalRegistration::with('eventInternalRef')->where(function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                } elseif ($pengguna->is_participant) {
                    $query->where('participant_id', $pengguna->participant_id);
                }
            })->whereHas('eventInternalRef', function ($query) {
                $query->where('status', 1);
            })->get();

            if ($active_regis_individu->count() > 0) {
                foreach ($active_regis_individu as $item) {
                    $active_regis->push($item);
                }
            }

            $inactive_regis_individu = EventInternalRegistration::with('eventInternalRef')->where(function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                } elseif ($pengguna->is_participant) {
                    $query->where('participant_id', $pengguna->participant_id);
                }
            })->whereHas('eventInternalRef', function ($query) {
                $query->where('status', 0);
            })->get();

            if ($inactive_regis_individu->count() > 0) {
                foreach ($inactive_regis_individu as $item) {
                    $inactive_regis->push($item);
                }
            }

            $favs = $this->getFavourite();

            return view('peserta.eventinternal.index', compact('navTitle', 'active_regis', 'inactive_regis', 'ormawas', 'kategoris', 'favs'));
        }
    }

    public function getFavourite()
    {
        $pengguna = $this->pengguna;

        $favs = EventInternalFavourite::with('eventInternalRef')->where('pengguna_id', $pengguna->id_pengguna)->get();

        return $favs;
    }

    public function filterEventAktif(Request $request)
    {
        $id_kategori = $request->id_kategori;
        $id_ormawa = $request->id_ormawa;

        if (Session::get('id_pengguna') != null) {

            $pengguna = $this->pengguna;

            if ($pengguna->is_mahasiswa) {
                $active_regis = EventInternalRegistration::with('eventInternalRef')->where('nim', $pengguna->nim)->whereHas('eventInternalRef', function ($query) use ($id_kategori, $id_ormawa) {
                    $query->where('status', 1);
                    if ($id_kategori != "all") {
                        $query->where('kategori_id', $id_kategori);
                    }
                    if ($id_ormawa != "all") {
                        $query->where('ormawa_id', $id_ormawa);
                    }
                })->get();
            } else {
                $active_regis = EventInternalRegistration::with('eventInternalRef')->where('participant_id', $pengguna->participant_id)->whereHas('eventInternalRef', function ($query) use ($id_kategori, $id_ormawa) {
                    $query->where('status', 1);
                    if ($id_kategori != "all") {
                        $query->where('kategori_id', $id_kategori);
                    }
                    if ($id_ormawa != "all") {
                        $query->where('ormawa_id', $id_ormawa);
                    }
                })->get();
            }

            foreach ($active_regis as $active) :
                $url = url('assets/img/banner-komp/' . $active->eventInternalRef->banner_image);
                echo '<div class="col-sm-12 col-md-6 col-lg-4 mb-30">';
                echo '<div class="card card-box" style="outline: none !important; border:none !important">';
                echo '<div class="star-div"><i class="icon-copy fa fa-star text-orange fa-lg float-right mr-2 mt-2" aria-hidden="true"></i></div>';
                echo '<img class="card-img-top" src="' . url('assets/img/banner-komp/' . $active->eventInternalRef->banner_image) . '" alt="Card image cap">';
                echo '<div class="card-body">';
                $deskripsi = Str::limit($active->eventInternalRef->deskripsi, 100, $end = '.......');
                echo '<h5 class="card-title weight-500">' . $active->eventInternalRef->nama_event . '</h5>';
                echo '<div class="text-secondary"> ' . $deskripsi . ' </div>';
                echo '<p class="card-text"><small class="text-muted"  style="color: #ed8512 !important"><i class="icon-copy dw dw-checked text-orange mr-1" aria-hidden="true"></i> Terdaftar ' . $active->created_at->diffForHumans() . '</small></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            endforeach;
        }
    }

    public function detail($slug)
    {

        $pengguna = $this->pengguna;

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();

        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>' . $event->nama_event;
            $registrations = EventInternalRegistration::with('timRef', 'participantRef')->where('event_internal_id', $event->id_event_internal)->get();
            $check_regis = $this->checkIsRegis($pengguna, $event);

            $feeds = $this->getAllFilePendaftaran($event->id_event_internal);

            if ($event->role != "Team") {
                foreach ($registrations as $item) {
                    $item->mahasiswaRef = null;
                    if ($item->nim) {
                        try {
                            $mhs = $this->api_mahasiswa->getMahasiswaByNim($item->nim);
                            $item->mahasiswaRef = $mhs;
                        } catch (\Throwable $err) {
                        }
                    }
                }
            } else {
                foreach ($registrations as $item) {
                    foreach ($item->timRef->timDetailRef as $detail) {
                        if ($detail->role == "ketua") {
                            $detail->mahasiswaRef = null;
                            if ($detail->nim) {
                                try {
                                    $mhs = $this->api_mahasiswa->getMahasiswaByNim($detail->nim);;
                                    $detail->mahasiswaRef = $mhs;
                                } catch (\Throwable $err) {
                                }
                            }
                        }
                    }
                }
            }

            return view('peserta.eventinternal.detail', compact(
                'slug',
                'navTitle',
                'registrations',
                'event',
                'check_regis',
                'feeds',
                'pengguna'
            ));
        }

        return redirect()->back()->with('failed', 'Event tidak ada');
    }

    public function submission($slug)
    {
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Submission';
        return view('peserta.eventinternal.submission', compact('slug', 'navTitle'));
    }

    public function info($slug)
    {
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Info Submission';
        return view('peserta.eventinternal.submission_info', compact('slug', 'navTitle'));
    }

    public function uploadFile(Request $req, $id_regis)
    {
        // dd($request->all());
        if ($req->file('file')) {
            $resorceFile = $req->file('file');
            $nameFile   = "berkas_pendaftaran_" . rand(0000, 9999) . "." . $resorceFile->getClientOriginalExtension();
            $resorceFile->move(\base_path() . "/public/assets/file/berkas_pendaftaran_internal/", $nameFile);
        }

        $file = new FileEventInternalRegistration();
        $file->event_internal_regis_id = $id_regis;
        $file->filename = $nameFile;
        $file->save();

        return redirect()->back()->with('success', 'Upload berkas berhasil');
    }

    public function notification($slug)
    {

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();
        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Pengumuman ' . $event->nama_event;
            $pengumumans = Pengumuman::where('event_internal_id', $event->id_event_internal)->get();

            return view('peserta.eventinternal.notification', compact('slug', 'navTitle', 'event', 'pengumumans'));
        }
        return redirect()->back()->with('faield', 'Maaf terjadi error');
    }

    public function detailNotification($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $pn = Pengumuman::where('title', $removeSlug)->first();

        if ($pn) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>' . $removeSlug;
            return view('peserta.eventinternal.notification_detail', compact('pn', 'slug', 'navTitle'));
        }
    }

    public function timeline($slug)
    {

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();

        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Timeline ' . $event->nama_event;
            $tls = Timeline::where('event_internal_id', $event->id_event_internal)->get();

            return view('peserta.eventinternal.timeline', compact('navTitle', 'tls', 'slug'));
        }
    }

    public function checkIsRegis($pengguna, $event)
    {
        $id_eventinternal = $event->id_event_internal;

        if ($event->role == "Team") {
            $check_regis = TimEvent::with('eventInternalRegisRef.sertifikatRef', 'eventInternalRegisRef.tahapanRegisRef')->whereHas('eventInternalRegisRef', function ($query) use ($id_eventinternal) {
                $query->where('event_internal_id', $id_eventinternal);
            })->whereHas('timDetailRef', function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                } else {
                    $query->where('participant_id', $pengguna->participant_id);
                }
            })->first();
        } else {
            if ($pengguna->is_mahasiswa) {
                $check_regis = EventInternalRegistration::with('tahapanRegisRef', 'sertifikatRef')->where('nim', $pengguna->nim)
                    ->where('event_internal_id', $id_eventinternal)->first();
            } else {
                $check_regis = EventInternalRegistration::with('tahapanRegisRef', 'sertifikatRef')->where('participant_id', $pengguna->participant_id)
                    ->where('event_internal_id', $id_eventinternal)->first();
            }
        }

        return $check_regis;
    }

    public function getAllFilePendaftaran($id_eventinternal)
    {
        $feeds = FileEventInternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventinternal) {
            $q->where('event_internal_id', '=', $id_eventinternal);
        })->where('tipe', 'pendaftaran')->get();

        return $feeds;
    }

    public function getMahasiswaByNim($nim)
    {
        $msh = null;

        try {
            $client = new Client();
            $url = env("SOURCE_API") . "mahasiswa/detail/" . $nim;
            $rMhs = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $mhs = json_decode($rMhs->getBody());
        } catch (\Throwable $err) {
        }

        return $mhs;
    }

    public function checkIsFavourite($id_eventinternal)
    {
        $fav = EventInternalFavourite::where('pengguna_id', Session::get('id_pengguna'))->where('event_internal_id', $id_eventinternal)->first();
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

    public function addFavourite($id_eventinternal)
    {
        try {
            $fav = new EventInternalFavourite();
            $fav->pengguna_id = Session::get('id_pengguna');
            $fav->event_internal_id = $id_eventinternal;
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

    public function removeFavourite($id_eventinternal)
    {
        try {
            $fav = EventInternalFavourite::where('pengguna_id', Session::get('id_pengguna'))->where('event_internal_id', $id_eventinternal)->first();

            if ($fav) {
                EventInternalFavourite::destroy($fav->id_event_internal_favourites);
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
