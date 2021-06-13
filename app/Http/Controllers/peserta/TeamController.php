<?php

namespace App\Http\Controllers\peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return view('peserta.team.index');
    }

    public function detail($id)
    {
        return view('peserta.team.detail', compact('id'));
    }
}
