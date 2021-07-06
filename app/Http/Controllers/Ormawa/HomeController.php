<?php

namespace App\Http\Controllers\Ormawa;

use App\CakupanOrmawa;
use App\EventEksternal;
use App\EventInternal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
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
}
