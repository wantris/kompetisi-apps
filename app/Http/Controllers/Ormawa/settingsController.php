<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Requests\PembinaStoreRequest;
use Illuminate\Support\Facades\Session;
use App\Ormawa;
use App\Pembina;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class settingsController extends Controller
{
    protected $api_mahasiswa;
    protected $api_dosen;
    protected $ormawa;
    protected $dosens;

    public function __construct()
    {
        $this->api_mahasiswa = new ApiMahasiswaController;
        $this->api_dosen = new ApiDosenController;
        $this->ormawa =  Ormawa::find(Session::get('id_ormawa'));
        $this->dosens = $this->api_dosen->getAllDosen();
    }

    public function index()
    {
        try {
            $ormawa = $this->ormawa;

            $pembinas = Pembina::where('ormawa_id', Session::get('id_ormawa'))->get();

            $dosens = $this->dosens;

            if ($pembinas->count() > 0) {
                foreach ($pembinas as $pembina) {
                    $pembina->dosenRef = null;
                    $dosen = $this->api_dosen->getDosenOnlySomeField($pembina->nidn);
                    if ($dosen) {
                        $pembina->dosenRef = $dosen;
                    }
                }
            }

            $navTitle = '<i class="icon-copy dw dw-settings mr-2"></i>Pengaturan Profil';
            return view('ormawa.settings.index', compact('navTitle', 'ormawa', 'pembinas', 'dosens'));
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->route('ormawa.index')->with('failed', 'Terjadi Error');
        }
    }

    public function updateProfile(Request $request)
    {
        $namePhoto = $request->oldPhoto;
        $nameBanner = $request->oldBanner;

        if ($request->file('photo')) {
            $resorcePhoto = $request->file('photo');
            $namePhoto   = "photo_ormawa_" . rand(0000, 9999) . "." . $resorcePhoto->getClientOriginalExtension();
            $resorcePhoto->move(\base_path() . "/public/assets/img/ormawa-logo/", $namePhoto);
        }

        if ($request->file('banner')) {
            $resorceBanner = $request->file('banner');
            $nameBanner   = "banner_ormawa_" . rand(0000, 9999) . "." . $resorceBanner->getClientOriginalExtension();
            $resorceBanner->move(\base_path() . "/public/assets/img/banner-ormawa/", $nameBanner);
        }

        $ck = Ormawa::find(Session::get('id_ormawa'));

        if ($ck) {
            try {
                $ck->nama_akronim = $request->akronim;
                $ck->email = $request->email;
                $ck->deskripsi = $request->deskripsi;
                $ck->website = $request->website;
                $ck->photo = $namePhoto;
                $ck->banner = $nameBanner;
                $ck->save();
                return redirect()->route('ormawa.settings.index')->with('success', 'Data berhasil diupdate');
            } catch (\Throwable $err) {
                return redirect()->route('ormawa.settings.index')->with('failed', 'Data gagal diupdate');
            }
        }

        return redirect()->route('ormawa.settings.index')->with('failed', 'Data tidak ada');
    }

    public function changePassword()
    {
        $navTitle = '<i class="icon-copy dw dw-password mr-2"></i>Ganti Password';
        return view('ormawa.settings.change_password', compact('navTitle'));
    }

    public function tambahPembina(PembinaStoreRequest $req)
    {
        $validated = $req->validated();

        $status = $req->status;
        if ($status == 1) {
            $pembinas = Pembina::where('ormawa_id', Session::get('id_ormawa'))->get();
            if ($pembinas) {
                foreach ($pembinas as $pembina) {
                    Pembina::where('id_pembina', $pembina->id_pembina)->update([
                        'status' => 0,
                    ]);
                }
            }
        }
        try {
            $pb = new Pembina();
            $pb->nidn = $req->nama_dosen;
            $pb->ormawa_id = Session::get('id_ormawa');
            $pb->tahun_jabatan = $req->tahun_jabatan;
            $pb->status = $status;
            $pb->save();

            return redirect()->back()->with('success', 'Tambah pembina berhasil');
        } catch (\Throwable $err) {
            return redirect()->route('ormawa.settings.index')->with('failed', 'Upps error');
        }
    }

    public function editPembina($id_pembina)
    {
        $navTitle = '<i class="icon-copy dw dw-settings mr-2"></i>Update Pembina';

        $pb = Pembina::find($id_pembina);
        if ($pb) {
            try {
                // Semua dosen
                $client = new Client();
                $url = env("SOURCE_API") . "dosen/" . $pb->nidn;
                $rDosen = $client->request('GET', $url, [
                    'verify'  => false,
                ]);
                $dosen = json_decode($rDosen->getBody());

                // all dosen
                $client = new Client();
                $url = env("SOURCE_API") . "dosen/";
                $rDosens = $client->request('GET', $url, [
                    'verify'  => false,
                ]);
                $dosens = json_decode($rDosens->getBody());

                return view('ormawa.settings.pembina_edit', compact('navTitle', 'pb', 'dosens', 'dosen'));
            } catch (\Throwable $err) {
                dd($err);
                return redirect()->route('ormawa.settings.index')->with('failed', 'Data tidak ada');
            }
        }
    }

    public function updatePembina(PembinaStoreRequest $req, $id_pembina)
    {
        $validated = $req->validated();

        $status = $req->status;
        if ($status == 1) {
            $pembinas = Pembina::where('ormawa_id', Session::get('id_ormawa'))->get();
            if ($pembinas) {
                foreach ($pembinas as $pembina) {
                    Pembina::where('id_pembina', $pembina->id_pembina)->update([
                        'status' => 0,
                    ]);
                }
            }
        }
        try {
            $pb = Pembina::find($id_pembina);
            $pb->nidn = $req->nama_dosen;
            $pb->ormawa_id = Session::get('id_ormawa');
            $pb->tahun_jabatan = $req->tahun_jabatan;
            $pb->status = $status;
            $pb->save();

            return redirect()->back()->with('success', 'Update pembina berhasil');
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->route('ormawa.settings.index')->with('failed', 'Update pembina gagal');
        }
    }

    public function deletePembina(Request $request, $id_pembina)
    {
        Pembina::destroy($id_pembina);
        return response()->json([
            "status" => 1,
            "message" => "pembina berhasil dihapus",
        ]);
    }
}
