<?php

namespace App\Http\Controllers\Ormawa;

use App\EventEksternal;
use App\EventInternal;
use App\Http\Controllers\Controller;
use App\Http\Requests\TimelineStoreRequest;
use App\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index(){
        $navTitle = '<i class="icon-copy dw dw-time-management mr-2"></i>Timeline Event';

        $tlis = Timeline::with('eventInternalRef')->where('event_internal_id', '!=', null)->get();
        $tles = Timeline::with('eventEksternalRef')->where('event_eksternal_id', '!=', null)->get();
        return view('ormawa.timeline.index', compact('tlis','tles','navTitle'));
    }

    public function add($type){
        $navTitle = '<i class="icon-copy dw dw-time-management mr-2"></i>Tambah Timeline Event';
        if($type == "eventinternal"){
            $eis = EventInternal::all();
            $title = "Tambah Timeline Internal";
            return view('ormawa.timeline.add', compact('eis','navTitle', 'title' ,'type'));
        }else{
            $ees = EventEksternal::all();
            $title = "Tambah Timeline Eksternal";
            return view('ormawa.timeline.add', compact('ees','navTitle', 'title', 'type'));
        }
    }

    public function save(TimelineStoreRequest $req, $type){
        $validated = $req->validated();

        try{
            $tl = new Timeline();
            if($type == "eventinternal"){
                $tl->event_internal_id = $req->event_id;
                $tl->event_eksternal_id = null;
            }elseif($type == "eventeksternal"){
                $tl->event_internal_id = null;
                $tl->event_eksternal_id = $req->event_id;
            }

            $tl->title = $req->title;
            $tl->tgl_jadwal = $req->tgl_jadwal;
            $tl->deskripsi = $req->deskripsi;
            $tl->save();

            return redirect()->route('ormawa.timeline.index')->with('success','Tambah timeline berhasil');
        }catch(\Throwable $err){
            dd($err);
            return redirect()->back()->with('faield','Tambah timeline gagal');
        }
    }

    public function editInternal($id_timeline){
        $tl = Timeline::find($id_timeline);
        $eis = EventInternal::all();
        $type = "eventinternal";
        $title = "Update Timeline Internal";
        if($tl){
            $navTitle = '<i class="icon-copy dw dw-time-management mr-2"></i>Update Timeline Event';
            return view('ormawa.timeline.edit', compact('eis','navTitle', 'tl', 'type','title'));
        }else{
            return redirect()->back()->with('failed','Timeline tidak ada');
        }
    }

    public function editEksternal($id_timeline){
        $tl = Timeline::find($id_timeline);
        $eis = EventEksternal::all();
        $type = "eventeksternal";
        if($tl){
            $navTitle = '<i class="icon-copy dw dw-time-management mr-2"></i>Update Timeline Event';
            return view('ormawa.timeline.edit', compact('eis','navTitle', 'tl', 'type'));
        }else{
            return redirect()->back()->with('failed','Timline tidak ada');
        }
    }

    public function update(TimelineStoreRequest $req, $type){
        $validated = $req->validated();

        try{
            $tl = Timeline::find($req->id_timeline);
            if($type == "eventinternal"){
                $tl->event_internal_id = $req->event_id;
                $tl->event_eksternal_id = null;
            }elseif($type == "eventeksternal"){
                $tl->event_internal_id = null;
                $tl->event_eksternal_id = $req->event_id;
            }

            $tl->title = $req->title;
            $tl->tgl_jadwal = $req->tgl_jadwal;
            $tl->deskripsi = $req->deskripsi;
            $tl->save();

            return redirect()->route('ormawa.timeline.index')->with('success','Update timeline berhasil');
        }catch(\Throwable $err){
            dd($err);
            return redirect()->back()->with('faield','Update timeline gagal');
        }
    }

    public function delete(Request $request, $id_timeline)
    {
        Timeline::destroy($id_timeline);
        return response()->json([
            "status" => 1,
            "message" => "timeline berhasil dihapus",
        ]);
    }
}
