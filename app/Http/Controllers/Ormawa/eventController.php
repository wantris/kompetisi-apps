<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
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
        $navTitle = '<span class="micon dw dw-clipboard1 mr-2"></span>Buat Event';
        return view('ormawa.event.add', compact('navTitle'));
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
