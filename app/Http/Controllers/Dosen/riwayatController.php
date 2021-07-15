<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Pembina;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class riwayatController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-center-align mr-2"></span>Riwayat Pembina';
        $pembinas = Pembina::where('nidn', Session::get('nidn'))->get();
        try {
            // single dosen
            $client = new Client();
            $url = env("SOURCE_API") . "dosen/" . Session::get('nidn');
            $rDosens = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $dosen = json_decode($rDosens->getBody());

            return view('dosen.riwayat.index', compact('pembinas', 'navTitle', 'dosen'));
        } catch (\Throwable $err) {
            $dosen = null;
            return view('dosen.riwayat.index', compact('pembinas', 'navTitle', 'dosen'));
        }
    }
}
