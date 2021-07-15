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
use App\Timeline;
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
            if ($pengguna->is_mahasiswa) {
                $active_regis = EventInternalRegistration::with('eventInternalRef')->where('nim', $pengguna->nim)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 1);
                })->get();
                $inactive_regis = EventInternalRegistration::with('eventInternalRef')->where('nim', $pengguna->nim)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 0);
                })->get();

                return view('peserta.eventinternal.index', compact('navTitle', 'active_regis', 'inactive_regis', 'ormawas', 'kategoris'));
            } else {
                $active_regis = EventInternalRegistration::with('eventInternalRef')->where('participant_id', $pengguna->participant_id)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 1);
                })->get();
                $inactive_regis = EventInternalRegistration::with('eventInternalRef')->where('participant_id', $pengguna->participant_id)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 0);
                })->get();

                return view('peserta.eventinternal.index', compact('navTitle', 'active_regis', 'inactive_regis', 'ormawas', 'kategoris'));
            }
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

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        if ($event) {
            $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>' . $removeSlug;
            $registrations = EventInternalRegistration::where('event_internal_id', $event->id_event_internal)->get();

            foreach ($registrations as $item) {
                $item->nama_mhs = null;
                if ($item->nim) {
                    try {
                        $client = new Client();
                        $url = env("SOURCE_API") . "mahasiswa/detail/" . $item->nim;
                        $rMhs = $client->request('GET', $url, [
                            'verify'  => false,
                        ]);
                        $mhs = json_decode($rMhs->getBody());

                        $item->nama_mhs = $mhs->nama;
                    } catch (\Throwable $err) {
                    }
                }
            }
            return view('peserta.eventinternal.detail', compact('slug', 'navTitle', 'registrations', 'event'));
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
}
