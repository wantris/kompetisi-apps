<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ormawa;
use App\KategoriEvent;
use App\Pengguna;
use App\EventEksternalRegistration;
use App\EventEksternal;
use App\TimEvent;
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
        }

        return $inactive_regis;
    }
}
