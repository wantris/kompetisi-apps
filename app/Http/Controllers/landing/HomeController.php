<?php

namespace App\Http\Controllers\landing;

use App\EventInternal;
use App\Http\Controllers\Controller;
use App\Ormawa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $ormawas = Ormawa::all();
        $events = EventInternal::where('status', '1')->take(2)->get();
        return view('home', compact('ormawas', 'events'));
    }
}
