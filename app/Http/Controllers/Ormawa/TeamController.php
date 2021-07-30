<?php

namespace App\Http\Controllers\ormawa;

use App\Http\Controllers\Controller;
use App\TimEvent;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\Http\Controllers\endpoint\ApiMahasiswaController;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->api_mahasiswa = new ApiMahasiswaController;
        $this->api_dosen = new ApiDosenController;
    }

    public function detail($id_tim)
    {

        $navTitle = '<span class="micon dw dw-user-11 mr-2"></span>Detail Team';

        $tim = TimEvent::find($id_tim);

        // Get all dosen
        $dosens = $this->api_dosen->getAllDosen();

        // Get nama dosen
        if ($tim->nidn) {
            $tim->nama_dosen = $tim->nidn;
            $tim->nama_dosen =  $this->getDosenSingle($tim->nidn);
        }

        // Get name of mahasiswa
        foreach ($tim->timDetailRef as $detail) {
            if ($detail->nim) {
                $detail->nama_mhs = $detail->nim;
                try {
                    $detail->nama_mhs = $this->getMahasiswaByNim($detail->nim)->nama;
                } catch (\Throwable $err) {
                }
            }
        }


        return view('ormawa.tim.detail', compact('tim', 'dosens', 'navTitle'));
    }

    public function ajukanPembimbing(Request $request, $id_tim)
    {
        $nidn = $request->nidn;

        try {
            $pengajuan = TimEvent::where('id_tim_event', $id_tim)->update([
                'nidn' => $nidn
            ]);

            return redirect()->back()->with('success', 'Pengajuan Berhasil');
        } catch (\Throwable $err) {
            dd($err);
        }
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

    public function getAllDosen()
    {
        $dosens = null;

        try {
            $client = new Client();
            $url = env("SOURCE_API") . "dosen/";
            $rDosens = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $dosens = json_decode($rDosens->getBody());
        } catch (\Throwable $err) {
        }

        return $dosens;
    }

    public function getDosenSingle($nidn)
    {
        try {
            $client = new Client();
            $url = env("SOURCE_API") . "dosen/" . $nidn;
            $rDosen = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $dosen = json_decode($rDosen->getBody());

            return $dosen->nama_dosen;
        } catch (\Throwable $err) {
        }
    }
}
