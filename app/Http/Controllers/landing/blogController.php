<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class blogController extends Controller
{
    public function index()
    {
        return view('landing.blog.index');
    }

    public function detail($slug)
    {
        return view('landing.blog.detail', compact('slug'));
    }
}
