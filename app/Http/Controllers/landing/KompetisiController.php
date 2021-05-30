<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KompetisiController extends Controller
{
    public function index()
    {
        return view('landing.kompetisi.index');
    }

    public function detail($slug)
    {
        return view('landing.kompetisi.detail', compact('slug'));
    }

    public function timeline($slug)
    {
        return view('landing.kompetisi.timeline', compact('slug'));
    }

    public function registrationTeam($slug)
    {
        return view('landing.kompetisi.registrationTeam', compact('slug'));
    }
}
