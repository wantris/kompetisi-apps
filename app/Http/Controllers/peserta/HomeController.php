<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use App\Pengguna;
use App\TimEvent;
use App\EventInternalRegistration;
use App\EventEksternalRegistration;
use App\EventEksternal;
use App\EventEksternalFavourite;
use App\EventInternalFavourite;
use App\PrestasiEventEksternal;
use App\PrestasiEventInternal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-home mr-2"></span>Dashboard';

        return view('peserta.dashboard', compact('navTitle'));
    }

    public function getAll()
    {
        $pengguna = Pengguna::find(Session::get('id_pengguna'));
        if ($pengguna) {
            $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                } else {
                    $query->where('participant_id', $pengguna->participant_id);
                }
                $query->where('status', 'Done');
            })->get();

            $event_active = $this->getEventActive($pengguna, $tims);
            $event_inactive = $this->getEventInactive($pengguna, $tims);
            $event_favourites = $this->getAllEventFavourite();
            $profil_has_filled = $this->countProfilHasFilled();
            $tim_count = $this->getTeamByUser();


            $event_active_count = $event_active->event_active_total;
            $event_inactive_count = $event_inactive->event_inactive_total;
            $prestasi_count = $event_active->prestasi_total + $event_inactive->prestasi_total;


            $data_dashboard = (object)[
                'event_active_count' => $event_active_count,
                'event_inactive_count' => $event_inactive_count,
                'prestasi_count' => $prestasi_count,
                'event_favourites' => $event_favourites,
                'profil_has_filled' => $profil_has_filled,
                'tim_count' => $tim_count
            ];

            return response()->json($data_dashboard);
        }
    }

    public function getEventActive($pengguna, $tims)
    {
        $active_event_internal = $this->getAllEventInternalActive($pengguna, $tims);
        $active_event_eksternal = $this->getAllEventEksternalActive($pengguna, $tims);
        $prestasi_internal = $this->getPrestasiEventInternal($active_event_internal);
        $prestasi_eksternal = $this->getPrestasiEventEksternal($active_event_eksternal);

        $event_active_total = (int)$active_event_internal->count() + (int)$active_event_eksternal->count();
        $prestasi_total = (int)$prestasi_eksternal->count() + (int)$prestasi_internal->count();


        $data_total = (object)[
            'event_active_total' => $event_active_total,
            'prestasi_total' => $prestasi_total
        ];
        return $data_total;
    }

    public function getEventInactive($pengguna, $tims)
    {
        $inactive_event_internal = $this->getAllEventInternalInactive($pengguna, $tims);
        $inactive_event_eksternal = $this->getAllEventEksternalInactive($pengguna, $tims);
        $prestasi_internal = $this->getPrestasiEventInternal($inactive_event_internal);
        $prestasi_eksternal = $this->getPrestasiEventEksternal($inactive_event_eksternal);

        $event_inactive_total = (int)$inactive_event_internal->count() + (int)$inactive_event_eksternal->count();
        $prestasi_total = (int)$prestasi_eksternal->count() + (int)$prestasi_internal->count();

        $data_total = (object)[
            'event_inactive_total' => $event_inactive_total,
            'prestasi_total' => $prestasi_total
        ];
        return $data_total;
    }


    public function getAllEventInternalActive($pengguna, $tims)
    {
        $active_regis = collect();

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $active_regis_tim = EventInternalRegistration::with('eventInternalRef')->where('tim_event_id', $tim->id_tim_event)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 1);
                })->first();

                if ($active_regis_tim) {
                    $active_regis->push($active_regis_tim);
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

        return $active_regis;
    }

    public function getAllEventEksternalActive($pengguna, $tims)
    {
        $active_regis = collect();

        if ($pengguna) {

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

    // ============== Inactive ===========================

    public function getAllEventInternalInactive($pengguna, $tims)
    {
        $active_regis = collect();

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $active_regis_tim = EventInternalRegistration::with('eventInternalRef')->where('tim_event_id', $tim->id_tim_event)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 0);
                })->first();

                if ($active_regis_tim) {
                    $active_regis->push($active_regis_tim);
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
            $query->where('status', 0);
        })->get();

        if ($active_regis_individu->count() > 0) {
            foreach ($active_regis_individu as $item) {
                $active_regis->push($item);
            }
        }

        return $active_regis;
    }

    public function getAllEventEksternalInactive($pengguna, $tims)
    {
        $inactive_regis = collect();

        if ($pengguna) {

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

    // Prestasi internal

    public function getPrestasiEventInternal($registrations)
    {
        $prestasis = collect();

        foreach ($registrations as $regis) {
            $prestasi = PrestasiEventInternal::where('event_internal_registration_id', $regis->id_event_internal_registration)->first();
            if ($prestasi) {
                $prestasis->push($prestasi);
            }
        }

        return $prestasis;
    }

    public function getPrestasiEventEksternal($registrations)
    {
        $prestasis = collect();

        foreach ($registrations as $regis) {
            $prestasi = PrestasiEventEksternal::where('event_eksternal_regis_id', $regis->id_event_eksternal_registration)->first();
            if ($prestasi) {
                $prestasis->push($prestasi);
            }
        }

        return $prestasis;
    }

    public function getAllEventFavourite()
    {
        $eventinternal_favs = EventInternalFavourite::where('pengguna_id', Session::get('id_pengguna'))->get();
        $eventeksternal_favs = EventEksternalFavourite::where('pengguna_id', Session::get('id_pengguna'))->get();

        $event_total_fav = $eventinternal_favs->count() + $eventeksternal_favs->count();
        return $event_total_fav;
    }

    public function countProfilHasFilled()
    {
        $table_name = "penggunas";
        $model = "Pengguna";
        $pos_info =  DB::select(DB::raw('SHOW COLUMNS FROM ' . $table_name));
        $column = array('alamat', 'email', 'phone', 'photo', 'facebook_url', 'twitter_url', 'insta_url', 'linkedin_url');
        $base_columns = count($column);
        $not_null = 0;
        foreach ($column as $col) {
            $not_null += app('App\\' . $model)::selectRaw('SUM(CASE WHEN ' . $col . ' IS NOT NULL THEN 1 ELSE 0 END) AS not_null')->where('id_pengguna', '=', Session::get('id_pengguna'))->first()->not_null;
        }

        return ($not_null / $base_columns) * 100;
    }

    public function getTeamByUser()
    {
        $pengguna = Pengguna::select(['nim', 'participant_id'])->where('id_pengguna', Session::get('id_pengguna'))->first();

        $tims = TimEvent::whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->nim) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
            $query->where('status', 'Done');
        })->get();

        return $tims->count();
    }
}
