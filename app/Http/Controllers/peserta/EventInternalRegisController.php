<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use App\Http\Controllers\peserta\EventEksternalRegisController;
use App\EventInternal;
use App\EventInternalRegistration;
use App\Pengguna;
use App\TimEvent;

class EventInternalRegisController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Riwayat pendaftaran Event';

        $registrations = $this->getAllRegistration();

        $eksternal_controller = new EventEksternalRegisController;
        $eksternal_registrations = $eksternal_controller->getAllRegistration();

        return view('peserta.pendaftaran.index', compact(
            'navTitle',
            'registrations',
            'eksternal_registrations'
        ));
    }
    public function getAllRegistration()
    {
        $pengguna = Pengguna::find(Session::get('id_pengguna'));

        if ($pengguna) {

            $registrations = collect();

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
                    $regis_tim = EventInternalRegistration::with('timRef', 'eventInternalRef')->where('tim_event_id', $tim->id_tim_event)->first();
                    if ($regis_tim) {
                        $registrations->push($regis_tim);
                    }
                }
            }

            $regis_indivius = EventInternalRegistration::with('eventInternalRef', 'participantRef')->where(function ($query) use ($pengguna) {
                if ($pengguna->nim) {
                    $query->where('nim', $pengguna->nim);
                } elseif ($pengguna->participant_id) {
                    $query->where('nim', $pengguna->participant_id);
                }
            })->get();


            if ($regis_indivius->count() > 0) {
                foreach ($regis_indivius as $item) {
                    $registrations->push($item);
                }
            }

            if ($registrations->count() > 0) {
                foreach ($registrations as $item) {
                    $event = EventInternal::where('id_event_internal', $item->event_internal_id)->first();

                    if ($event) {
                        if ($event->role != "Team") {
                            $item->mahasiswaRef = null;

                            if ($item->nim) {
                                try {
                                    $mhs = $this->getMahasiswaByNim($item->nim);
                                    $item->mahasiswaRef = $mhs;
                                } catch (\Throwable $err) {
                                }
                            }
                        } else {
                            foreach ($item->timRef->timDetailRef as $detail) {
                                if ($detail->role == "ketua") {
                                    $detail->mahasiswaRef = null;
                                    if ($detail->nim) {
                                        try {
                                            $mhs = $this->getMahasiswaByNim($detail->nim);
                                            $detail->mahasiswaRef = $mhs;
                                        } catch (\Throwable $err) {
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
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
}