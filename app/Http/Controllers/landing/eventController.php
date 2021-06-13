<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class eventController extends Controller
{
    public function index()
    {
        return view('landing.event.index');
    }

    public function detail($slug)
    {
        return view('landing.event.detail', compact('slug'));
    }

    public function timeline($slug)
    {
        return view('landing.event.timeline', compact('slug'));
    }

    public function registrationTeam($slug)
    {
        return view('landing.event.registrationTeam', compact('slug'));
    }
}
