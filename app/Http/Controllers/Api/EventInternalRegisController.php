<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\EventInternal;
use App\EventInternalRegistration;
use App\SertifikatEventInternal;

class EventInternalRegisController extends Controller
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

            if (request()->idevent) {
                $registrations = $this->getDataByEvent(request()->idevent);
            } else {
                $registrations = $this->getAllData();
            }

            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $registrations
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 404,
                'message' => "Data not found!",
                'data' => null
            ], 404);
        }
    }

    public function getAllData()
    {
        $registrations = EventInternalRegistration::with('timRef', 'participantRef', 'timRef.timDetailRef.participantRef', 'tahapanRegisRef.tahapanEventInternal')
            ->with(array('eventInternalRef' => function ($query) {
                $query->select('id_event_internal', 'nama_event', 'role');
            }))->get();

        foreach ($registrations as $item) {
            $event = EventInternal::where('id_event_internal', $item->event_internal_id)->first();

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

    public function getDataByEvent($id_eventinternal)
    {
        $registrations = EventInternalRegistration::with('timRef', 'participantRef', 'timRef.timDetailRef.participantRef', 'tahapanRegisRef.tahapanEventInternal', 'sertifikatRef')
            ->with(array('eventInternalRef' => function ($query) {
                $query->select('id_event_internal', 'nama_event', 'role');
            }))
            ->where('event_internal_id', $id_eventinternal)->get();

        foreach ($registrations as $item) {
            $event = EventInternal::where('id_event_internal', $item->event_internal_id)->first();

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


    public function exportPendaftar()
    {
        if (request()->eventid) {
            try {
                $event = EventInternal::find(request()->eventid);
                if ($event) {
                    $registrations = EventInternalRegistration::with('timRef.timDetailRef.participantRef', 'timRef.timDetailRef.penggunaMhsRef', 'timRef.timDetailRef.penggunaParticipantRef', 'participantRef', 'tahapanRegisRef.tahapanEventInternal', 'sertifikatRef')->where('event_internal_id', $event->id_event_internal)->get();

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
                                $item->timRef->pembimbing_ref = $dosen;
                            }

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

    public function downloadSertificate()
    {
        $sertif_id = request()->sertificateid;
        if ($sertif_id) {
            $sertif = SertifikatEventInternal::find($sertif_id);

            return response()->json([
                "code" => 200,
                "status" => 1,
                "message" => "Get data success",
                "data" => $sertif
            ], 200);
        } else {
            return response()->json([
                "code" => 404,
                "status" => 1,
                "message" => "Sertificate id required",
                "data" => null
            ], 404);
        }
    }
}
