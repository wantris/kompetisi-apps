<?php

namespace App\Http\Controllers\peserta;

use App\EventEksternalRegistration;
use App\EventInternalRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Participant;
use App\Pengguna;
use App\TimEvent;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\PrestasiEventEksternal;
use App\PrestasiEventInternal;

class AccountController extends Controller
{
    protected $api_mahasiswa;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->api_mahasiswa = new ApiMahasiswaController;
            return $next($request);
        });
    }

    public function index()
    {
        $navTitle = '<span class="micon dw dw-user-12 mr-2"></span> Pengaturan Profil';
        $pengguna = Pengguna::find(Session::get('id_pengguna'));
        if ($pengguna) {
            $pengguna->mahasiswaRef = null;
            if ($pengguna->nim) {
                $mhs = $this->api_mahasiswa->getMahasiswaSomeField($pengguna->nim);
                if ($mhs) {
                    $pengguna->mahasiswaRef = $mhs;
                }
            }
            return view('peserta.account.index', compact('navTitle', 'pengguna'));
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

    public function getAllEvent()
    {
        $pengguna = Pengguna::find(Session::get('id_pengguna'));

        $pendaftaran = collect();
        $pendaftaran_internals = $this->getEventInternal($pengguna);
        $pendaftaran_eksternals = $this->getEventEksternal($pengguna);
        foreach ($pendaftaran_internals as $internal) {
            $pendaftaran->push($internal);
        }

        foreach ($pendaftaran_eksternals as $eksternal) {
            $pendaftaran->push($eksternal);
        }

        $convert_pendaftaran = $pendaftaran->groupBy(function ($val) {
            return \Carbon\Carbon::parse($val->created_at)->format('M_Y');
        });

        return response()->json($convert_pendaftaran);
    }

    public function getEventInternal($pengguna)
    {
        $pendaftaran = collect();
        $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
            $query->where('status', 'Done');
        })->get();

        $regis_individus = EventInternalRegistration::with('eventInternalRef', 'eventInternalRef.ormawaRef')->where(function ($query) use ($pengguna) {
            if ($pengguna->nim) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
        })->get();

        if ($regis_individus->count() > 0) {
            foreach ($regis_individus as $regis) {
                $pendaftaran->push($regis);
            }
        }

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $regis_tim = EventInternalRegistration::with('eventInternalRef', 'eventInternalRef.ormawaRef')->where('tim_event_id', $tim->id_tim_event)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 1);
                })->first();

                if ($regis_tim) {
                    $pendaftaran->push($regis_tim);
                }
            }
        }

        return $pendaftaran;
    }

    public function getEventEksternal($pengguna)
    {
        $pendaftaran = collect();

        $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            }
            $query->where('status', 'Done');
        })->get();

        $regis_individus = EventEksternalRegistration::with('eventEksternalRef', 'eventEksternalRef.cakupanOrmawaRef.ormawaRef')->where(function ($query) use ($pengguna) {
            if ($pengguna->nim) {
                $query->where('nim', $pengguna->nim);
            }
        })->get();

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $regis_tim = EventEksternalRegistration::with('eventEksternalRef')->where('tim_event_id', $tim->id_tim_event)->whereHas('eventEksternalRef', function ($query) {
                    $query->where('status', 1);
                })->first();

                if ($regis_tim) {
                    $pendaftaran->push($regis_tim);
                }
            }
        }

        if ($regis_individus->count() > 0) {
            foreach ($regis_individus as $regis) {
                $pendaftaran->push($regis);
            }
        }

        return $pendaftaran;
    }

    public function getPrestasi()
    {
        $pengguna = Pengguna::find(Session::get('id_pengguna'));
        $all_prestasi = collect();
        if ($pengguna) {

            $prestasi_internal = $this->getPrestasiInternal($pengguna);
            $prestasi_eksternal = $this->getPrestasiEksternal($pengguna);

            if ($prestasi_internal->count() > 0) {
                foreach ($prestasi_internal as $internal) {
                    $all_prestasi->push($internal);
                }
            }

            if ($prestasi_eksternal->count() > 0) {
                foreach ($prestasi_eksternal as $eksternal) {
                    $all_prestasi->push($eksternal);
                }
            }
        }

        return response()->json($all_prestasi);
    }

    public function getPrestasiInternal($pengguna)
    {

        $pendaftaran = collect();
        $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
            $query->where('status', 'Done');
        })->get();

        $regis_individus = EventInternalRegistration::where(function ($query) use ($pengguna) {
            if ($pengguna->nim) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
        })->get();

        if ($regis_individus->count() > 0) {
            foreach ($regis_individus as $regis) {
                $pendaftaran->push($regis);
            }
        }

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $regis_tim = EventInternalRegistration::where('tim_event_id', $tim->id_tim_event)->whereHas('eventInternalRef', function ($query) {
                    $query->where('status', 1);
                })->first();

                if ($regis_tim) {
                    $pendaftaran->push($regis_tim);
                }
            }
        }

        $prestasi = collect();
        if ($pendaftaran->count() > 0) {
            foreach ($pendaftaran as $p) {
                $pres = PrestasiEventInternal::with('eventInternalRegisRef.eventInternalRef', 'eventInternalRegisRef.eventInternalRef.ormawaRef')->where('event_internal_registration_id', $p->id_event_internal_registration)->first();
                if ($pres) {
                    $prestasi->push($pres);
                }
            }
        }
        return $prestasi;
    }

    public function getPrestasiEksternal($pengguna)
    {
        $pendaftaran = collect();

        $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            }
            $query->where('status', 'Done');
        })->get();

        $regis_individus = EventEksternalRegistration::where(function ($query) use ($pengguna) {
            if ($pengguna->nim) {
                $query->where('nim', $pengguna->nim);
            }
        })->get();

        if ($tims->count() > 0) {
            foreach ($tims as $tim) {
                $regis_tim = EventEksternalRegistration::where('tim_event_id', $tim->id_tim_event)->whereHas('eventEksternalRef', function ($query) {
                    $query->where('status', 1);
                })->first();

                if ($regis_tim) {
                    $pendaftaran->push($regis_tim);
                }
            }
        }

        if ($regis_individus->count() > 0) {
            foreach ($regis_individus as $regis) {
                $pendaftaran->push($regis);
            }
        }

        $prestasi = collect();
        if ($pendaftaran->count() > 0) {
            foreach ($pendaftaran as $p) {
                $pres = PrestasiEventEksternal::with('eventEksternalRegisRef.eventEksternalRef', 'eventEksternalRegisRef.eventEksternalRef.cakupanOrmawaRef.ormawaRef')->where('event_eksternal_regis_id', $p->id_event_eksternal_registration)->first();
                if ($pres) {
                    $prestasi->push($pres);
                }
            }
        }

        return $prestasi;
    }

    public function changePassword()
    {
        $navTitle = '<i class="icon-copy dw dw-password mr-2"></i>Ganti Password';
        return view('peserta.account.change_password', compact('navTitle'));
    }


    public function processChangePassword(Request $request)
    {
        $rules = [
            'password' =>  'required',
            'new_password' =>  'required|min:8',
            'confirm_new_password' =>  'required|same:new_password',
        ];

        $customMessages = [
            'new_password.min:8' => "Minimal 8 karakter",
            'password.required' => 'Password tidak boleh kosong',
            'new_password.required' => 'Password baru tidak boleh kosong',
            'confirm_new_password.required' => 'Konfirmasi Password tidak boleh kosong',
            'confirm_new_password.same' => 'Konfirmasi password baru harus sama dengan password baru',
        ];

        $this->validate($request, $rules, $customMessages);

        $pengguna = Pengguna::find(Session::get('id_pengguna'));
        if ($pengguna) {
            if (Hash::check($request->password, $pengguna->password)) {
                $pengguna->password = Hash::make($request->new_password);
                $pengguna->save();

                return redirect()->back()->with('success', 'Password berhasil diganti');
            }
            return redirect()->back()->with('failed', 'Password lama tidak sesuai');
        }
        return redirect()->back()->with('failed', 'pengguna tidak ada');
    }
}
