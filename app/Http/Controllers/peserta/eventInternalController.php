<?php

namespace App\Http\Controllers\peserta;

use App\EventInternal;
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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class eventInternalController extends Controller
{

    public function index()
    {
        $ormawas = Ormawa::all();
        $kategoris = KategoriEvent::all();
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Event Internal';


        if (Session::get('id_pengguna') != null) {
            $pengguna = Pengguna::find(Session::get('id_pengguna'));
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
                foreach($active_regis_individu as $item){
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
                foreach($inactive_regis_individu as $item){
                    $inactive_regis->push($item);
                }
            }

            return view('peserta.eventinternal.index', compact('navTitle', 'active_regis', 'inactive_regis', 'ormawas', 'kategoris'));
        }
    }

    public function filterEventAktif(Request $request)
    {
        $id_kategori = $request->id_kategori;
        $id_ormawa = $request->id_ormawa;

        if (Session::get('id_pengguna') != null) {
            $pengguna = Pengguna::find(Session::get('id_pengguna'));
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
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $pengguna = Pengguna::find(Session::get('id_pengguna'));
        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>' . $removeSlug;
            $registrations = EventInternalRegistration::with('timRef', 'participantRef')->where('event_internal_id', $event->id_event_internal)->get();
            $check_regis = $this->checkIsRegis($pengguna, $event->id_event_internal);
            $feeds = $this->getAllFilePendaftaran($event->id_event_internal);
            if ($event->role != "Team") {
                foreach ($registrations as $item) {
                    $item->nama_mhs = null;
                    if ($item->nim) {
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

            return view('peserta.eventinternal.detail', compact(
                'slug', 
                'navTitle', 
                'registrations', 
                'event',
                'check_regis',
                'feeds'
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

      public function uploadFile(Request $req, $id_regis){
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

        return redirect()->back()->with('success','Upload berkas berhasil');
    }

    public function notification($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();
        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Pengumuman ' . $removeSlug;
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
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Timeline ' . $removeSlug;
            $tls = Timeline::where('event_internal_id', $event->id_event_internal)->get();

            return view('peserta.eventinternal.timeline', compact('navTitle', 'tls', 'slug'));
        }
    }

     public function checkIsRegis($pengguna, $id_eventinternal)
    {
        $event = EventInternal::find($id_eventinternal);
        if ($event->role == "Team") {
            $check_regis = TimEvent::whereHas('eventInternalRegisRef', function ($query) use ($id_eventinternal) {
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
                $check_regis = EventInternalRegistration::where('nim', $pengguna->nim)
                    ->where('event_internal_id', $id_eventinternal)->first();
            } else {
                $check_regis = EventInternalRegistration::where('participant_id', $pengguna->participant_id)
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

        try{
            $client = new Client();
            $url = env("SOURCE_API") . "mahasiswa/detail/" . $nim;
            $rMhs = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $mhs = json_decode($rMhs->getBody());

        }catch(\Throwable $err){

        }

        return $mhs;
    }


}
