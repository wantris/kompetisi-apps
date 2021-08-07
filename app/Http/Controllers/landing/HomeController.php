<?php

namespace App\Http\Controllers\landing;

use App\EventInternal;
use App\Http\Controllers\Controller;
use App\Ormawa;
use App\Pengguna;
use App\Slider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $ormawas = Ormawa::all();
        $events = EventInternal::where('status', '1')->take(2)->get();
        $sliders = Slider::where('is_active', 1)->get();
        return view('home', compact('ormawas', 'events', 'sliders'));
    }

    public function login()
    {
        return view('landing.login');
    }

    public function postLogin(Request $request)
    {

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $customMessages = [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi'
        ];

        $this->validate($request, $rules, $customMessages);


        $pengguna = Pengguna::where('username', $request->username)->first();
        if ($pengguna) {
            // Cek password
            if (Hash::check($request->password, $pengguna->password)) {
                // Cek jika yg login adalah mahasiswa
                if ($pengguna->is_mahasiswa == "1") {
                    Session::put('is_mahasiswa', '1');
                    Session::put('is_participant', '0');
                    Session::put('id_pengguna', $pengguna->id_pengguna);
                    Session::put('nim', $pengguna->nim);
                    Session::put('participant_id', null);

                    return redirect()->route('event.invitation.look', $request->id_detail);
                } elseif ($pengguna->is_mahasiswa == "0" && $pengguna->is_participant == "1") {
                    Session::put('is_mahasiswa', '0');
                    Session::put('is_participant', '1');
                    Session::put('id_pengguna', $pengguna->id_pengguna);
                    Session::put('nim', null);
                    Session::put('participant_id', $pengguna->participant_id);

                    return redirect()->route('event.invitation.look', $request->id_detail);
                }

                return redirect()->back()->with('failed', 'Upps terjadi error');
            } else {
                return redirect()->back()->with('failed', 'Password Salah');
            }
        }

        return redirect()->back()->with('failed', 'Username tidak ada');
    }
}
