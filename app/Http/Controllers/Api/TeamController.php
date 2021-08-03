<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TimEvent;

class TeamController extends Controller
{
    protected $api_mahasiswa;
    protected $api_dosen;

    public function __construct()
    {
        $this->api_mahasiswa = new ApiMahasiswaController;
        $this->api_dosen = new ApiDosenController;
    }

    public function getAllByEventInternal()
    {
        try {
            $tims = TimEvent::with('timDetailRef', 'eventInternalRegisRef', 'timDetailRef.participantRef', 'eventInternalRegisRef.eventInternalRef')->whereHas('eventInternalRegisRef')->whereHas('timDetailRef', function ($query) {
                $query->where('status', 'Done');
            })->get();

            if ($tims->count() > 0) {
                $tims->each(function ($item, $key) {
                    foreach ($item->timDetailRef as $detail) {
                        $detail->mahasiswa_ref = null;
                        if ($detail->nim) {
                            $mhs_api = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
                            if ($mhs_api) {
                                $detail->mahasiswa_ref = $mhs_api;
                            }
                        }
                    }
                });

                return response()->json([
                    'status' => 200,
                    'message' => "Get data success!",
                    'data' => $tims
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => "Get data empty!",
                'data' => null
            ], 404);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 500,
                'message' => "Get data failed!",
                'data' => null
            ], 500);
        }

        return response()->json($tims);
    }


    public function getAllByEventEksternal()
    {
        try {
            $tims = TimEvent::with('timDetailRef', 'eventEksternalRegisRef',  'eventEksternalRegisRef.eventEksternalRef:id_event_eksternal,nama_event')->whereHas('eventEksternalRegisRef')->whereHas('timDetailRef', function ($query) {
                $query->where('status', 'Done');
            })->get();

            if ($tims->count() > 0) {
                $tims->each(function ($item, $key) {
                    $item->dosen_ref = null;
                    $dosen = $this->api_dosen->getDosenOnlySomeField($item->nidn);
                    if ($dosen) {
                        $item->dosen_ref = $dosen;
                    }

                    foreach ($item->timDetailRef as $detail) {
                        $detail->mahasiswa_ref = null;
                        if ($detail->nim) {
                            $mhs_api = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
                            if ($mhs_api) {
                                $detail->mahasiswa_ref = $mhs_api;
                            }
                        }
                    }
                });

                return response()->json([
                    'status' => 200,
                    'message' => "Get data success!",
                    'data' => $tims
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => "Get data empty!",
                'data' => null
            ], 404);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 500,
                'message' => "Get data failed!",
                'data' => null
            ], 500);
        }

        return response()->json($tims);
    }
}
