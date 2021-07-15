<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function postLogin(Request $request)
    {
        $rules = [
            'username_mhs' => 'required',
            'password_mhs' => 'required',
        ];

        $customMessages = [
            'username_mhs.required' => 'Username wajib diisi',
            'password_mhs.required' => 'Password wajib diisi'
        ];

        $this->validate($request, $rules, $customMessages);

        $pengguna = Pengguna::where('username', $request->username_mhs)->first();
        if ($pengguna) {
            // Cek password
            if (Hash::check($request->password_mhs, $pengguna->password)) {
                // Cek jika yg login adalah mahasiswa
                if ($pengguna->is_mahasiswa == "1") {
                    Session::put('is_mahasiswa', '1');
                    Session::put('is_participant', '0');
                    Session::put('id_pengguna', $pengguna->id_pengguna);

                    return redirect()->back();
                } elseif ($pengguna->is_mahasiswa == "0" && $pengguna->is_participant == "1") {
                    Session::put('is_mahasiswa', '0');
                    Session::put('is_participant', '1');
                    Session::put('id_pengguna', $pengguna->id_pengguna);
                    return redirect()->back();
                }

                return redirect()->back()->with('failed', 'Upps terjadi error');
            } else {
                return redirect()->back()->with('failed', 'Password Salah');
            }
        }

        return redirect()->back()->with('failed', 'Username tidak ada');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
