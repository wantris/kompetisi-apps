<?php

namespace App\Http\Controllers\ormawa;

use App\EventInternal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EventInternalRegistration;
use App\Ormawa;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class EventInternalRegisController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Semua Peserta Event Internal';


        $registrations = $this->getAllRegistration();
        $events = EventInternal::where('ormawa_id', Session::get('id_ormawa'))->get();

        return view('ormawa.pendaftar.event_internal.index', compact(
            'registrations',
            'events',
            'navTitle'
        ));
    }

    public function delete($id_regis)
    {
        try {
            EventInternalRegistration::destroy($id_regis);

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
            $regis = EventInternalRegistration::find($id_regis);
            $regis->status = $status;
            $regis->save();

            return redirect()->back()->with('success', 'Update status pendaftaran berhasil');
        } catch (\Throwable $err) {
            return redirect()->back()->with('failed', 'Update status pendaftaran gagal');
        }
    }

    public function getAllRegistration()
    {

        $registrations = EventInternalRegistration::with('timRef', 'participantRef')->whereHas('eventInternalRef', function ($query) {
            $query->where('ormawa_id', Session::get('id_ormawa'));
        })->get();

        foreach ($registrations as $item) {
            $event = EventInternal::where('id_event_internal', $item->event_internal_id)->first();

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
