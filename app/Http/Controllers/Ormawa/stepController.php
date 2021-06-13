<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class stepController extends Controller
{
    public function index()
    {
        $navTitle = '<i class="icon-copy dw dw-startup-2 mr-2"></i>Tahapan';
        return view('ormawa.tahapan.index', compact('navTitle'));
    }
}
