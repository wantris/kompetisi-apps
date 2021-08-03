<?php

namespace App\Exports;

use App\EventEksternal;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Controllers\endpoint\ApiDosenController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use GuzzleHttp\Client;
use App\EventEksternalRegistration;


class EventEksternalRegisEksport implements FromView, ShouldAutoSize
{
    protected $id_event_eksternal;
    protected $status;
    protected $api_mahasiswa;
    protected $api_dosen;

    function __construct($id_event_eksternal, $status)
    {
        $this->id_event_eksternal = $id_event_eksternal;
        $this->status = $status;
        $this->api_mahasiswa = new ApiMahasiswaController;
        $this->api_dosen = new ApiDosenController;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $event = EventEksternal::find($this->id_event_eksternal);
        $registrations = $this->getPendaftarById($event);

        return view('ormawa.exports.list_peserta', [
            'pendaftaran' => $registrations,
            'event' => $event
        ]);
    }

    public function getPendaftarById($event)
    {
        $status = $this->status;
        if ($status != "all") {
            $registrations = EventEksternalRegistration::with('timRef')->where('event_eksternal_id', $event->id_event_eksternal)->where(function ($query) use ($status) {
                if ($status == "1") {
                    $query->where('status', 1);
                } else {
                    $query->where('status', 0);
                }
            })->get();
        } else {
            $registrations = EventEksternalRegistration::with('timRef')->where('event_eksternal_id', $event->id_event_eksternal)->get();
        }


        if ($event->role != "Team") {
            foreach ($registrations as $item) {
                $item->mahasiswaRef = null;
                if ($item->nim) {
                    $mhs = $this->api_mahasiswa->getMahasiswaSomeField($item->nim);
                    if ($mhs) {
                        $item->mahasiswaRef = $mhs;
                    }
                }
            }
        } else {
            foreach ($registrations as $item) {

                $item->timRef->pembimbingRef = null;
                if ($item->timRef->nidn) {
                    $dosen = $this->api_dosen->getDosenOnlySomeField($item->timRef->nidn);
                    if ($dosen) {
                        $item->timRef->pembimbingRef = $dosen;
                    }
                }

                foreach ($item->timRef->timDetailRef as $detail) {
                    $detail->mahasiswaRef = null;
                    if ($detail->nim) {
                        $mhs = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);

                        if ($mhs) {
                            $detail->mahasiswaRef = $mhs;
                        }
                    }
                }
            }
        }

        return $registrations;
    }
}
