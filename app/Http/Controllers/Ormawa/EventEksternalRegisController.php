<?php

namespace App\Http\Controllers\ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use App\EventEksternal;
use App\EventEksternalRegistration;
use App\CakupanOrmawa;
use App\Ormawa;

class EventEksternalRegisController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Semua Peserta Event Eksternal';

        $cakupan = CakupanOrmawa::where('ormawa_id', Session::get('id_ormawa'))->first();
        $events = EventEksternal::where('cakupan_ormawa_id', $cakupan->id_cakupan_ormawa)->get();
        $ormawa = Ormawa::find(Session::get('id_ormawa'));
        $registrations = $this->getAllRegistration($cakupan);
        $regis_all_cakupans = $this->getAllCakupanRegis();

        return view('ormawa.pendaftar.event_eksternal.index', compact(
            'registrations',
            'events',
            'navTitle',
            'cakupan',
            'ormawa',
            'regis_all_cakupans'
        ));
    }

    public function delete($id_regis)
    {
        try {
            EventEksternalRegistration::destroy($id_regis);

            return response()->json([
                "status" => 1,
                "message" => "Pendaftaran berhasil dihapus",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 0,
                "message" => "Pendaftaran berhasil dihapus",
            ]);
        }
    }

    public function updateStatusRegis($id_regis, $status)
    {
        try {
            $regis = EventEksternalRegistration::find($id_regis);
            $regis->status = $status;
            $regis->save();

            return redirect()->back()->with('success', 'Update status pendaftaran berhasil');
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->back()->with('failed', 'Update status pendaftaran gagal');
        }
    }

    public function getAllRegistration($cakupan)
    {
        $registrations = EventEksternalRegistration::with('timRef')->whereHas('eventEksternalRef', function ($query) use ($cakupan) {
            $query->where('cakupan_ormawa_id', $cakupan->id_cakupan_ormawa);
        })->get();

        if ($registrations->count() > 0) {
            foreach ($registrations as $item) {
                $event = Eventeksternal::where('id_event_eksternal', $item->event_eksternal_id)->first();

                if ($event) {
                    if ($event->role != "Team") {
                        $item->mahasiswaRef = null;
                        if ($item->nim) {
                            try {
                                $mhs = $this->getMahasiswaByNim($item->nim);
                                $item->mahasiswaRef = $mhs;
                            } catch (\Throwable $err) {
                            }
                        }
                    } else {
                        foreach ($item->timRef->timDetailRef as $detail) {
                            if ($detail->role == "ketua") {
                                $detail->mahasiswaRef = null;
                                if ($detail->nim) {
                                    try {
                                        $mhs = $this->getMahasiswaByNim($detail->nim);
                                        $detail->mahasiswaRef = $mhs;
                                    } catch (\Throwable $err) {
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
    }


    public function getAllCakupanRegis()
    {
        $cakupan = CakupanOrmawa::where('role', 'All')->first();
        $registrations = EventEksternalRegistration::with('timRef')->whereHas('eventEksternalRef', function ($query) use ($cakupan) {
            $query->where('cakupan_ormawa_id', $cakupan->id_cakupan_ormawa);
        })->get();

        if ($registrations->count() > 0) {
            foreach ($registrations as $item) {
                $event = Eventeksternal::where('id_event_eksternal', $item->event_eksternal_id)->first();

                if ($event) {
                    if ($event->role != "Team") {
                        $item->mahasiswaRef = null;
                        if ($item->nim) {
                            try {
                                $mhs = $this->getMahasiswaByNim($item->nim);
                                $item->mahasiswaRef = $mhs;
                            } catch (\Throwable $err) {
                            }
                        }
                    } else {
                        foreach ($item->timRef->timDetailRef as $detail) {
                            if ($detail->role == "ketua") {
                                $detail->mahasiswaRef = null;
                                if ($detail->nim) {
                                    try {
                                        $mhs = $this->getMahasiswaByNim($detail->nim);
                                        $detail->mahasiswaRef = $mhs;
                                    } catch (\Throwable $err) {
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
    }



    public function getMahasiswaByNim($nim)
    {
        $msh = null;

        try {
            $client = new Client();
            $url = env("SOURCE_API") . "mahasiswa/detail/" . $nim;
            $rMhs = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $mhs = json_decode($rMhs->getBody());
        } catch (\Throwable $err) {
        }

        return $mhs;
    }
}
