<?php

namespace App\Http\Controllers\ormawa;

use App\EventEksternal;
use App\EventInternal;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengumumanStoreRequest;
use Illuminate\Http\Request;
use App\Pengumuman;

class PengumumanController extends Controller
{
    public function index(){
        $navTitle = '<i class="icon-copy dw dw-bell mr-2"></i>Pengumuman Event';

        $plis = Pengumuman::with('eventInternalRef')->where('event_internal_id', '!=', null)->paginate(5);
        $ples = Pengumuman::with('eventEksternalRef')->where('event_eksternal_id', '!=', null)->get();

        $eis = EventInternal::all();
        $ees = EventEksternal::all();
        return view('ormawa.pengumuman.index', compact('plis','ples','navTitle', 'eis','ees'));
    }

    public function save(PengumumanStoreRequest $req, $type){
        $validated = $req->validated();

        $namePhoto = null;
        if ($req->file('photo')) {
            $resorcePhoto = $req->file('photo');
            $namePhoto   = "pengumuman_" . rand(00000, 99999) . "." . $resorcePhoto->getClientOriginalExtension();
            $resorcePhoto->move(\base_path() . "/public/assets/img/notif-event/", $namePhoto);
        }
        
        try{
            $pn = new Pengumuman();
            $pn->title = $req->title;
            $pn->deskripsi = $req->deskripsi;
            $pn->photo = $namePhoto;
            if($type == "internal"){
                $pn->event_internal_id = $req->event_id;
            }else{
                $pn->event_eksternal_id = $req->event_id;
            }
            $pn->save();

            return redirect()->back()->with('success','Berhasil menambahkan pengumuman');
        }catch(\Throwable $err){
            dd($err);
            return redirect()->back()->with('gagal','Gagal menambahkan pengumuman');
        }
    }

    public function detail($id_pengumuman){
        $pn = Pengumuman::find($id_pengumuman);
        if($pn){
            $navTitle = '<i class="icon-copy dw dw-bell mr-2"></i>'.$pn->title;
            return view('ormawa.pengumuman.detail', compact('navTitle', 'pn'));
        }
        return redirect()->back()->with('gagal','Pengumuman tidak ada');
    }

    public function editInternal($id_pengumuman){
        
        $pn = Pengumuman::find($id_pengumuman);

        if($pn){
            $navTitle = '<i class="icon-copy dw dw-bell mr-2"></i>'.$pn->title;
            $eis = EventInternal::all();
            $ees = EventEksternal::all();
            $type = "internal";
            return view('ormawa.pengumuman.edit', compact('navTitle', 'pn','eis','ees','type'));
        }
        return redirect()->back()->with('gagal','Pengumuman tidak ada');
    }

    public function editEksternal($id_pengumuman){
        
        $pn = Pengumuman::find($id_pengumuman);

        if($pn){
            $navTitle = '<i class="icon-copy dw dw-bell mr-2"></i>'.$pn->title;
            $eis = EventInternal::all();
            $ees = EventEksternal::all();
            $type = "eksternal";
            return view('ormawa.pengumuman.edit', compact('navTitle', 'pn','eis','ees','type'));
        }
        return redirect()->back()->with('gagal','Pengumuman tidak ada');
    }

    public function update(PengumumanStoreRequest $req, $id_pengumuman){
        $validated = $req->validated();
        $pn = Pengumuman::find($id_pengumuman);
        if($pn){
            try{
                $namePhoto = $req->oldPhoto;
                if ($req->file('photo')) {
                    $resorcePhoto = $req->file('photo');
                    $namePhoto   = "pengumuman_" . rand(00000, 99999) . "." . $resorcePhoto->getClientOriginalExtension();
                    $resorcePhoto->move(\base_path() . "/public/assets/img/notif-event/", $namePhoto);
                }
                $pn->title = $req->title;
                $pn->deskripsi = $req->deskripsi;
                $pn->photo = $namePhoto;
                if($req->type == "internal"){
                    $pn->event_internal_id = $req->event_id;
                }else{
                    $pn->event_eksternal_id = $req->event_id;
                }
                $pn->save();

                return redirect()->back()->with('success','Update pengumuman berhasil');
            }catch(\Throwable $err){
                dd($err);
                return redirect()->back()->with('gagal','Gagal update pengumuman');
            }
        }

        return redirect()->back()->with('gagal','Upps data tidak ada');
    }

    public function delete(Request $request, $id_pengumuman)
    {
        Pengumuman::destroy($id_pengumuman);
        return response()->json([
            "status" => 1,
            "message" => "Pengumuman berhasil dihapus",
        ]);
    }
}
