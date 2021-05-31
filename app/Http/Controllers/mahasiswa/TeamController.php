<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return view('mahasiswa.team.index');
    }

    public function detail($id)
    {
        return view('mahasiswa.team.detail', compact('id'));
    }
}
