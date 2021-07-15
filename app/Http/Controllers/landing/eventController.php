<?php

namespace App\Http\Controllers\landing;

use App\EventInternal;
use App\Http\Controllers\Controller;
use App\KategoriEvent;
use App\Ormawa;
use App\EventInternalDetail;
use App\EventInternalRegistration;
use App\FileEventInternalDetail;
use App\Pengguna;
use App\Pengumuman;
use App\Timeline;
use GuzzleHttp\Client;
use App\TipePeserta;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class eventController extends Controller
{
    public function index()
    {
        $events = EventInternal::where('status', '1')->paginate(1);
        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();
        $ormawas = Ormawa::all();
        return view('landing.event.index', compact('events', 'kategoris', 'tipes', 'ormawas'));
    }

    public function detail($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        if ($event) {
            // Check apakah user yg login sudah mendaftar event
            if (Session::get('id_pengguna') != null) {
                $pengguna = Pengguna::find(Session::get('id_pengguna'));
                if ($pengguna->is_mahasiswa) {
                    $check_regis = EventInternalRegistration::where('nim', $pengguna->nim)->first();
                } else {
                    $check_regis = EventInternalRegistration::where('participant_id', $pengguna->participant_id)->first();
                }
            }

            $id_eventinternal = $event->id_event_internal;

            // Mengambil dokumen pendaftaran
            $feis = FileEventInternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventinternal) {
                $q->where('event_internal_id', '=', $id_eventinternal);
            })->where('tipe', 'pendaftaran')->get();
            $pns = Pengumuman::where('event_internal_id', $id_eventinternal)->get();



            return view('landing.event.detail', compact('slug', 'event', 'feis', 'pns', 'check_regis'));
        }

        return redirect()->back()->with('failed', 'Data tidak ada');
    }

    public function timeline($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        if ($event) {
            $tls = Timeline::where('event_internal_id', $event->id_event_internal)->get();
            return view('landing.event.timeline', compact('slug', 'tls', 'event'));
        }

        return redirect()->back()->with('failed', 'Upps terjadi error');
    }


    // ADDITIONAL FEATURE
    public function registration($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        if (Session::get('id_pengguna') != null) {
            $pengguna = Pengguna::find(Session::get('id_pengguna'));
            if ($pengguna->is_mahasiswa) {
                $penggunaRef = $pengguna->nim;
            } else {
                $penggunaRef = $pengguna->participant_id;
            }
        }

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();
        if ($event) {
            switch ($event->role) {
                case 'Team':
                    return redirect()->route('event.registration.team', $slug);
                    break;

                default:
                    $regis = new EventInternalRegistration();
                    $regis->event_internal_id = $event->id_event_internal;
                    if (Session::get('is_mahasiswa') == "1") {
                        $regis->nim = $penggunaRef;
                        $regis->participant_id = null;
                    } else {
                        $regis->nim = null;
                        $regis->participant_id = $penggunaRef;
                    }
                    $regis->is_win = "{}";
                    $regis->save();

                    return redirect()->route('peserta.eventeventinternal.index');
                    break;
            }
        } else {
            return redirect()->back()->with('failed', 'Event tidak ada');
        }
    }

    public function registrationTeam($slug)
    {
        $penggunas = Pengguna::where('is_mahasiswa', 1)->orWhere('is_participant', 1)->get();
        foreach ($penggunas as $item) {
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

        $user_logged = Pengguna::find(Session::get('id_pengguna'));

        if (!$user_logged) {
            return redirect()->route('project.index')->with('failed', 'Anda harus login');
        }

        if ($user_logged->nim) {
            try {
                $client = new Client();
                $url = env("SOURCE_API") . "mahasiswa/detail/" . $user_logged->nim;
                $rMhs = $client->request('GET', $url, [
                    'verify'  => false,
                ]);
                $mhs = json_decode($rMhs->getBody());

                $user_logged->nama_mhs = $mhs->nama;
            } catch (\Throwable $err) {
            }
        }

        return view('landing.event.registrationTeam', compact('slug', 'penggunas', 'user_logged'));
    }
}
