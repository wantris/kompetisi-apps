<?php

namespace App\Http\Controllers\Api;

use App\CakupanOrmawa;
use App\{EventEksternal, KategoriEvent, TipePeserta, EventEksternalDetail};
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventEksternalController extends Controller
{
    public function index()
    {
        $events = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef', 'pengajuanRef')->get();
        if ($events->count() > 0) {
            return response()->json([
                'status' => 200,
                'message' => "Data event eksternal tersedia",
                'data' => $events
            ], 200);
        }

        return response()->json([
            "success" => false,
            "status" => 404,
            "message" => "Data Event Eksternal Tidak ada",
        ], 404);
    }

    public function save(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'cakupan_ormawa_id' => 'required',
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
            $event = new EventEksternal();
            $event->cakupan_ormawa_id = $req->cakupan_ormawa_id;
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
                $detail = new EventEksternalDetail();
                $detail->event_eksternal_id = $event->id_event_eksternal;
                $detail->is_validated_pembina = 0;
                $detail->is_validated_wadir3 = 0;
                $detail->save();
            }

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Event eskternal berhasil tambah",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "success" => false,
                "message" => $err,
                "status" => 500,
            ]);
        }
    }

    // detail event eksternal

    public function detail($id_eventeksternal)
    {
        $event = EventEksternal::with('cakupanOrmawaRef', 'kategoriRef', 'tipePesertaRef', 'pengajuanRef')->find($id_eventeksternal);
        if ($event) {
            return response()->json([
                'status' => 200,
                'message' => "Data event eksternal tersedia",
                'data' => $event
            ], 200);
        }

        return response()->json([
            "success" => false,
            "status" => 404,
            "message" => "Data Event Eksternal Tidak ada",
        ], 404);
    }

    // Update event eksternal

    public function update(Request $req, $id_eventeksternal)
    {
        $validator = Validator::make($req->all(), [
            'cakupan_ormawa_id' => 'required',
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

        $event = EventEksternal::find($id_eventeksternal);
        if ($event) {
            try {
                $event->cakupan_ormawa_id = $req->cakupan_ormawa_id;
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

    public function seePengajuan($id_eventeksternal)
    {
        try {
            $pengajuan = EventEksternalDetail::with('filePengajuan')->where('event_eksternal_id', $id_eventeksternal)->first();
            if ($pengajuan) {


                return response()->json([
                    'status' => 200,
                    'message' => "Data pengajuan event eksternal tersedia",
                    'data' => $pengajuan
                ], 200);
            }

            return response()->json([
                "success" => false,
                "status" => 404,
                "message" => "Data pengajuan event eksternal Tidak ada",
            ], 404);
        } catch (\Throwable $err) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "message" => $err,
            ], 500);
        }
    }

    public function terimaPengajuan(Request $req, $id_eventeksternal_detail)
    {
        $validator = Validator::make($req->all(), [
            'event_eksternal_id' => 'required',
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
            $pengajuan = EventEksternalDetail::find($id_eventeksternal_detail);

            if (!$pengajuan) {
                return response()->json([
                    "success" => false,
                    "status" => 404,
                    "message" => "Data pengajuan event eksternal Tidak ada",
                ], 404);
            }

            $pengajuan->event_eksternal_id = $req->event_eksternal_id;
            $pengajuan->is_validated_pembina = $req->validate_pembina;
            $pengajuan->is_validated_wadir3 = $req->validate_wadir3;
            $pengajuan->save();

            // if all validate 1
            if ($req->validate_pembina == 1 && $req->validate_wadir3 == 1) {
                $this->changeStatusEvent($req->event_eksternal_id);
            }

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Event eksternal berhasil diupdate",
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                "success" => false,
                "message" => $err,
                "status" => 500,
            ], 500);
        }
    }

    public function changeStatusEvent($id_eventeksternal)
    {
        EventEksternal::where('id_event_eksternal', $id_eventeksternal)->update([
            'status' => 1,
            'status_validasi' => 1,
        ]);
    }
}
