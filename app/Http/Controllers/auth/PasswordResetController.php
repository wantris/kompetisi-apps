<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\PasswordReset;
use App\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\PasswordResetEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function index()
    {
        return view('auth.passwordResetMahasiswa');
    }

    public function resetProcess(Request $request)
    {
        $rules = [
            'email' => 'required|email:rfc,dns',
        ];

        $customMessages = [
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
        ];

        $this->validate($request, $rules, $customMessages);

        $pengguna = Pengguna::where('email', $request->email)->first();
        if ($pengguna) {
            $token = Str::random(50);
            $reset = new PasswordReset();
            $reset->pengguna_id = $pengguna->id_pengguna;
            $reset->email = $request->email;
            $reset->reset_token = $token;
            $reset->save();

            Mail::to($pengguna->email)->send(new PasswordResetEmail($pengguna, $token));

            return redirect('/')->with('success', 'Reset password berhasil, cek email');
        } else {
            return redirect()->back()->with('failed', 'Email tidak terdaftar');
        }
    }

    public function newPassword()
    {
        $reset = PasswordReset::where('reset_token', request()->token)->first();
        if ($reset) {
            return view('auth.new_password', compact('reset'));
        } else {
            return redirect('/')->with('failed', 'Token tidak ada');
        }
    }

    public function newPasswordSave(Request $request)
    {
        $rules = [
            'password' =>  'required|min:8',
            'confirmPassword' =>  'required|same:password',
        ];

        $customMessages = [
            'password.required' => 'Password tidak boleh kosong',
            'confirmPassword.required' => 'Konfirmasi Password tidak boleh kosong',
            'confirmPassword.same' => 'Konfirmasi password harus sama dengan password',
        ];
        $this->validate($request, $rules, $customMessages);

        $pengguna = Pengguna::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect('/')->with('success', 'Reset password berhasil');
    }
}
