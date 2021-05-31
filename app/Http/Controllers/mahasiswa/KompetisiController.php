<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KompetisiController extends Controller
{
    public function index()
    {
        // dd(Request()->route()->getPrefix());
        return view('mahasiswa.kompetisi.index');
    }

    public function detail($slug)
    {
        return view('mahasiswa.kompetisi.detail', compact('slug'));
    }

    public function submission($slug)
    {
        return view('mahasiswa.kompetisi.submission', compact('slug'));
    }

    public function info($slug)
    {
        return view('mahasiswa.kompetisi.submission_info', compact('slug'));
    }

    public function notification($slug)
    {
        return view('mahasiswa.kompetisi.notification', compact('slug'));
    }

    public function timeline($slug)
    {
        return view('mahasiswa.kompetisi.timeline', compact('slug'));
    }
}
