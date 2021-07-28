<?php

namespace App\Http\Controllers\Api;

use App\EventInternal;
use App\EventInternalDetail;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventIinternalUpdateRequest;
use App\KategoriEvent;
use App\Ormawa;
use App\TipePeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;


class EventInternalController extends Controller
{

    public function index()
    {
        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->get();
        if ($event->count() > 0) {
            return response()->json($event);
        }

        return response()->json([
            "success" => false,
            "status" => 404,
            "message" => "Data Event Internal Tidak ada",
        ]);
    }

    public function detail($id_eventinternal)
    {
        $root_url = request()->getSchemeAndHttpHost();
        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef', 'pengajuanRef', 'pengajuanRef.filePengajuan')->find($id_eventinternal);
        if ($event) {
            return response()->json($event);
        }
        return response()->json([
            "success" => false,
            "status" => 404,
            "message" => "Data Event Internal Tidak ada",
        ]);
    }

    public function save(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'ormawa_id' => 'required',
            'nama_event' => 'required',
            'kategori' => 'required',
            'tipe_peserta' => 'required',
            'maks' => 'required|integer',
            'role' => 'required',
            'tgl_buka' => 'required',
            'tgl_tutup' => 'required',
            'deskripsi' => 'required',
            'poster' => 'required',
            'banner' => 'required'
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        if ($req->file('poster')) {
            $resorcePoster = $req->file('poster');
            $namePoster   = "poster_" . rand(0000, 9999) . "." . $resorcePoster->getClientOriginalExtension();
            $resorcePoster->move(\base_path() . "/public/assets/img/kompetisi-thumb/", $namePoster);
        }
        if ($req->file('banner')) {
            $resorceBanner = $req->file('banner');
            $nameBanner   = "photo_" . rand(0000, 9999) . "." . $resorceBanner->getClientOriginalExtension();
            $resorceBanner->move(\base_path() . "/public/assets/img/banner-komp/", $nameBanner);
        }


        try {
            $event = new EventInternal();
            $event->ormawa_id = $req->ormawa_id;
            $event->nama_event = $req->nama_event;
            $event->kategori_id = $req->kategori;
            $event->tipe_peserta_id = $req->tipe_peserta;
            $event->maks_participant = $req->maks;
            $event->role = $req->role;
            $event->tgl_buka = $req->tgl_buka;
            $event->tgl_tutup = $req->tgl_tutup;
            $event->deskripsi = $req->deskripsi;
            $event->ketentuan = $req->ketentuan;
            $event->status = 0;
            $event->poster_image = $namePoster;
            $event->banner_image = $nameBanner;
            $event->save();

            if ($event) {
                $detail = new EventInternalDetail();
                $detail->event_internal_id = $event->id_event_internal;
                $detail->is_validated_pembina = 0;
                $detail->is_validated_wadir3 = 0;
                $detail->save();
            }

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Event internal berhasil diupdate",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "success" => false,
                "message" => $err,
                "status" => 500,
            ]);
        }
    }

    public function edit($id_eventinternal)
    {
        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->find($id_eventinternal);
        if ($event) {
            return response()->json($event, 200);
        }

        return response()->json([
            "success" => false,
            "status" => 404,
            "message" => "Data Event Internal Tidak ada",
        ], 404);
    }

    public function update(Request $req, $id_eventinternal)
    {
        $validator = Validator::make($req->all(), [
            'ormawa_id' => 'required',
            'nama_event' => 'required',
            'kategori' => 'required',
            'tipe_peserta' => 'required',
            'maks' => 'required|integer',
            'role' => 'required',
            'tgl_buka' => 'required',
            'tgl_tutup' => 'required',
            'deskripsi' => 'required',
            'oldPoster' => 'required',
            'oldBanner' => 'required'
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        $namePoster = $req->oldPoster;
        $nameBanner = $req->oldBanner;

        if ($req->file('poster')) {
            $resorcePoster = $req->file('poster');
            $namePoster   = "poster_" . rand(0000, 9999) . "." . $resorcePoster->getClientOriginalExtension();
            $resorcePoster->move(\base_path() . "/public/assets/img/kompetisi-thumb/", $namePoster);
        }
        if ($req->file('banner')) {
            $resorceBanner = $req->file('banner');
            $nameBanner   = "photo_" . rand(0000, 9999) . "." . $resorceBanner->getClientOriginalExtension();
            $resorceBanner->move(\base_path() . "/public/assets/img/banner-komp/", $nameBanner);
        }

        $event = EventInternal::find($id_eventinternal);
        if ($event) {
            try {
                $event->ormawa_id = $req->ormawa_id;
                $event->nama_event = $req->nama_event;
                $event->kategori_id = $req->kategori;
                $event->tipe_peserta_id = $req->tipe_peserta;
                $event->maks_participant = $req->maks;
                $event->role = $req->role;
                $event->tgl_buka = $req->tgl_buka;
                $event->tgl_tutup = $req->tgl_tutup;
                $event->deskripsi = $req->deskripsi;
                $event->ketentuan = $req->ketentuan;
                $event->poster_image = $namePoster;
                $event->banner_image = $nameBanner;
                $event->save();

                return response()->json([
                    "success" => true,
                    'status' => 200,
                    "message" => "Event internal berhasil diupdate",
                ], 200);
            } catch (\Throwable $err) {
                return response()->json([
                    "success" => false,
                    "message" => $err,
                    "status" => 500,
                ], 500);
            }
        }
    }

    public function seePengajuan($id_eventinternal)
    {
        try {
            $pengajuan = EventInternalDetail::with('eventInternalRef', 'filePengajuan')->where('event_internal_id', $id_eventinternal)->first();
            if ($pengajuan) {
                return response()->json($pengajuan, 200);
            }

            return response()->json([
                "success" => false,
                "status" => 404,
                "message" => "Data pengajuan event internal Tidak ada",
            ], 404);
        } catch (\Throwable $err) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "message" => $err,
            ], 500);
        }
    }

    public function terimaPengajuan(Request $req, $id_eventinternal_detail)
    {
        $validator = Validator::make($req->all(), [
            'event_internal_id' => 'required',
            'validate_pembina' => 'required',
            'validate_wadir3' => 'required',
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        try {
            $pengajuan = EventInternalDetail::find($id_eventinternal_detail);

            if (!$pengajuan) {
                return response()->json([
                    "success" => false,
                    "status" => 404,
                    "message" => "Data pengajuan event internal Tidak ada",
                ], 404);
            }

            $pengajuan->event_internal_id = $req->event_internal_id;
            $pengajuan->is_validated_pembina = $req->validate_pembina;
            $pengajuan->is_validated_wadir3 = $req->validate_wadir3;
            $pengajuan->save();

            // if all validate 1
            if ($req->validate_pembina == 1 && $req->validate_wadir3 == 1) {
                $this->changeStatusEvent($req->event_internal_id);
            }

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Event internal berhasil diupdate",
            ], 200);
        } catch (Throwable $err) {
            return response()->json([
                "success" => false,
                "message" => $err,
                "status" => 500,
            ], 500);
        }
    }

    public function changeStatusEvent($id_eventinternal)
    {
        EventInternal::where('id_event_internal', $id_eventinternal)->update([
            'status' => 1,
        ]);
    }
}
