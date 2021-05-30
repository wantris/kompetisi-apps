<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class loginController extends Controller
{
    public function index()
    {
        if (Route::current()->getName() == 'login.mahasiswa.index') {
            return view('auth.loginMahasiswa');
        } else if (Route::current()->getName() == 'login.ormawa.index') {
            return view('auth.loginOrmawa');
        }
    }
}
