<?php

namespace App\Http\Controllers\Ormawa;

use App\CakupanOrmawa;
use App\EventEksternal;
use App\EventInternal;
use App\Http\Controllers\Controller;
use App\Pembina;
use App\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        if (Session::get('is_ormawa') == "1") {
            $cakupan = CakupanOrmawa::where('ormawa_id', Session::get('id_ormawa'))->first();
            $cakupan_id = null;
            if ($cakupan) {
                $cakupan_id = $cakupan->id_cakupan_ormawa;
            }
            $eia = EventInternal::where('status', 1)->where('ormawa_id', Session::get('id_ormawa'))->get();
            $eea = EventEksternal::where('status', 1)->where('cakupan_ormawa_id', $cakupan_id)->get();
            $ei = EventInternal::where('ormawa_id', Session::get('id_ormawa'))->get();
            $ee = EventEksternal::where('cakupan_ormawa_id', $cakupan_id)->get();
            $eis = EventInternal::where('status', 0)->where('ormawa_id', Session::get('id_ormawa'))->get();
            $ees = EventEksternal::where('status', 0)->where('cakupan_ormawa_id', $cakupan_id)->get();


            $navTitle = '<span class="micon dw dw-home mr-2"></span>Dashboard';

            // Jika ada pembina
            if (Session::get('is_pembina') == "1") {
                $pembinas = Pembina::where('nidn', Session::get('nidn'))->get();
                $penggunas = Pengguna::where('nidn', Session::get('nidn'))->first();
                return view('ormawa.dashboard', compact(
                    'navTitle',
                    'eia',
                    'eea',
                    'ei',
                    'ee',
                    'eis',
                    'ees',
                    'penggunas',
                    'pembinas'
                ));
            } else {
                return view('ormawa.dashboard', compact(
                    'navTitle',
                    'eia',
                    'eea',
                    'ei',
                    'ee',
                    'eis',
                    'ees'
                ));
            }
        } else {
            // Jika yg login hanya dosen
            $pembina = Pembina::where('nidn', Session::get('nidn'))->get();
            $pengguna = Pengguna::where('nidn', Session::get('nidn'))->first();
            return view('ormawa.dashboard', compact(
                'navTitle',
                'pengguna',
                'pembina'
            ));
        }
    }
}
