<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\EventInternal;
use App\EventInternalRegistration;
use GuzzleHttp\Client;

class EventInternalRegisEksport implements FromView, ShouldAutoSize
{
    protected $id_event_internal;
    protected $status;
    protected $api_mahasiswa;
    protected $api_dosen;

    function __construct($id_event_internal, $status)
    {
        $this->id_event_internal = $id_event_internal;
        $this->status = $status;
        $this->api_mahasiswa = new ApiMahasiswaController;
        $this->api_dosen = new ApiDosenController;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $event = EventInternal::find($this->id_event_internal);
        $registrations = $this->getPendaftarById($event);


        return view('ormawa.exports.list_peserta_internal', [
            'pendaftaran' => $registrations,
            'event' => $event
        ]);
    }

    public function getPendaftarById($event)
    {
        $registrations = EventInternalRegistration::with('timRef', 'participantRef')->where('event_internal_id', $event->id_event_internal)->get();
        if ($event->role != "Team") {
            foreach ($registrations as $item) {
                $item->mahasiswaRef = null;
                if ($item->nim) {
                    try {
                        $mhs = $this->api_mahasiswa->getDosenOnlySomeField($item->nim);
                        $item->mahasiswaRef = $mhs;
                    } catch (\Throwable $err) {
                    }
                }
            }
        } else {
            foreach ($registrations as $item) {
                $item->timRef->pembimbingRef = null;
                if ($item->timRef->nidn) {
                    $dosen = $this->api_dosen->getDosenOnlySomeField($item->timRef->nidn);
                    $item->timRef->pembimbingRef = $dosen;
                }

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

        return $registrations;
    }
}
