<?php

namespace App\Http\Controllers\ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TahapanEventInternal;
use App\TahapanEventInternalRegis;

class TahapanEventInternalController extends Controller
{
    public function getByEvent($id_eventinternal)
    {
        $tahapans = collect();
        try {
            $tahapans = TahapanEventInternal::where('event_internal_id', $id_eventinternal)->get();

            return $tahapans;
        } catch (\Throwable $err) {
            return $tahapans;
        }
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'nama_tahapan' => 'required',
        ]);

        $tahapan = new TahapanEventInternal();
        $tahapan->event_internal_id = $request->eventid;
        $tahapan->nama_tahapan = $request->nama_tahapan;
        $tahapan->save();

        return redirect()->back()->with('success', 'Tahapan event berhasil ditambah');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_tahapan' => 'required',
        ]);
        $tahapan = TahapanEventInternal::find($request->id_tahapan);
        if ($tahapan) {
            $tahapan->nama_tahapan = $request->nama_tahapan;
            $tahapan->save();

            return redirect()->back()->with('success', 'Tahapan event berhasil diupdate');
        }


        return redirect()->back()->with('failed', 'Tahapan event gagal diupdate');
    }

    public function delete(Request $request)
    {
        TahapanEventInternal::destroy($request->id_tahapan);
        return response()->json([
            "status" => 1,
            "message" => "Tahapan event berhasil dihapus",
        ]);
    }

    public function saveRegistrationStep()
    {
        $tahapan = TahapanEventInternal::latest()->where('event_internal_id', request()->eventid)->first();
        if ($tahapan) {
            $tahapan_regis_check = TahapanEventInternalRegis::where('tahapan_event_internal_id', $tahapan->id_tahapan_event_internal)
                ->where('event_internal_regis_id', request()->regisid)->first();
            if (!$tahapan_regis_check) {
                $tahapan_regis = new TahapanEventInternalRegis();
                $tahapan_regis->tahapan_event_internal_id = $tahapan->id_tahapan_event_internal;
                $tahapan_regis->event_internal_regis_id = request()->regisid;
                $tahapan_regis->save();

                return redirect()->back()->with('success', 'Peserta berasil ditambahkan ke tahap selanjutnya');
            }
            return redirect()->back()->with('failed', 'Peserta sudah ada di tahap selanjutnya');
        }
        return redirect()->back()->with('failed', 'Peserta gagal ditambahkan ke tahap selanjutnya');
    }

    public function saveRegisStepMultiple(Request $request)
    {
        foreach ($request->regis_id as $regisid) {
            $tahapan_regis_check = TahapanEventInternalRegis::where('tahapan_event_internal_id', $request->tahapan_id)
                ->where('event_internal_regis_id', $regisid)->first();
            if (!$tahapan_regis_check) {
                $tahapan_regis = new TahapanEventInternalRegis();
                $tahapan_regis->tahapan_event_internal_id = $request->tahapan_id;
                $tahapan_regis->event_internal_regis_id = $regisid;
                $tahapan_regis->save();
            }
        }

        return redirect()->back()->with('success', 'Peserta berasil ditambahkan ke tahap selanjutnya');
    }
}
