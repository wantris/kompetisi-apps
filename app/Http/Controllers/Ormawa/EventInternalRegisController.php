<?php

namespace App\Http\Controllers\ormawa;

use App\EventInternal;
use App\Http\Controllers\Controller;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use Illuminate\Http\Request;
use App\EventInternalRegistration;
use App\Ormawa;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class EventInternalRegisController extends Controller
{
    protected $api_mahasiswa;
    protected $api_dosen;
    protected $ormawa;

    public function __construct()
    {
        $this->api_mahasiswa = new ApiMahasiswaController;
        $this->api_dosen = new ApiDosenController;
        $this->ormawa =  Ormawa::find(Session::get('id_ormawa'));
    }

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
                            $mhs = $this->api_mahasiswa->getMahasiswaSomeField($item->nim);
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
                                    $mhs = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
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
}
