<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class eventController extends Controller
{
    public function index()
    {
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Event';
        return view('peserta.event.index', compact('navTitle'));
    }

    public function detail($slug)
    {
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Daftar Event';
        return view('peserta.event.detail', compact('slug', 'navTitle'));
    }

    public function submission($slug)
    {
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Submission';
        return view('peserta.event.submission', compact('slug', 'navTitle'));
    }

    public function info($slug)
    {
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Info Submission';
        return view('peserta.event.submission_info', compact('slug', 'navTitle'));
    }

    public function notification($slug)
    {
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Pengumuman';
        return view('peserta.event.notification', compact('slug', 'navTitle'));
    }

    public function timeline($slug)
    {
        $navTitle = '<span class="micon dw dw-up-chevron-1 mr-2"></span>Timeline';
        return view('peserta.event.timeline', compact('slug', 'navTitle'));
    }
}
