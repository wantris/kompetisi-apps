<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TahapanEventEksternal;
use App\TahapanEventEksternalRegis;

class tahapanEventEksternalController extends Controller
{
    public function getByEvent($id_eventeksternal)
    {
        $tahapans = collect();
        try {
            $tahapans = TahapanEventEksternal::where('event_eksternal_id', $id_eventeksternal)->get();

            return response()->json([
                "code" => 200,
                "status" => 1,
                "data" => $tahapans,
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                "code" => 500,
                "status" => 1,
                "data" => $tahapans
            ], 500);
        }
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'nama_tahapan' => 'required',
        ]);

        $tahapan = new TahapanEventEksternal();
        $tahapan->event_eksternal_id = $request->eventid;
        $tahapan->nama_tahapan = $request->nama_tahapan;
        $tahapan->save();

        return redirect()->back()->with('success', 'Tahapan event berhasil ditambah');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_tahapan' => 'required',
        ]);
        $tahapan = TahapanEventEksternal::find($request->id_tahapan);
        if ($tahapan) {
            $tahapan->nama_tahapan = $request->nama_tahapan;
            $tahapan->save();

            return redirect()->back()->with('success', 'Tahapan event berhasil diupdate');
        }


        return redirect()->back()->with('failed', 'Tahapan event gagal diupdate');
    }

    public function delete(Request $request)
    {
        TahapanEventEksternal::destroy($request->id_tahapan);
        return response()->json([
            "status" => 1,
            "message" => "Tahapan event berhasil dihapus",
        ]);
    }

    public function saveRegistrationStep()
    {
        try {
            $tahapan = TahapanEventEksternal::latest()->where('event_eksternal_id', request()->eventid)->first();
            if ($tahapan) {
                $tahapan_regis_check = TahapanEventEksternalRegis::where('tahapan_event_eksternal_id', $tahapan->id_tahapan_event_eksternal)
                    ->where('event_eksternal_regis_id', request()->regisid)->first();
                if (!$tahapan_regis_check) {
                    $tahapan_regis = new TahapanEventEksternalRegis();
                    $tahapan_regis->tahapan_event_eksternal_id = $tahapan->id_tahapan_event_eksternal;
                    $tahapan_regis->event_eksternal_regis_id = request()->regisid;
                    $tahapan_regis->save();

                    return response()->json([
                        "code" => 200,
                        "status" => 1,
                        "message" => "Peserta berasil ditambahkan ke tahap selanjutnya",
                    ], 200);
                }
                return response()->json([
                    "code" => 404,
                    "status" => 1,
                    "message" => "Peserta sudah ada di tahap selanjutnya",
                ], 404);
            }
            return response()->json([
                "code" => 404,
                "status" => 1,
                "message" => "Event tidak ada",
            ], 404);
        } catch (\Throwable $err) {
            return response()->json([
                "code" => 500,
                "status" => 1,
                "message" => "Peserta gagal ditambahkan ke tahap selanjutnya",
            ], 500);
        }
    }

    public function saveRegisStepMultiple(Request $request)
    {
        foreach ($request->regis_id as $regisid) {
            $tahapan_regis_check = TahapanEventEksternalRegis::where('tahapan_event_eksternal_id', $request->tahapan_id)
                ->where('event_eksternal_regis_id', $regisid)->first();
            if (!$tahapan_regis_check) {
                $tahapan_regis = new TahapanEventEksternalRegis();
                $tahapan_regis->tahapan_event_eksternal_id = $request->tahapan_id;
                $tahapan_regis->event_eksternal_regis_id = $regisid;
                $tahapan_regis->save();
            }
        }

        return redirect()->back()->with('success', 'Peserta berasil ditambahkan ke tahap selanjutnya');
    }
}
