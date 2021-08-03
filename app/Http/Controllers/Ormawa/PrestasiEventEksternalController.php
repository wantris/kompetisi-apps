<?php

namespace App\Http\Controllers\ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PrestasiEventEksternal;

class PrestasiEventEksternalController extends Controller
{
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'regis_id' => 'required',
            'posisi' => 'required|integer',
        ]);

        $ps = PrestasiEventEksternal::where('event_eksternal_regis_id', $request->regis_id)->first();

        try {
            if (!$ps) {
                $pee = new PrestasiEventEksternal();
                $pee->event_eksternal_regis_id = $request->regis_id;
                $pee->posisi = $request->posisi;
                $pee->catatan = $request->catatan;
                $pee->save();

                return redirect()->back()->with('success', 'Berhasil menambahkan prestasi juara');
            } else {

                PrestasiEventEksternal::where('event_eksternal_regis_id', $request->regis_id)->update([
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
