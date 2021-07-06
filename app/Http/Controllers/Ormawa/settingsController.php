<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Ormawa;
use Illuminate\Http\Request;

class settingsController extends Controller
{
    public function index()
    {
        $ormawa = Ormawa::find(Session::get('id_ormawa'));
        $navTitle = '<i class="icon-copy dw dw-settings mr-2"></i>Pengaturan Profil';
        return view('ormawa.settings.index', compact('navTitle', 'ormawa'));
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
}
