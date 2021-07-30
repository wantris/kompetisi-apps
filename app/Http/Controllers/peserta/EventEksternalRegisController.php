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
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Controllers\endpoint\ApiDosenController;

class EventEksternalRegisController extends Controller
{
    protected $api_mahasiswa;
    protected $api_dosen;
    protected $pengguna;

    public function __construct()
    {
        $this->api_mahasiswa = new ApiMahasiswaController;
        $this->api_dosen = new ApiDosenController;
        $this->pengguna = Pengguna::find(Session::get('id_pengguna'));
    }

    public function getAllRegistration()
    {
        $pengguna = $this->pengguna;

        if ($pengguna) {

            $registrations = collect();

            $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
                $query->where('nim', $pengguna->nim);
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
                            $item->mahasiswaRef = $item->nim;
                            $mhs = $this->api_mahasiswa->getMahasiswaByNim($item->nim);
                            if ($mhs) {
                                $item->mahasiswaRef = $mhs;
                            }
                        } else {
                            foreach ($item->timRef->timDetailRef as $detail) {
                                if ($detail->role == "ketua") {
                                    $detail->mahasiswaRef = $detail->nim;
                                    $mhs = $this->api_mahasiswa->getMahasiswaByNim($detail->nim);
                                    if ($mhs) {
                                        $detail->mahasiswaRef = $mhs;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            return $registrations;
        }
    }
}
