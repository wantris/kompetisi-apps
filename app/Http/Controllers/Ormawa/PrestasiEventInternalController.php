<?php

namespace App\Http\Controllers\ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PrestasiEventInternal;

class PrestasiEventInternalController extends Controller
{
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'regis_id' => 'required',
            'posisi' => 'required|integer',
        ]);

        $ps = PrestasiEventInternal::where('event_internal_registration_id', $request->regis_id)->first();

        try {
            if (!$ps) {
                $pee = new PrestasiEventInternal();
                $pee->event_internal_registration_id = $request->regis_id;
                $pee->posisi = $request->posisi;
                $pee->catatan = $request->catatan;
                $pee->save();

                return redirect()->back()->with('success', 'Berhasil menambahkan prestasi juara');
            } else {

                PrestasiEventInternal::where('event_internal_registration_id', $request->regis_id)->update([
                    'posisi' => $request->posisi,
                    'catatan' => $request->catatan
                ]);

                return redirect()->back()->with('success', 'Berhasil update prestasi juara');
            }
        } catch (\Throwable $err) {
            return redirect()->back()->with('success', 'Gagal update prestasi juara');
        }
    }
}
