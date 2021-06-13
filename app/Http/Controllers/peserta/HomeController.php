<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-home mr-2"></span>Dashboard';
        return view('peserta.dashboard', compact('navTitle'));
    }
}
