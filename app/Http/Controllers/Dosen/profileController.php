<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class profileController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-center-align mr-2"></span>Profil';
        $api_dosen_controller = new ApiDosenController;

        if (Session::get('is_pembina')) {
            $pengguna = Pengguna::where('nidn', Session::get('nidn'))->first();
            if ($pengguna) {
                $pengguna->dosenRef = null;
                $dosen = $api_dosen_controller->getDosenOnlySomeField($pengguna->nidn);
                if ($dosen) {
                    $pengguna->dosenRef = $dosen;
                }

                return view('dosen.profile.index', compact('navTitle', 'pengguna'));
            }
        }
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'phone' => 'required',
            'alamat' => 'required',
        ]);

        $namePhoto = $request->oldPhoto;
        if ($request->file('photo')) {
            $resorcePhoto = $request->file('photo');
            $namePhoto   = "photo_pengguna_" . rand(0000, 9999) . "." . $resorcePhoto->getClientOriginalExtension();
            $resorcePhoto->move(\base_path() . "/public/assets/img/photo-pengguna/", $namePhoto);
        }

        try {
            $pengguna = Pengguna::where('nidn', Session::get('nidn'))->first();
            $pengguna->email = $request->email;
            $pengguna->phone = $request->phone;
            $pengguna->alamat = $request->alamat;
            $pengguna->photo = $namePhoto;
            $pengguna->save();

            return redirect()->back()->with('success', 'Update profil berhasil');
        } catch (\Throwable $err) {
            return $err;
        }
    }
}
