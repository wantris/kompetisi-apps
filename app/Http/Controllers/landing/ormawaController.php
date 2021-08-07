<?php

namespace App\Http\Controllers\landing;

use App\CakupanOrmawa;
use App\EventEksternal;
use App\EventInternal;
use App\Http\Controllers\Controller;
use App\Ormawa;
use Illuminate\Http\Request;

class ormawaController extends Controller
{
    public function index($id_ormawa)
    {
        $ormawa = Ormawa::find($id_ormawa);
        $event_internals = $this->getEventInternal($id_ormawa);
        $event_eksternals = $this->getEventEksternal($id_ormawa);

        return view('landing.ormawa.index', compact('ormawa', 'event_internals', 'event_eksternals'));
    }

    public function getEventInternal($id_ormawa)
    {
        $event_internals = EventInternal::where('ormawa_id', $id_ormawa)->get();

        return $event_internals;
    }

    public function getEventEksternal($id_ormawa)
    {
        $cakupan = CakupanOrmawa::where('ormawa_id', $id_ormawa)->first();

        $event_eksternals = collect();
        if ($cakupan) {
            $event_eksternals = EventEksternal::where('cakupan_ormawa_id', $cakupan->id_cakupan_ormawa)->get();
        }

        return $event_eksternals;
    }
}
