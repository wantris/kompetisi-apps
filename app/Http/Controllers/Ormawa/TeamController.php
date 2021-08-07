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
    protected $api_dosen;
    protected $api_mahasiswa;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->api_mahasiswa = new ApiMahasiswaController;
            $this->api_dosen = new ApiDosenController;
            return $next($request);
        });
    }

    public function detail($id_tim)
    {

        $navTitle = '<span class="micon dw dw-user-11 mr-2"></span>Detail Team';

        $tim = TimEvent::find($id_tim);

        // Get all dosen
        $dosens = $this->api_dosen->getAllDosen();

        // Get nama dosen
        if ($tim->nidn) {
            $tim->dosenRef = null;
            $dosen =  $this->api_dosen->getDosenOnlySomeField($tim->nidn);
            if ($dosen) {
                $tim->dosenRef = $dosen;
            }
        }

        // Get name of mahasiswa
        foreach ($tim->timDetailRef as $detail) {
            if ($detail->nim) {
                $detail->mahasiswaRef = null;
                $mhs = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
                if ($mhs) {
                    $detail->mahasiswaRef = $mhs;
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
}
