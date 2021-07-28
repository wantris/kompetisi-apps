<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\{CakupanOrmawa, EventEksternal, Ormawa, KategoriEvent, TipePeserta, EventEksternalDetail, FileEventEksternalDetail, EventEksternalRegistration, FileEventEksternalRegistration};
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EventEksternalStoreRequest;
use App\Http\Requests\EventEksternalUpdateRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventEksternalRegisEksport;

class EventEksternalController extends Controller
{

    public function index()
    {
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Event Eksternal';
        $cakupan = CakupanOrmawa::where('ormawa_id', Session::get('id_ormawa'))->first();
        $cakupanAll = CakupanOrmawa::where('role', 'All')->first();
        if ($cakupan) {
            $eeas = EventEksternal::with('kategoriRef', 'tipePesertaRef')->where('cakupan_ormawa_id', $cakupan->ormawa_id)->where('status', 1)->get();
            $ees = EventEksternal::with('kategoriRef', 'tipePesertaRef')->where('cakupan_ormawa_id', $cakupan->ormawa_id)->get();
            $eess = EventEksternal::with('kategoriRef', 'tipePesertaRef')->where('cakupan_ormawa_id', $cakupan->ormawa_id)->where('status', 0)->get();
            $eescs = EventEksternal::with('kategoriRef', 'tipePesertaRef')->where('cakupan_ormawa_id', $cakupanAll->id_cakupan_ormawa)->get();
            return view('ormawa.event_eksternal.index', compact('ees', 'navTitle', 'eeas', 'eess', 'eescs'));
        }

        return redirect()->back()->with('failed', 'Upss terjadi error');
    }

    public function add()
    {
        $ormawa = Ormawa::find(Session::get('id_ormawa'));
        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();

        if ($ormawa) {
            $navTitle = '<span class="micon dw dw-clipboard1 mr-2"></span>Buat Event';
            return view('ormawa.event_eksternal.add', compact('navTitle', 'ormawa', 'kategoris', 'tipes'));
        } else {
            return redirect()->back()->with('failed', 'Data ormawa invalid, harap login');
        }
    }

    public function saveForm(EventEksternalStoreRequest $req)
    {
        $validated = $req->validated();

        $nameBanner = null;
        $namePoster = null;

        $cakupan = CakupanOrmawa::where('ormawa_id', Session::get('id_ormawa'))->first();
        if (!$cakupan) {
            return redirect()->back()->with('failed', 'Uppps terjadi error');
        }

        if ($req->file('poster')) {
            $resorcePoster = $req->file('poster');
            $namePoster   = "poster_" . rand(0000, 9999) . "." . $resorcePoster->getClientOriginalExtension();
            $resorcePoster->move(\base_path() . "/public/assets/img/kompetisi-thumb/", $namePoster);
        }
        if ($req->file('banner')) {
            $resorceBanner = $req->file('banner');
            $nameBanner   = "banner_" . rand(0000, 9999) . "." . $resorceBanner->getClientOriginalExtension();
            $resorceBanner->move(\base_path() . "/public/assets/img/banner-komp/", $nameBanner);
        }

        try {
            $ei = new EventEksternal();
            $ei->cakupan_ormawa_id = $cakupan->id_cakupan_ormawa;
            $ei->nama_event = $req->event_title;
            $ei->kategori_id = $req->category;
            $ei->tipe_peserta_id = $req->jenis_peserta;
            $ei->maks_participant = $req->peserta;
            $ei->role = $req->jenis;
            $ei->tgl_buka = $req->tgl_mulai;
            $ei->tgl_tutup = $req->tgl_tutup;
            $ei->deskripsi = $req->deskripsi;
            $ei->ketentuan = $req->ketentuan;
            $ei->status = 0;
            $ei->status_validasi = 0;
            $ei->poster_image = $namePoster;
            $ei->banner_image = $nameBanner;
            $ei->save();

            // Store event eksternal detail
            if ($ei) {
                $eid = new EventEksternalDetail();
                $eid->event_eksternal_id = $ei->id_event_eksternal;
                $eid->is_validated_pembina = 0;
                $eid->is_validated_wadir3 = 0;
                $eid->save();
            }

            // Jika ada berkas untuk pendaftaran
            if ($req->file('file_dokumen')) {
                foreach ($req->file_dokumen as $key => $item) {
                    $resorcedokumen = $item;
                    $namedokumen   = "dokumen_" . rand(0000, 9999) . "." . $resorcedokumen->getClientOriginalExtension();
                    $resorcedokumen->move(\base_path() . "/public/assets/file/dokumen-event/", $namedokumen);
                }

                $feid = new FileEventEksternalDetail();
                $feid->event_eksternal_detail_id = $eid->id_event_eksternal_detail;
                $feid->nama_file = $req->nama_dokumen[$key];
                $feid->filename = $namedokumen;
                $feid->tipe = "pendaftaran";
                $feid->save();
            }

            return redirect()->route('ormawa.eventeksternal.index')->with('success', 'Event eksternal berhasil disimpan');
        } catch (\Throwable $err) {
            dd($err);
        }
    }

    public function edit($id_eventeksternal)
    {
        $ee = EventEksternal::find($id_eventeksternal);

        if (!$ee) {
            return redirect()->back()->with('failed', 'Data event eksternal tidak ada');
        }

        if (Session::get('is_pembina') == "0") {
            $navTitle = '<i class="icon-copy dw dw-rocket mr-2"></i>Update Event eksternal';
            $title = "Update " . $ee->nama_event;
        } else {
            $navTitle = '<i class="icon-copy dw dw-rocket mr-2"></i>Detail Event eksternal';
            $title = "Detail " . $ee->nama_event;
        }

        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();
        $feeds = FileEventEksternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventeksternal) {
            $q->where('event_eksternal_id', '=', $id_eventeksternal);
        })->where('tipe', 'pendaftaran')->get();
        $feeps = FileEventEksternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventeksternal) {
            $q->where('event_eksternal_id', '=', $id_eventeksternal);
        })->where('tipe', 'pengajuan')->get();

        return view('ormawa.event_eksternal.edit', compact(
            'ee',
            'navTitle',
            'title',
            'kategoris',
            'tipes',
            'feeds',
            'feeps'
        ));
    }

    public function update(EventEksternalUpdateRequest $req, $id_eventeksternal)
    {
        $validated = $req->validated();


        $nameBanner = $req->oldBanner;
        $namePoster = $req->oldPoster;

        $cakupan = CakupanOrmawa::where('ormawa_id', Session::get('id_ormawa'))->first();
        if (!$cakupan) {
            return redirect()->back()->with('failed', 'Uppps terjadi error');
        }

        $cakupan = CakupanOrmawa::where('ormawa_id', Session::get('id_ormawa'))->first();
        if (!$cakupan) {
            return redirect()->back()->with('failed', 'Uppps terjadi error');
        }

        if ($req->file('poster')) {
            $resorcePoster = $req->file('poster');
            $namePoster   = "poster_" . rand(0000, 9999) . "." . $resorcePoster->getClientOriginalExtension();
            $resorcePoster->move(\base_path() . "/public/assets/img/kompetisi-thumb/", $namePoster);
        }
        if ($req->file('banner')) {
            $resorceBanner = $req->file('banner');
            $nameBanner   = "banner_" . rand(0000, 9999) . "." . $resorceBanner->getClientOriginalExtension();
            $resorceBanner->move(\base_path() . "/public/assets/img/banner-komp/", $nameBanner);
        }

        try {
            $ei = EventEksternal::find($id_eventeksternal);
            $ei->cakupan_ormawa_id = $cakupan->id_cakupan_ormawa;
            $ei->nama_event = $req->event_title;
            $ei->kategori_id = $req->kategori;
            $ei->tipe_peserta_id = $req->tipe_peserta;
            $ei->maks_participant = $req->maks;
            $ei->role = $req->role;
            $ei->tgl_buka = $req->tgl_buka;
            $ei->tgl_tutup = $req->tgl_tutup;
            $ei->deskripsi = $req->deskripsi;
            $ei->ketentuan = $req->ketentuan;
            $ei->poster_image = $namePoster;
            $ei->banner_image = $nameBanner;
            $ei->save();

            return redirect()->back()->with('success', 'Event eksternal berhasil disimpan');
        } catch (\Throwable $err) {
            dd($err);
        }
    }

    public function delete(Request $request, $id_eventeksternal)
    {
        $ei = EventEksternal::find($id_eventeksternal);
        EventEksternal::destroy($id_eventeksternal);
        return response()->json([
            "status" => 1,
            "message" => $ei->nama_event . " berhasil dihapus",
        ]);
    }

    // ========== End of basic CRUD =================

    //  ============================ ADDITIONAL CRUD ===============================

    // Ubah status event
    public function updateStatus(Request $req)
    {
        $status = $req->status;
        $id_eventeksternal = $req->id_eventeksternal;

        if ($status == null) {
            return redirect()->back()->with('failed', 'Error');
        }

        $ei = EventEksternal::find($id_eventeksternal);

        if (!$ei) {
            return redirect()->back()->with('failed', 'Event eksternal tidak ada');
        }

        if ($status == 1 && $ei->status_validasi == 0) {
            return redirect()->back()->with('failed', 'Event harus divalidasi terlebih dahulu');
        }

        $ei->status = $status;
        $ei->save();

        return redirect()->back()->with('success', 'Update status berhasil');
    }


    // Berkas pengajuan Event
    public function savePengajuan(Request $req)
    {
        $validated = $req->validate([
            'berkas' => 'required|mimes:pdf|max:2048'
        ]);

        $ei = EventEksternal::find($req->id_event);
        if ($ei) {
            if ($req->file('berkas')) {
                $resorceBerkas = $req->file('berkas');
                $nameBerkas   = "berkas_" . rand(00000, 99999) . "." . $resorceBerkas->getClientOriginalExtension();
                $resorceBerkas->move(\base_path() . "/public/assets/file/pengajuan_event/", $nameBerkas);
            }

            try {
                $file = new FileEventEksternalDetail();
                $file->event_eksternal_detail_id = $ei->pengajuanRef->id_event_eksternal_detail;
                $file->nama_file = $req->keterangan;
                $file->tipe = "pengajuan";
                $file->filename = $nameBerkas;
                $file->save();

                return redirect()->back()->with('success', 'Upload berkas pengajuan berhasil');
            } catch (\Throwable $err) {
                dd($err);
            }
        }

        return redirect()->back()->with('failed', 'Data event eksternal tidak ada');
    }

    public function deletePengajuan(Request $request, $id_berkas)
    {
        $ei = FileEventEksternalDetail::find($id_berkas);
        FileEventEksternalDetail::destroy($id_berkas);
        return response()->json([
            "status" => 1,
            "message" => $ei->nama_file . " berhasil dihapus",
        ]);
    }

    // Berkas Keperluan pendaftaran

    public function savePendaftaran(Request $req)
    {
        $validated = $req->validate([
            'keterangan_pendaftaran' => 'required',
            'berkas_pendaftaran' => 'required|mimes:pdf,docx|max:2048'
        ]);

        $ei = EventEksternal::find($req->id_event);
        if ($ei) {
            if ($req->file('berkas_pendaftaran')) {
                $resorceBerkas = $req->file('berkas_pendaftaran');
                $nameBerkas   = "berkas_" . rand(00000, 99999) . "." . $resorceBerkas->getClientOriginalExtension();
                $resorceBerkas->move(\base_path() . "/public/assets/file/dokumen_event/", $nameBerkas);
            }

            try {
                $file = new FileEventEksternalDetail();
                $file->event_eksternal_detail_id = $ei->pengajuanRef->id_event_eksternal_detail;
                $file->nama_file = $req->keterangan_pendaftaran;
                $file->tipe = "pendaftaran";
                $file->filename = $nameBerkas;
                $file->save();

                return redirect()->back()->with('success', 'Upload berkas pendaftaran berhasil');
            } catch (\Throwable $err) {
                dd($err);
            }
        }

        return redirect()->back()->with('failed', 'Data event eksternal tidak ada');
    }

    public function downloadPendaftaran($id_berkas)
    {
        $file = FileEventEksternalDetail::find($id_berkas);
        if ($file) {
            return response()->download(base_path("/public/assets/file/dokumen_event/" . $file->filename));
        } else {
            return redirect()->back()->with('failed', 'Berkas tidak ada di server');
        }
    }

    public function deletePendaftaran(Request $request, $id_berkas)
    {
        $ei = FileEventEksternalDetail::find($id_berkas);
        FileEventEksternalDetail::destroy($id_berkas);
        return response()->json([
            "status" => 1,
            "message" => $ei->nama_file . " berhasil dihapus",
        ]);
    }


    public function updateValidasiPembina(Request $req)
    {
        try {
            EventEksternalDetail::where('id_event_eksternal_detail', $req->id_eed)->update([
                'is_validated_pembina' => $req->status
            ]);
            return redirect()->back()->with('success', 'Update validasi berhasil');
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->back()->with('failed', 'Update validasi gagal');
        }
    }
    //  ============================ END ADDITIONAL CRUD ===============================

    public function lihatPendaftar($id_eventeksternal)
    {
        $ee = EventEksternal::find($id_eventeksternal);
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Pendaftar ' . $ee->nama_event;
        $pendaftaran = $this->getPendaftarById($ee);
        $feeds = $this->getAllFilePendaftaran($ee->id_event_eksternal);

        return view('ormawa.event_eksternal.list_peserta', compact('navTitle', 'navTitle', 'pendaftaran', 'ee', 'feeds'));
    }

    public function getPendaftarById($event)
    {
        $registrations = EventEksternalRegistration::with('timRef', 'fileEeRegisRef')->where('event_eksternal_id', $event->id_event_eksternal)->get();
        if ($event->role != "Team") {
            foreach ($registrations as $item) {
                $item->nama_mhs = null;
                if ($item->nim) {
                    try {
                        $mhs = $this->getMahasiswaByNim($item->nim);
                        $item->nama_mhs = $mhs->nama;
                    } catch (\Throwable $err) {
                    }
                }
            }
        } else {
            foreach ($registrations as $item) {
                foreach ($item->timRef->timDetailRef as $detail) {
                    if ($detail->role == "ketua") {
                        $detail->nama_mhs = null;
                        if ($detail->nim) {
                            try {
                                $mhs = $this->getMahasiswaByNim($detail->nim);
                                $detail->nama_mhs = $mhs->nama;
                            } catch (\Throwable $err) {
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
    }

    public function exportPendaftar($id_eventeksternal, $status)
    {
        $event = EventEksternal::find($id_eventeksternal);

        return Excel::download(new EventEksternalRegisEksport($id_eventeksternal, $status), 'Peserta ' . $event->nama_event . '.xlsx');
    }

    public function getAllFilePendaftaran($id_eventeksternal)
    {
        $feeds = FileEventeksternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventeksternal) {
            $q->where('event_eksternal_id', '=', $id_eventeksternal);
        })->where('tipe', 'pendaftaran')->get();

        return $feeds;
    }

    public function downloadBerkas($id_regis)
    {
        $regis = EventeksternalRegistration::with('fileEeRegisRef')->find($id_regis);

        if ($regis->fileEeRegisRef->count() > 0) {
            $file = FileEventeksternalRegistration::where('event_eksternal_regis_id', $regis->id_event_eksternal_registration)->latest('created_at')->first();
            $file = public_path() . "/assets/file/berkas_pendaftaran_eksternal/" . $file->filename;

            return response()->download($file);
        }
    }

    public function updateStatusRegis($id_regis, $status)
    {
        $regis = EventeksternalRegistration::find($id_regis);
        $regis->status = $status;
        $regis->save();

        return redirect()->back()->with('success', 'Update status registrasi berhasil');
    }

    public function validasiSemua($id_eventeksternal)
    {
        $regis = EventeksternalRegistration::where('event_eksternal_id', $id_eventeksternal)->get();
        if ($regis->count() > 0) {
            foreach ($regis as $item) {
                $update = EventeksternalRegistration::where('id_event_eksternal_registration', $item->id_event_eksternal_registration)->update([
                    'status' => 1
                ]);
            }
        }

        return response()->json([
            "status" => 1,
            "message" => "Pendaftaran berhasil divalidasi semua",
        ]);
    }

    public function deletePendaftar($id_regis)
    {
        EventeksternalRegistration::destroy($id_regis);

        return response()->json([
            "status" => 1,
            "message" => "Pendaftaran berhasil dihapus",
        ]);
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

            return $dosen->nama_dosen;
        } catch (\Throwable $err) {
        }
    }
}
