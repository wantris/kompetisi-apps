<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\{EventInternal, EventInternalDetail, EventInternalRegistration, FileEventInternalDetail, FileEventInternalRegistration, Ormawa, KategoriEvent, PrestasiEventInternal, TipePeserta, TimEvent};
use App\TahapanEventInternal;
use App\Http\Requests\EventInternalStoreRequest;
use App\Http\Requests\EventInternalUpdateRequest;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Exports\EventInternalRegisEksport;
use App\Http\Controllers\ormawa\TahapanEventInternalController;

class EventInternalController extends Controller
{
    protected $api_mahasiswa;
    protected $api_dosen;
    protected $ormawa;
    protected $kategoris;
    protected $tipes;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->api_mahasiswa = new ApiMahasiswaController;
            $this->api_dosen = new ApiDosenController;
            $this->ormawa =  Ormawa::find(Session::get('id_ormawa'));
            $this->kategoris = KategoriEvent::all();
            $this->tipes = TipePeserta::all();
            return $next($request);
        });
    }

    // ==================================== BASIC CRUD =======================================
    public function index()
    {
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Event Internal';
        $eias = EventInternal::with('kategoriRef', 'tipePesertaRef')->where('ormawa_id', Session::get('id_ormawa'))->where('status', 1)->get();
        $eis = EventInternal::with('kategoriRef', 'tipePesertaRef')->where('ormawa_id', Session::get('id_ormawa'))->get();
        $eiss = EventInternal::with('kategoriRef', 'tipePesertaRef')->where('ormawa_id', Session::get('id_ormawa'))->where('status', 0)->get();

        return view('ormawa.event_internal.index', compact('eis', 'navTitle', 'eias', 'eiss'));
    }

    public function add()
    {
        $ormawa = $this->ormawa;
        $kategoris = $this->kategoris;
        $tipes = $this->tipes;

        if ($ormawa) {
            $navTitle = '<span class="micon dw dw-clipboard1 mr-2"></span>Buat Event';
            return view('ormawa.event_internal.add', compact('navTitle', 'ormawa', 'kategoris', 'tipes'));
        } else {
            return redirect()->back()->with('failed', 'Data ormawa invalid, harap login');
        }
    }

    public function saveForm(EventInternalStoreRequest $req)
    {
        $validated = $req->validated();

        $nameBanner = null;
        $namePoster = null;

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
            $ei = new EventInternal();
            $ei->ormawa_id = Session::get('id_ormawa');
            $ei->nama_event = $req->event_title;
            $ei->slug =  Str::slug($req->event_title);
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

            // create registration step
            $tahapan = new TahapanEventInternal();
            $tahapan->event_internal_id = $ei->id_event_internal;
            $tahapan->nama_tahapan = "Pendaftaran";
            $tahapan->save();

            // Store event internal detail
            if ($ei) {
                $eid = new EventInternalDetail();
                $eid->event_internal_id = $ei->id_event_internal;
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

                $feid = new FileEventInternalDetail();
                $feid->event_internal_detail_id = $eid->id_event_internal_detail;
                $feid->nama_file = $req->nama_dokumen[$key];
                $feid->filename = $namedokumen;
                $feid->tipe = "pendaftaran";
                $feid->save();
            }

            return redirect()->route('ormawa.eventinternal.index')->with('success', 'Event internal berhasil disimpan');
        } catch (\Throwable $err) {
            dd($err);
        }
    }

    public function edit($id_eventinternal)
    {
        $ei = EventInternal::find($id_eventinternal);

        $tahapan_controller = new TahapanEventInternalController;

        if (!$ei) {
            return redirect()->back()->with('failed', 'Data event internal tidak ada');
        }

        if (Session::get('is_pembina') == "0") {
            $navTitle = '<i class="icon-copy dw dw-rocket mr-2"></i>Update Event internal';
            $title = "Update " . $ei->nama_event;
        } else {
            $navTitle = '<i class="icon-copy dw dw-rocket mr-2"></i>Detail Event internal';
            $title = "Detail " . $ei->nama_event;
        }

        $kategoris = $this->kategoris;
        $tipes = $this->tipes;
        $tahapans = $tahapan_controller->getByEvent($id_eventinternal);

        $feids = FileEventInternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventinternal) {
            $q->where('event_internal_id', '=', $id_eventinternal);
        })->where('tipe', 'pendaftaran')->get();

        $feips = FileEventInternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventinternal) {
            $q->where('event_internal_id', '=', $id_eventinternal);
        })->where('tipe', 'pengajuan')->get();

        return view('ormawa.event_internal.edit', compact(
            'ei',
            'navTitle',
            'title',
            'kategoris',
            'tipes',
            'feids',
            'feips',
            'tahapans'
        ));
    }

    public function update(EventInternalUpdateRequest $req, $id_eventinternal)
    {
        $validated = $req->validated();

        $nameBanner = $req->oldBanner;
        $namePoster = $req->oldPoster;

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
            $ei = EventInternal::find($id_eventinternal);
            $ei->ormawa_id = Session::get('id_ormawa');
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

            return redirect()->back()->with('success', 'Update event internal berhasil');
        } catch (\Throwable $err) {
            return redirect()->back()->with('failed', 'Update event internal gagal');
        }
    }

    public function delete(Request $request, $id_eventinternal)
    {
        $ei = EventInternal::find($id_eventinternal);
        EventInternal::destroy($id_eventinternal);
        return response()->json([
            "status" => 1,
            "message" => $ei->nama_event . " berhasil dihapus",
        ]);
    }

    // ==================================== END BASIC CRUD =======================================

    public function lihatPublik($id_eventinternal)
    {
        $ei = EventInternal::with('kategoriRef', 'tipePesertaRef', 'ormawaRef', 'pengajuanRef')->find($id_eventinternal);
        $feis = FileEventInternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventinternal) {
            $q->where('event_internal_id', '=', $id_eventinternal);
        })->where('tipe', 'pendaftaran')->get();

        if ($ei) {
            $slug = Str::slug($ei->nama_event);
            return view('ormawa.event_internal.publik_detail', compact('ei', 'slug', 'feis'));
        }
    }

    public function lihatPendaftar($id_eventinternal)
    {
        $ei = EventInternal::with('tahapanRef')->find($id_eventinternal);
        $tahapan_controller = new TahapanEventInternalController;
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Pendaftar ' . $ei->nama_event;

        $pendaftaran = $this->getPendaftarById($ei);
        $feeds = $this->getAllFilePendaftaran($ei->id_event_internal);
        $prestasis = $this->getPrestasiByEvent($id_eventinternal);
        $tahapans = $tahapan_controller->getByEvent($id_eventinternal);


        return view('ormawa.event_internal.list_peserta', compact('navTitle', 'navTitle', 'pendaftaran', 'ei', 'feeds', 'tahapans'));
    }

    public function listPeserta($slug)
    {
        $navTitle = '<span class="micon dw dw-rocket mr-2"></span>Event Internal';

        return view('ormawa.event_internal.list_peserta', compact('slug', 'navTitle'));
    }

    public function updateStatus(Request $req)
    {
        if ($req->status == null) {
            return redirect()->back()->with('failed', 'Error');
        }

        $status = $req->status;
        $ei = EventInternal::find($req->id_eventinternal);

        if (!$ei) {
            return redirect()->back()->with('failed', 'Event internal tidak ada');
        }

        if ($status == 1 && $ei->status_validasi == 0) {
            return redirect()->back()->with('failed', 'Event harus divalidasi terlebih dahulu');
        }

        $ei->status = $status;
        $ei->save();
        return redirect()->back()->with('success', 'Update status berhasil');
    }

    // Berkas pengajuan event

    public function savePengajuan(Request $req)
    {
        $validated = $req->validate([
            'berkas' => 'required|mimes:pdf|max:2048'
        ]);

        $ei = EventInternal::find($req->id_event);

        if ($ei) {
            if ($req->file('berkas')) {
                $resorceBerkas = $req->file('berkas');
                $nameBerkas   = "berkas_" . rand(00000, 99999) . "." . $resorceBerkas->getClientOriginalExtension();
                $resorceBerkas->move(\base_path() . "/public/assets/file/pengajuan_event/", $nameBerkas);
            }

            try {
                $file = new FileEventInternalDetail();
                $file->event_internal_detail_id = $ei->pengajuanRef->id_event_internal_detail;
                $file->nama_file = $req->keterangan;
                $file->tipe = "pengajuan";
                $file->filename = $nameBerkas;
                $file->save();

                return redirect()->back()->with('success', 'Upload berkas pengajuan berhasil');
            } catch (\Throwable $err) {
                dd($err);
            }
        }

        return redirect()->back()->with('failed', 'Data event internal tidak ada');
    }

    public function deletePengajuan(Request $request, $id_berkas)
    {
        $ei = FileEventInternalDetail::find($id_berkas);
        FileEventInternalDetail::destroy($id_berkas);
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

        $ei = EventInternal::find($req->id_event);

        if ($ei) {
            if ($req->file('berkas_pendaftaran')) {
                $resorceBerkas = $req->file('berkas_pendaftaran');
                $nameBerkas   = "berkas_" . rand(00000, 99999) . "." . $resorceBerkas->getClientOriginalExtension();
                $resorceBerkas->move(\base_path() . "/public/assets/file/dokumen_event/", $nameBerkas);
            }

            try {
                $file = new FileEventInternalDetail();
                $file->event_internal_detail_id = $ei->pengajuanRef->id_event_internal_detail;
                $file->nama_file = $req->keterangan_pendaftaran;
                $file->tipe = "pendaftaran";
                $file->filename = $nameBerkas;
                $file->save();

                return redirect()->back()->with('success', 'Upload berkas pendaftaran berhasil');
            } catch (\Throwable $err) {
                dd($err);
            }
        }

        return redirect()->back()->with('failed', 'Data event internal tidak ada');
    }

    public function deletePendaftaran(Request $request, $id_berkas)
    {
        $ei = FileEventInternalDetail::find($id_berkas);
        FileEventInternalDetail::destroy($id_berkas);
        return response()->json([
            "status" => 1,
            "message" => $ei->nama_file . " berhasil dihapus",
        ]);
    }

    public function updateValidasiPembina(Request $req)
    {
        try {
            EventInternalDetail::where('id_event_internal_detail', $req->id_eid)->update([
                'is_validated_pembina' => $req->status
            ]);
            return redirect()->back()->with('success', 'Update validasi berhasil');
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->back()->with('failed', 'Update validasi gagal');
        }
    }

    // ======= Pendaftaran =====
    public function getPendaftarById($event)
    {
        $registrations = EventInternalRegistration::with('penggunaMhsRef', 'timRef', 'participantRef', 'prestasiRef', 'tahapanRegisRef.tahapanEventInternal', 'sertifikatRef')
            ->where('event_internal_id', $event->id_event_internal)
            ->get();
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
                foreach ($item->timRef->timDetailRef as $detail) {
                    if ($detail->role == "ketua") {
                        $detail->nama_mhs = null;
                        if ($detail->nim) {
                            $mhs = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
                            if ($mhs) {
                                $detail->mahasiswaRef = $mhs;
                            }
                        }
                    }
                }
            }
        }

        return $registrations;
    }

    public function getPrestasiByEvent($id_eventinternal)
    {
        $prestasis = PrestasiEventInternal::whereHas('eventInternalRegisRef', function ($query) use ($id_eventinternal) {
            $query->where('event_internal_id', $id_eventinternal);
        })->get();
    }

    public function getAllFilePendaftaran($id_eventinternal)
    {
        $feeds = FileEventInternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventinternal) {
            $q->where('event_internal_id', '=', $id_eventinternal);
        })->where('tipe', 'pendaftaran')->get();

        return $feeds;
    }

    public function downloadBerkas($id_regis)
    {
        $regis = EventInternalRegistration::find($id_regis);

        if ($regis->fileEiRegisRef->count() > 0) {
            $file = FileEventInternalRegistration::where('event_internal_regis_id', $regis->id_event_internal_registration)->latest('created_at')->first();
            $file = public_path() . "/assets/file/berkas_pendaftaran_internal/" . $file->filename;

            return response()->download($file);
        }
    }

    public function updateStatusRegis($id_regis, $status)
    {
        $regis = EventInternalRegistration::find($id_regis);
        $regis->status = $status;
        $regis->save();

        return redirect()->back()->with('success', 'Update status registrasi berhasil');
    }

    public function validasiSemua($id_eventinternal)
    {
        $regis = EventInternalRegistration::where('event_internal_id', $id_eventinternal)->get();
        if ($regis->count() > 0) {
            foreach ($regis as $item) {
                $update = EventInternalRegistration::where('id_event_internal_registration', $item->id_event_internal_registration)->update([
                    'status' => 1
                ]);
            }
        }

        return response()->json([
            "status" => 1,
            "message" => "Pendaftaran berhasil divalidasi semua",
        ]);
    }



    public function exportPendaftarExcel($id_eventinternal, $status)
    {
        $event = EventInternal::find($id_eventinternal);

        return Excel::download(new EventInternalRegisEksport($id_eventinternal, $status), 'Peserta ' . $event->nama_event . '.xlsx');
    }

    public function exportPendaftarPdf($id_eventinternal, $status)
    {
        $event = EventInternal::find($id_eventinternal);
        $pendaftaran = $this->getPendaftarById($event);

        $pdf = PDF::loadview('ormawa.exports.pdf.list_peserta_internal_pdf', ['event' => $event, 'pendaftaran' => $pendaftaran])->setPaper('a4', 'landscape');

        return $pdf->download('data_peserta.pdf');
    }

    public function deletePendaftar($id_regis)
    {
        EventInternalRegistration::destroy($id_regis);

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
