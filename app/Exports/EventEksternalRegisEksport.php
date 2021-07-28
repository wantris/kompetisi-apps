<?php

namespace App\Exports;

use App\EventEksternal;
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

    function __construct($id_event_eksternal, $status)
    {
        $this->id_event_eksternal = $id_event_eksternal;
        $this->status = $status;
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
            $registrations = EventEksternalRegistration::with('timRef', 'fileEeRegisRef')->where('event_eksternal_id', $event->id_event_eksternal)->where(function ($query) use ($status) {
                if ($status == "1") {
                    $query->where('status', 1);
                } else {
                    $query->where('status', 0);
                }
            })->get();
        } else {
            $registrations = EventEksternalRegistration::with('timRef', 'fileEeRegisRef')->where('event_eksternal_id', $event->id_event_eksternal)->get();
        }


        if ($event->role != "Team") {
            foreach ($registrations as $item) {
                $item->mahasiswaRef = null;
                if ($item->nim) {
                    try {
                        $mhs = $this->getMahasiswaByNim($item->nim);
                        $item->mahasiswaRef = $mhs;
                    } catch (\Throwable $err) {
                    }
                }
            }
        } else {
            foreach ($registrations as $item) {

                $item->timRef->pembimbingRef = null;
                if ($item->timRef->nidn) {
                    $dosen = $this->getDosenSingle($item->timRef->nidn);
                    $item->timRef->pembimbingRef = $dosen;
                }

                foreach ($item->timRef->timDetailRef as $detail) {
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

    public function getAllDosen()
    {
        $dosens = null;

        try {
            $client = new Client();
            $url = env("SOURCE_API") . "dosen/";
            $rDosens = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $dosens = json_decode($rDosens->getBody());
        } catch (\Throwable $err) {
        }

        return $dosens;
    }

    public function getDosenSingle($nidn)
    {
        try {
            $client = new Client();
            $url = env("SOURCE_API") . "dosen/" . $nidn;
            $rDosen = $client->request('GET', $url, [
                'verify'  => false,
            ]);
            $dosen = json_decode($rDosen->getBody());
        } catch (\Throwable $err) {
        }
    }
}
