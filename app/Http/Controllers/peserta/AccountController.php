<?php

namespace App\Http\Controllers\peserta;

use App\EventInternalRegistration;
use App\Http\Controllers\Controller;
use App\Participant;
use App\Pengguna;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\endpoint\ApiMahasiswaController;

class AccountController extends Controller
{
    protected $api_mahasiswa;

    public function __construct()
    {
        $this->api_mahasiswa = new ApiMahasiswaController;
    }

    public function index()
    {
        $navTitle = '<span class="micon dw dw-user-12 mr-2"></span> Pengaturan Profil';
        $pengguna = Pengguna::find(Session::get('id_pengguna'));
        if ($pengguna) {
            $pengguna->mahasiswaRef = null;
            if ($pengguna->nim) {
                // History event
                $event_regis = EventInternalRegistration::with('eventInternalRef')->where('nim', $pengguna->nim)->get();

                $mhs = $this->api_mahasiswa->getMahasiswaByNim($pengguna->nim);
                $pengguna->mahasiswaRef = $mhs;
            } else {
                // History event
                $event_regis = EventInternalRegistration::with('eventInternalRef')->where('participant_id', $pengguna->participant_id)->get();
            }
            return view('peserta.account.index', compact('navTitle', 'pengguna', 'event_regis'));
        }
    }

    public function postAccount(Request $request)
    {
        try {
            if (Session::get('is_participant') == "1") {
                $pengguna = Pengguna::findOrFail(Session::get('id_pengguna'));
                $ps = Participant::findOrFail($pengguna->participant_id);
                $ps->nama_participant = $request->nama;
                $ps->save();
            }

            $user = Pengguna::find(Session::get('id_pengguna'));
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->alamat = $request->alamat;
            $user->save();

            return redirect()->back()->with('success', 'Update profil berhasil');
        } catch (\Throwable $err) {
            dd($err);
            return redirect()->back()->with('failed', 'Update profil gagal');
        }
    }

    public function savePhoto(Request $request)
    {
        $namePhoto = $request->oldPhoto;

        if ($request->file('photo')) {
            $resorcePhoto = $request->file('photo');
            $namePhoto   = "photo_pengguna_" . rand(0000, 9999) . "." . $resorcePhoto->getClientOriginalExtension();
            $resorcePhoto->move(\base_path() . "/public/assets/img/photo-pengguna/", $namePhoto);
        }

        try {
            $user = Pengguna::find(Session::get('id_pengguna'));
            $user->photo = $namePhoto;
            $user->save();

            return redirect()->back()->with('success', 'Update photo berhasil');
        } catch (\Throwable $err) {
            return redirect()->back()->with('failed', 'Update photo gagal');
        }
    }

    public function saveSocialMedia(Request $request)
    {
        try {
            $user = Pengguna::find(Session::get('id_pengguna'));
            $user->facebook_url = $request->facebook;
            $user->twitter_url = $request->twitter;
            $user->insta_url = $request->instagram;
            $user->linkedin_url = $request->linkedin;
            $user->save();

            return redirect()->back()->with('success', 'Update sosial media berhasil');
        } catch (\Throwable $err) {
            return redirect()->back()->with('failed', 'Update sosial media gagal');
        }
    }
}
