<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use App\Pengguna;
use App\TimEvent;
use App\EventEksternalRegistration;
use App\EventEksternal;

class EventEksternalRegisController extends Controller
{
    public function getAllRegistration()
    {
        $pengguna = Pengguna::find(Session::get('id_pengguna'));

        if ($pengguna) {

            $registrations = collect();

            $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
                if ($pengguna->is_mahasiswa) {
                    $query->where('nim', $pengguna->nim);
                }
                $query->where('status', 'Done');
            })->get();


            if ($tims->count() > 0) {
                foreach ($tims as $tim) {
                    $regis_tim = EventEksternalRegistration::with('timRef', 'eventeksternalRef')->where('tim_event_id', $tim->id_tim_event)->first();
                    if ($regis_tim) {
                        $registrations->push($regis_tim);
                    }
                }
            }

            $regis_indivius = EventEksternalRegistration::with('eventeksternalRef')->where(function ($query) use ($pengguna) {
                if ($pengguna->nim) {
                    $query->where('nim', $pengguna->nim);
                }
            })->get();


            if ($regis_indivius->count() > 0) {
                foreach ($regis_indivius as $item) {
                    $registrations->push($item);
                }
            }

            if ($registrations->count() > 0) {
                foreach ($registrations as $item) {
                    $event = EventEksternal::where('id_event_eksternal', $item->event_eksternal_id)->first();

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
