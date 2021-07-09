<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\{EventInternal, EventInternalDetail, EventInternalRegistration, FileEventInternalDetail, Ormawa, KategoriEvent, TipePeserta};
use App\Http\Requests\EventInternalStoreRequest;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class EventInternalController extends Controller
{
    public function index(){
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Event Internal';
        $eias = EventInternal::with('kategoriRef','tipePesertaRef')->where('ormawa_id', Session::get('id_ormawa'))->where('status', 1)->get();
        $eis = EventInternal::with('kategoriRef','tipePesertaRef')->where('ormawa_id', Session::get('id_ormawa'))->get();
        $eiss = EventInternal::with('kategoriRef','tipePesertaRef')->where('ormawa_id', Session::get('id_ormawa'))->where('status', 0)->get();

        return view('ormawa.event_internal.index', compact('eis','navTitle', 'eias','eiss'));
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
            $ei->status_validasi = 0;
            $ei->poster_image = $namePoster;
            $ei->banner_image = $nameBanner;
            $ei->save();

            // Store event internal detail
            if($ei){
                $eid = new EventInternalDetail();
                $eid->event_internal_id = $ei->id_event_internal;
                $eid->is_validated_pembina = 0;
                $eid->is_validated_wadir3 = 0;
                $eid->save();
            }

            // Jika ada berkas untuk pendaftaran
            if($req->file('file_dokumen')){
                foreach($req->file_dokumen as $key => $item){
                    $resorcedokumen = $item;
                    $namedokumen   = "dokumen_" . rand(0000, 9999) . "." . $resorcedokumen->getClientOriginalExtension();
                    $resorcedokumen->move(\base_path() . "/public/assets/file/dokumen-event/", $namedokumen);
                }

                $feid = new FileEventInternalDetail();
                $feid->event_internal_detail_id = $eid->id_event_internal_detail;
                $feid->nama_file = $req->nama_dokumen[$key];
                $feid->filename = $namedokumen;
                $feid->tipe = "pendaftaran";
                $feid->save();
            }

            return "berhasil";
        }catch(\Throwable $err){
            dd($err);
        }
    }

    public function lihatPublik($id_eventinternal){
        $ei = EventInternal::with('kategoriRef','tipePesertaRef','ormawaRef','pengajuanRef')->find($id_eventinternal);
        $feis = FileEventInternalDetail::whereHas('eventDetailRef', function($q) use($id_eventinternal){
            $q->where('event_internal_id', '=', $id_eventinternal);
        })->where('tipe','pendaftaran')->get();
    
        if($ei){
            $slug = Str::slug($ei->nama_event);
            return view('ormawa.event_internal.publik_detail', compact('ei','slug','feis'));
        } 
    }

    public function edit($id_eventinternal){
        $ei = EventInternal::find($id_eventinternal);

        if(!$ei){
            return redirect()->back()->with('failed','Data event internal tidak ada');
        }

        $navTitle = '<i class="icon-copy dw dw-rocket mr-2"></i>Update Event internal';
        $title = "Update ". $ei->nama_event;

        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();
        $feid = FileEventInternalDetail::whereHas('eventDetailRef', function($q) use($id_eventinternal){
            $q->where('event_internal_id', '=', $id_eventinternal);
        })->where('tipe','pendaftaran')->get();
        $feip = FileEventInternalDetail::whereHas('eventDetailRef', function($q) use($id_eventinternal){
            $q->where('event_internal_id', '=', $id_eventinternal);
        })->where('tipe','pengajuan')->get();

        return view('ormawa.event_internal.edit', compact(
            'ei',
            'navTitle',
            'title',
            'kategoris',
            'tipes',
            'feid',
            'feip'
        ));
        
    }

    public function lihatPendaftar($id_eventinternal){
        $ei = EventInternal::find($id_eventinternal);
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Pendaftar '.$ei->nama_event;
        $eir = EventInternalRegistration::where('event_internal_id', $id_eventinternal)->get();

        return view('ormawa.event_internal.list_peserta', compact('navTitle', 'navTitle','eir'));
    }

    public function listPeserta($slug){
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Event Internal';

        return view('ormawa.event_internal.list_peserta', compact('slug','navTitle'));
    }

    public function updateStatus(Request $req){
        if($req->status == null){
            return redirect()->back()->with('failed','Error');
        }

        $status = $req->status;
        $ei = EventInternal::find($req->id_eventinternal);

        if(!$ei){
            return redirect()->back()->with('failed','Event internal tidak ada');
        }

        if($status == 1 && $ei->status_validasi == 0){
            return redirect()->back()->with('failed','Event harus divalidasi terlebih dahulu');
        }

        $ei->status = $status;
        $ei->save();
        return redirect()->back()->with('success','Update status berhasil');
    }



    public function delete(Request $request, $id_eventinternal)
    {
        $ei = EventInternal::find($id_eventinternal);
        EventInternal::destroy($id_eventinternal);
        return response()->json([
            "status" => 1,
            "message" => $ei->nama_event." berhasil dihapus",
        ]);
    }
}
