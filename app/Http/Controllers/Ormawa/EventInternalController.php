<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\{EventInternal, EventInternalDetail, Ormawa, KategoriEvent, TipePeserta};
use App\Http\Requests\EventInternalStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EventInternalController extends Controller
{
    public function index(){

    }
    public function add()
    {
        $ormawa = Ormawa::find(Session::get('id_ormawa'));
        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();
        
        if($ormawa){
            $navTitle = '<span class="micon dw dw-clipboard1 mr-2"></span>Buat Event';
            return view('ormawa.event_internal.add', compact('navTitle','ormawa','kategoris','tipes'));
        }else{
            return redirect()->back()->with('failed', 'Data ormawa invalid, harap login');
        }
    }

    public function saveForm(EventInternalStoreRequest $req){
        $validated = $req->validated();
        dd($req->all());
        $nameBanner = null;
        $namePoster = null;
        
        if ($req->file('poster')) {
            $resorcePoster = $req->file('poster');
            $namePoster   = "poster_" . rand(0000, 9999) . "." . $resorcePoster->getClientOriginalExtension();
            $resorcePoster->move(\base_path() . "/public/assets/img/kompetisi-thumb/", $namePoster);
        }
        if ($req->file('banner')) {
            $resorceBanner = $req->file('banner');
            $nameBanner   = "banner_" . rand(0000, 9999) . "." . $resorceBanner->getClientOriginalExtension();
            $resorceBanner->move(\base_path() . "/public/assets/img/banner-komp/", $nameBanner);
        }
        
        try{
            $ei = new EventInternal();
            $ei->ormawa_id = Session::get('id_ormawa');
            $ei->nama_event = $req->event_title;
            $ei->kategori_id = $req->category;
            $ei->tipe_peserta_id = $req->jenis_peserta;
            $ei->maks_participant = $req->peserta;
            $ei->role = $req->jenis;
            $ei->tgl_buka = $req->tgl_mulai;
            $ei->tgl_tutup = $req->tgl_tutup;
            $ei->deskripsi = $req->deskripsi;
            $ei->ketentuan = $req->ketentuan;
            $ei->status = 0;
            $ei->poster_image = $namePoster;
            $ei->banner_image = $nameBanner;
            $ei->save();

            if($ei){
                $eid = new EventInternalDetail();
                $eid->event_internal_id = $ei->id_event_internal;
                $eid->is_validated_pembina = 0;
                $eid->is_validated_wadir3 = 0;
                $eid->save();
            }

            return "berhasil";
        }catch(\Throwable $err){
            dd($err);
        }

    }
}
