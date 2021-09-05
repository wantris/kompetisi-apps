<?php

namespace App\Http\Controllers\api;

use App\EventEksternalRegistration;
use App\Http\Controllers\Controller;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use Illuminate\Http\Request;

class prestasiEventEksternalController extends Controller
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
            $registrations = EventEksternalRegistration::with('eventEksternalRef:id_event_eksternal,nama_event,role,created_at')
                ->with(
                    'timRef.timDetailRef.penggunaMhsRef:id_pengguna,nim,participant_id,phone',
                    'prestasiRef',
                    'sertifikatRef'
                )->whereHas('prestasiRef')->get()->groupBy('event_eksternal_id');


            foreach ($registrations as $event) {
                foreach ($event as $item) {
                    if ($item->eventEksternalRef->role == "Individu") {

                        $item->mahasiswa_ref = null;
                        if ($item->nim) {
                            $mhs = $this->api_mahasiswa->getMahasiswaSomeField($item->nim);
                            if ($mhs) {
                                $item->mahasiswa_ref = $mhs;
                            }
                        }
                    } else {
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
            }

            return response()->json([
                "code" => 200,
                "status" => 1,
                "message" => "Get data success",
                "data" => $registrations
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                "code" => 500,
                "status" => 1,
                "message" => $err->getMessage(),
                "data" => null
            ], 500);
        }
    }
}
