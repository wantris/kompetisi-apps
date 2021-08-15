<?php

namespace App\Http\Controllers\peserta;

use App\EventInternalRegistration;
use App\Http\Controllers\Controller;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Pengguna;
use App\EventInternal;
use App\EventEksternalRegistration;
use App\TimEvent;
use App\PrestasiEventInternal;
use App\PrestasiEventEksternal;

class ProfileController extends Controller
{
    protected $api_mahasiswa;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->api_mahasiswa = new ApiMahasiswaController;
            return $next($request);
        });
    }

    public function getByRegis()
    {
        if (request()->nim) {
            $pengguna =  Pengguna::where('nim', request()->nim)->first();
        } else {
            $pengguna =  Pengguna::where('participant_id', request()->participantid)->first();
        }

        if ($pengguna) {
            return $this->index($pengguna->id_pengguna);
        } else {
            return redirect()->back()->with('failed', 'Data tidak ada');
        }
    }

    public function index($id_pengguna)
    {

        $pengguna = Pengguna::find($id_pengguna);
        if ($pengguna) {
            $pengguna->mahasiswaRef = null;
            if ($pengguna->nim) {
                $mhs = $this->api_mahasiswa->getMahasiswaSomeField($pengguna->nim);
                if ($mhs) {
                    $pengguna->mahasiswaRef = $mhs;
                    $navTitle = '<span class="micon dw dw-user-12 mr-2"> ' . $pengguna->mahasiswaRef->mahasiswa_nama . '</span>';
                } else {
                    $navTitle = '<span class="micon dw dw-user-12 mr-2"> ' . $pengguna->username . '</span>';
                }
            } else {
                $navTitle = '<span class="micon dw dw-user-12 mr-2"> ' . $pengguna->participantRef->nama_participant . '</span>';
            }
            return view('peserta.account.profile', compact('navTitle', 'pengguna'));
        }
    }

    public function getAllEvent($id_pengguna)
    {
        $pengguna = Pengguna::find($id_pengguna);

        $pendaftaran = collect();
        $pendaftaran_internals = $this->getEventInternal($pengguna);
        $pendaftaran_eksternals = $this->getEventEksternal($pengguna);
        foreach ($pendaftaran_internals as $internal) {
            $pendaftaran->push($internal);
        }

        foreach ($pendaftaran_eksternals as $eksternal) {
            $pendaftaran->push($eksternal);
        }

        $convert_pendaftaran = $pendaftaran->groupBy(function ($val) {
            return \Carbon\Carbon::parse($val->created_at)->format('M_Y');
        });

        return response()->json($convert_pendaftaran);
    }

    public function getEventInternal($pengguna)
    {
        $pendaftaran = collect();
        $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
            $query->where('status', 'Done');
        })->get();

        $regis_individus = EventInternalRegistration::with('eventInternalRef', 'eventInternalRef.ormawaRef')->where(function ($query) use ($pengguna) {
            if ($pengguna->nim) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
        })->get();

        if ($regis_individus->count() > 0) {
            foreach ($regis_individus as $regis) {
                $pendaftaran->push($regis);
            }
        }

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $regis_tim = EventInternalRegistration::with('eventInternalRef', 'eventInternalRef.ormawaRef')->where('tim_event_id', $tim->id_tim_event)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 1);
                })->first();

                if ($regis_tim) {
                    $pendaftaran->push($regis_tim);
                }
            }
        }

        return $pendaftaran;
    }

    public function getEventEksternal($pengguna)
    {
        $pendaftaran = collect();

        $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            }
            $query->where('status', 'Done');
        })->get();

        $regis_individus = EventEksternalRegistration::with('eventEksternalRef', 'eventEksternalRef.cakupanOrmawaRef.ormawaRef')->where(function ($query) use ($pengguna) {
            if ($pengguna->nim) {
                $query->where('nim', $pengguna->nim);
            }
        })->get();

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $regis_tim = EventEksternalRegistration::with('eventEksternalRef')->where('tim_event_id', $tim->id_tim_event)->whereHas('eventEksternalRef', function ($query) {
                    $query->where('status', 1);
                })->first();

                if ($regis_tim) {
                    $pendaftaran->push($regis_tim);
                }
            }
        }

        if ($regis_individus->count() > 0) {
            foreach ($regis_individus as $regis) {
                $pendaftaran->push($regis);
            }
        }

        return $pendaftaran;
    }

    public function getPrestasi($id_pengguna)
    {
        $pengguna = Pengguna::find($id_pengguna);
        $all_prestasi = collect();
        if ($pengguna) {

            $prestasi_internal = $this->getPrestasiInternal($pengguna);
            $prestasi_eksternal = $this->getPrestasiEksternal($pengguna);

            if ($prestasi_internal->count() > 0) {
                foreach ($prestasi_internal as $internal) {
                    $all_prestasi->push($internal);
                }
            }

            if ($prestasi_eksternal->count() > 0) {
                foreach ($prestasi_eksternal as $eksternal) {
                    $all_prestasi->push($eksternal);
                }
            }
        }

        return response()->json($all_prestasi);
    }

    public function getPrestasiInternal($pengguna)
    {

        $pendaftaran = collect();
        $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
            $query->where('status', 'Done');
        })->get();

        $regis_individus = EventInternalRegistration::where(function ($query) use ($pengguna) {
            if ($pengguna->nim) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
        })->get();

        if ($regis_individus->count() > 0) {
            foreach ($regis_individus as $regis) {
                $pendaftaran->push($regis);
            }
        }

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $regis_tim = EventInternalRegistration::where('tim_event_id', $tim->id_tim_event)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 1);
                })->first();

                if ($regis_tim) {
                    $pendaftaran->push($regis_tim);
                }
            }
        }

        $prestasi = collect();
        if ($pendaftaran->count() > 0) {
            foreach ($pendaftaran as $p) {
                $pres = PrestasiEventInternal::with('eventInternalRegisRef.eventInternalRef', 'eventInternalRegisRef.eventInternalRef.ormawaRef')->where('event_internal_registration_id', $p->id_event_internal_registration)->first();
                if ($pres) {
                    $prestasi->push($pres);
                }
            }
        }
        return $prestasi;
    }

    public function getPrestasiEksternal($pengguna)
    {
        $pendaftaran = collect();

        $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            }
            $query->where('status', 'Done');
        })->get();

        $regis_individus = EventEksternalRegistration::where(function ($query) use ($pengguna) {
            if ($pengguna->nim) {
                $query->where('nim', $pengguna->nim);
            }
        })->get();

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $regis_tim = EventEksternalRegistration::where('tim_event_id', $tim->id_tim_event)->whereHas('eventEksternalRef', function ($query) {
                    $query->where('status', 1);
                })->first();

                if ($regis_tim) {
                    $pendaftaran->push($regis_tim);
                }
            }
        }

        if ($regis_individus->count() > 0) {
            foreach ($regis_individus as $regis) {
                $pendaftaran->push($regis);
            }
        }

        $prestasi = collect();
        if ($pendaftaran->count() > 0) {
            foreach ($pendaftaran as $p) {
                $pres = PrestasiEventEksternal::with('eventEksternalRegisRef.eventEksternalRef', 'eventEksternalRegisRef.eventEksternalRef.cakupanOrmawaRef.ormawaRef')->where('event_eksternal_regis_id', $p->id_event_eksternal_registration)->first();
                if ($pres) {
                    $prestasi->push($pres);
                }
            }
        }

        return $prestasi;
    }
}
