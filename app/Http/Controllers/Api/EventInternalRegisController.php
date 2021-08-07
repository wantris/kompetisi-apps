<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\EventInternal;
use App\EventInternalRegistration;

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
        $registrations = EventInternalRegistration::with('timRef', 'participantRef', 'timRef.timDetailRef.participantRef')
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
        $registrations = EventInternalRegistration::with('timRef', 'participantRef', 'timRef.timDetailRef.participantRef')
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
}
