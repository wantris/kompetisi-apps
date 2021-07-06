<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Session};

class AuthController extends Controller
{
    public function postLogin(Request $req)
    {
        $username = $req->username;
        $password = $req->password;

        $check_username = Ormawa::where('username', $username)->first();
        // check username
        if ($check_username) {
            if (Hash::check($password, $check_username->password)) {
                Session::put('is_ormawa', '1');
                Session::put('id_ormawa', $check_username->id_ormawa);
                return redirect()->route('ormawa.index');
            } else {
                return redirect()->back()->with('failed', 'Password salah');
            }
        } else {
            return redirect()->back()->with('failed', 'Username tidak ada');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
