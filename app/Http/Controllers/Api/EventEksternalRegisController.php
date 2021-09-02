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
                    $item->mahasiswa_ref = null;
                    if ($item->nim) {
                        try {
                            $mhs = $this->api_mahasiswa->getMahasiswaSomeField($item->nim);
                            $item->mahasiswa_ref = $mhs;
                        } catch (\Throwable $err) {
                        }
                    }
                } else {
                    foreach ($item->timRef->timDetailRef as $detail) {
                        $detail->mahasiswa_ref = null;
                        if ($detail->nim) {
                            try {
                                $mhs = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
                                $detail->mahasiswa_ref = $mhs;
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
        $registrations = EventEksternalRegistration::with('timRef', 'fileEeRegisRef', 'prestasiRef', 'tahapanRegisRef.tahapanEventEksternal')->with(array('eventEksternalRef' => function ($query) {
            $query->select('id_event_eksternal', 'nama_event', 'role');
        }))->where('event_eksternal_id', $id_eventeksternal)->get();

        foreach ($registrations as $item) {
            $event = EventEksternal::where('id_event_eksternal', $item->event_eksternal_id)->first();

            if ($event) {
                if ($event->role != "Team") {
                    $item->mahasiswa_ref = null;
                    if ($item->nim) {
                        $mhs = $this->api_mahasiswa->getMahasiswaSomeField($item->nim);
                        if ($mhs) {
                            $item->mahasiswa_ref = $mhs;
                        }
                    }
                } else {
                    foreach ($item->timRef->timDetailRef as $detail) {
                        $detail->mahasiswa_ref = null;
                        if ($detail->nim) {
                            $mhs = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
                            if ($mhs) {
                                $detail->mahasiswa_ref = $mhs;
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
    }

    public function exportPendaftar()
    {
        if (request()->eventid) {
            try {
                $event = EventEksternal::find(request()->eventid);
                $registrations = EventEksternalRegistration::with('timRef', 'timRef.timDetailRef.penggunaMhsRef', 'prestasiRef', 'tahapanRegisRef.tahapanEventEksternal')->where('event_eksternal_id', request()->eventid)->get();

                if ($event) {
                    if ($event->role != "Team") {
                        foreach ($registrations as $item) {
                            $item->mahasiswa_ref = null;
                            if ($item->nim) {
                                $mhs = $this->api_mahasiswa->getMahasiswaSomeField($item->nim);
                                if ($mhs) {
                                    $item->mahasiswa_ref = $mhs;
                                }
                            }
                        }
                    } else {
                        foreach ($registrations as $item) {

                            $item->timRef->pembimbing_ref = null;
                            if ($item->timRef->nidn) {
                                $dosen = $this->api_dosen->getDosenOnlySomeField($item->timRef->nidn);
                                if ($dosen) {
                                    $item->timRef->pembimbing_ref = $dosen;
                                }
                            }

                            foreach ($item->timRef->timDetailRef as $detail) {
                                $detail->mahasiswa_ref = null;
                                if ($detail->nim) {
                                    $mhs = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);

                                    if ($mhs) {
                                        $detail->mahasiswa_ref = $mhs;
                                    }
                                }
                            }
                        }
                    }

                    return response()->json([
                        "code" => 200,
                        "status" => 1,
                        "message" => "Get data success",
                        "data" => $registrations
                    ], 200);
                }

                return response()->json([
                    "code" => 404,
                    "status" => 1,
                    "message" => "Event not found",
                    "data" => null
                ], 404);
            } catch (\Throwable $err) {
                return response()->json([
                    "code" => 500,
                    "status" => 1,
                    "message" => $err,
                    "data" => null
                ], 500);
            }
        }

        return response()->json([
            "code" => 500,
            "status" => 1,
            "message" => "Event id required",
            "data" => null
        ], 500);
    }
}
