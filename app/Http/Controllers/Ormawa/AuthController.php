<?php

namespace App\Http\Controllers\Ormawa;

use App\Http\Controllers\Controller;
use App\Ormawa;
use App\Pembina;
use App\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Session};

class AuthController extends Controller
{
    public function postLogin(Request $req)
    {
        $username = $req->username;
        $password = $req->password;
        $role = $req->role;
        if ($role == "pengurus") {
            $check_username = Ormawa::where('username', $username)->first();
            // check username
            if ($check_username) {
                if (Hash::check($password, $check_username->password)) {
                    Session::put('is_ormawa', '1');
                    Session::put('is_pembina', '0');
                    Session::put('is_dosen', '0');
                    Session::put('id_ormawa', $check_username->id_ormawa);
                    return redirect()->route('ormawa.index');
                } else {
                    return redirect()->back()->with('failed', 'Password salah');
                }
            } else {
                return redirect()->back()->with('failed', 'Username tidak ada');
            }
        } else {
            $check_username = Pengguna::where('username', $username)->first();
            // check username
            if ($check_username) {
                if (!$check_username->pembinaRef) {
                    Session::put('is_ormawa', '0');
                    Session::put('is_pembina', '0');
                    Session::put('is_dosen', '1');
                    Session::put('nidn', $check_username->nidn);
                    return redirect()->route('dosen.index')->with('failed', 'Ormawa yang dibina saat ini tidak ada');
                    // return redirect()->back()->with('failed', 'Uppss maaf tidak bisa');
                }


                if (Hash::check($password, $check_username->password)) {
                    $pembina = Pembina::where('nidn', $check_username->nidn)->where('status', 1)->first();
                    if ($pembina) {
                        Session::put('is_ormawa', '1');
                        Session::put('is_pembina', '1');
                        Session::put('is_dosen', '1');
                        Session::put('id_ormawa', $pembina->ormawa_id);
                        Session::put('id_pembina', $pembina->id_pembina);
                        Session::put('nidn', $check_username->nidn);

                        return redirect()->route('ormawa.index');
                    } else {
                        return redirect()->back()->with('failed', 'Maaf anda bukan lagi pembina');
                    }
                } else {
                    return redirect()->back()->with('failed', 'Password salah');
                }
            } else {
                return redirect()->back()->with('failed', 'Username tidak ada');
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
