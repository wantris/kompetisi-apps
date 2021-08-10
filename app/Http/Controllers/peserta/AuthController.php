<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Participant;
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
                    Session::put('nim', $pengguna->nim);
                    Session::put('participant_id', null);
                } elseif ($pengguna->is_mahasiswa == "0" && $pengguna->is_participant == "1") {
                    Session::put('is_mahasiswa', '0');
                    Session::put('is_participant', '1');
                    Session::put('id_pengguna', $pengguna->id_pengguna);
                    Session::put('nim', null);
                    Session::put('participant_id', $pengguna->participant_id);
                }

                if ($request->remember) {
                    setcookie("peserta_login", $pengguna->username, time() + (10 * 365 * 24 * 60 * 60));
                }

                return redirect()->back();
            } else {
                return redirect()->back()->with('failed', 'Password Salah');
            }
        }

        return redirect()->back()->with('failed', 'Username tidak ada');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerSave(Request $request)
    {

        $rules = [
            'nama' => 'required',
            'username' => 'required|unique:penggunas',
            'email' => 'required|email:rfc,dns',
            'password' =>  'required|min:8',
            'confirmPassword' =>  'required|same:password',
        ];

        $customMessages = [
            'nama.required' => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
            'confirmPassword.required' => 'Konfirmasi Password tidak boleh kosong',
            'confirmPassword.same' => 'Konfirmasi password harus sama dengan password',
        ];

        $this->validate($request, $rules, $customMessages);

        $ps = new Participant();
        $ps->nama_participant = $request->nama;
        $ps->save();

        if ($ps) {
            try {
                $user = new Pengguna();
                $user->username = $request->username;
                $user->password = Hash::make($request->password);
                $user->is_mahasiswa = 0;
                $user->is_wadir3 = 0;
                $user->is_pembina = 0;
                $user->is_participant = 1;
                $user->is_dosen = 0;
                $user->participant_id = $ps->id_participant;
                $user->email = $request->email;
                $user->save();

                return redirect()->route('peserta.register.success');
            } catch (\Throwable $err) {
                dd($err);
                return redirect()->back()->with('failed', 'Pendaftaran gagal');
            }
        }
        return redirect()->back()->with('failed', 'Pendaftaran gagal');
    }

    public function registerSuccess()
    {
        return view('auth.register_success');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }
}
