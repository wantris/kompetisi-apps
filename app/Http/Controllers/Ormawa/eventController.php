<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\KategoriEvent;
use App\Ormawa;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class eventController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Event';
        return view('ormawa.event.index', compact('navTitle'));
    }

    public function add()
    {
        $ormawa = Ormawa::find(Session::get('id_ormawa'));
        $kategori = KategoriEvent::all();
        
        if($ormawa){
            $navTitle = '<span class="micon dw dw-clipboard1 mr-2"></span>Buat Event';
            return view('ormawa.event.add', compact('navTitle','ormawa'));
        }else{
            return redirect()->back()->with('failed', 'Data ormawa invalid, harap login');
        }
    }

    public function saveForm(Request $request)
    {
        $value = json_encode($request->berkas);
        dd($request->all());
    }

    public function listPeserta($event)
    {
        $navTitle = '<i class="icon-copy dw dw-user-2 mr-2"></i>Daftar Peserta';
        return view('ormawa.event.list_peserta', compact('navTitle'));
    }
}
