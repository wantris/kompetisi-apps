<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use App\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-home mr-2"></span>Dashboard';
        // $pos_info =  DB::select(DB::raw('SHOW COLUMNS FROM PENGGUNAS'));
        // $base_columns = count($pos_info);
        // $not_null = 0;

        // foreach ($pos_info as $col) {
        //     $not_null += Pengguna::selectRaw('SUM(CASE WHEN PASSWORD IS NOT NULL THEN 1 ELSE 0  END) AS not_null')->where('id_pengguna', '=', Session::get('id_pengguna'))->first()->not_null;
        // }
        // $total = ($not_null / $base_columns) * 100;

        return view('peserta.dashboard', compact('navTitle'));
    }
}
