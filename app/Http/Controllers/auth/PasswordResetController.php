<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function index()
    {
        return view('auth.passwordResetMahasiswa');
    }
}
