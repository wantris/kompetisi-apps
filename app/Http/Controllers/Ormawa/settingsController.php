<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class settingsController extends Controller
{
    public function index()
    {
        $navTitle = '<i class="icon-copy dw dw-settings mr-2"></i>Pengaturan Profil';
        return view('ormawa.settings.index', compact('navTitle'));
    }

    public function changePassword()
    {
        $navTitle = '<i class="icon-copy dw dw-password mr-2"></i>Ganti Password';
        return view('ormawa.settings.change_password', compact('navTitle'));
    }
}
