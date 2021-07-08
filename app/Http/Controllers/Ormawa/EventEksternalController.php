<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\{Ormawa, KategoriEvent};
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class EventEksternalController extends Controller
{
      public function add()
    {
        $ormawa = Ormawa::find(Session::get('id_ormawa'));
        $kategori = KategoriEvent::all();
        
        if($ormawa){
            $navTitle = '<span class="micon dw dw-clipboard1 mr-2"></span>Buat Event';
            return view('ormawa.event_eksternal.add', compact('navTitle','ormawa'));
        }else{
            return redirect()->back()->with('failed', 'Data ormawa invalid, harap login');
        }
    }
}
