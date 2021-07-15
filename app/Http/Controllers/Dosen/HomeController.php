<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pembina;
use App\Pengguna;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        // Jika yg login hanya dosen
        $navTitle = '<span class="micon dw dw-home mr-2"></span>Dashboard';
        $pembinas = Pembina::where('nidn', Session::get('nidn'))->get();
        $penggunas = Pengguna::where('nidn', Session::get('nidn'))->first();
        return view('ormawa.dashboard', compact(
            'navTitle',
            'penggunas',
            'pembinas'
        ));
    }
}
