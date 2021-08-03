<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\EventEksternal;
use App\EventEksternalRegistration;

class EventEksternalRegisController extends Controller
{
    protected $api_mahasiswa;
    protected $api_dosen;

    public function __construct()
    {
        $this->api_mahasiswa = new ApiMahasiswaController;
        $this->api_dosen = new ApiDosenController;
    }

    public function index()
    {
        try {
            if (!request()->idevent) {
                $registrations = $this->getAllData();
            } else {
                $registrations = $this->getDataByEvent(request()->idevent);
            }

            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $registrations
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 500,
                'message' => "Something Error!",
                'data' => $err
            ], 500);
        }
    }

    public function getAllData()
    {
        $registrations = EventEksternalRegistration::with('timRef')->with(array('eventEksternalRef' => function ($query) {
            $query->select('id_event_eksternal', 'nama_event', 'role');
        }))->get();

        foreach ($registrations as $item) {
            $event = EventEksternal::where('id_event_eksternal', $item->event_eksternal_id)->first();

            if ($event) {
                if ($event->role != "Team") {
                    $item->mahasiswaRef = null;
                    if ($item->nim) {
                        try {
                            $mhs = $this->api_mahasiswa->getMahasiswaSomeField($item->nim);
                            $item->mahasiswaRef = $mhs;
                        } catch (\Throwable $err) {
                        }
                    }
                } else {
                    foreach ($item->timRef->timDetailRef as $detail) {
                        $detail->mahasiswaRef = null;
                        if ($detail->nim) {
                            try {
                                $mhs = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
                                $detail->mahasiswaRef = $mhs;
                            } catch (\Throwable $err) {
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
    }

    public function getDataByEvent($id_eventeksternal)
    {
        $registrations = EventEksternalRegistration::with('timRef')->with(array('eventEksternalRef' => function ($query) {
            $query->select('id_event_eksternal', 'nama_event', 'role');
        }))->where('event_eksternal_id', $id_eventeksternal)->get();

        foreach ($registrations as $item) {
            $event = EventEksternal::where('id_event_eksternal', $item->event_eksternal_id)->first();

            if ($event) {
                if ($event->role != "Team") {
                    $item->mahasiswaRef = null;
                    if ($item->nim) {
                        try {
                            $mhs = $this->api_mahasiswa->getMahasiswaSomeField($item->nim);
                            $item->mahasiswaRef = $mhs;
                        } catch (\Throwable $err) {
                        }
                    }
                } else {
                    foreach ($item->timRef->timDetailRef as $detail) {
                        $detail->mahasiswaRef = null;
                        if ($detail->nim) {
                            try {
                                $mhs = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
                                $detail->mahasiswaRef = $mhs;
                            } catch (\Throwable $err) {
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
    }
}
