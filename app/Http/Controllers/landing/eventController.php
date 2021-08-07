<?php

namespace App\Http\Controllers\landing;

use App\EventInternal;
use App\Http\Controllers\Controller;
use App\KategoriEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\invitationTeamMail;
use App\Ormawa;
use App\EventInternalDetail;
use App\EventInternalRegistration;
use App\FileEventInternalDetail;
use App\Pengguna;
use App\Pengumuman;
use App\Timeline;
use App\TimEvent;
use App\TimEventDetail;
use GuzzleHttp\Client;
use App\TipePeserta;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\TmpTimEventDetail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class eventController extends Controller
{
    protected $api_mahasiswa;
    protected $api_dosen;
    protected $pengguna;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->api_mahasiswa = new ApiMahasiswaController;
            $this->api_dosen = new ApiDosenController;
            $this->pengguna = Pengguna::find(Session::get('id_pengguna'));
            return $next($request);
        });
    }

    public function index()
    {
        $events = EventInternal::where('status', '1')->paginate(10);
        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();
        $ormawas = Ormawa::all();
        return view('landing.event.index', compact('events', 'kategoris', 'tipes', 'ormawas'));
    }

    public function detail($slug)
    {

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();
        $check_regis = null;

        if ($event) {
            $id_eventinternal = $event->id_event_internal;

            // Check apakah user yg login sudah mendaftar event
            if (Session::get('id_pengguna') != null) {
                $pengguna = $this->pengguna;

                if ($event->role == "Individu") {
                    if ($pengguna->is_mahasiswa) {
                        $check_regis = EventInternalRegistration::where('nim', $pengguna->nim)
                            ->where('event_internal_id', $event->id_event_internal)->first();
                    } else {
                        $check_regis = EventInternalRegistration::where('participant_id', $pengguna->participant_id)
                            ->where('event_internal_id', $event->id_event_internal)->first();
                    }
                }

                if ($event->role == "Team") {
                    $check_regis = TimEvent::whereHas('eventInternalRegisRef', function ($query) use ($id_eventinternal) {
                        $query->where('event_internal_id', $id_eventinternal);
                    })->whereHas('timDetailRef', function ($query) use ($pengguna) {
                        if ($pengguna->is_mahasiswa) {
                            $query->where('nim', $pengguna->nim);
                        } else {
                            $query->where('participant_id', $pengguna->participant_id);
                        }
                    })->first();
                }
            }

            // Mengambil dokumen pendaftaran
            $feis = FileEventInternalDetail::whereHas('eventDetailRef', function ($q) use ($id_eventinternal) {
                $q->where('event_internal_id', '=', $id_eventinternal);
            })->where('tipe', 'pendaftaran')->get();
            $pns = Pengumuman::where('event_internal_id', $id_eventinternal)->get();



            return view('landing.event.detail', compact('slug', 'event', 'feis', 'pns', 'check_regis'));
        }

        return redirect()->back()->with('failed', 'Data tidak ada');
    }

    public function timeline($slug)
    {
        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();

        if ($event) {
            $tls = Timeline::where('event_internal_id', $event->id_event_internal)->get();
            return view('landing.event.timeline', compact('slug', 'tls', 'event'));
        }

        return redirect()->back()->with('failed', 'Upps terjadi error');
    }


    // ADDITIONAL FEATURE
    public function registration($slug)
    {

        if (Session::get('id_pengguna') != null) {
            $pengguna = $this->pengguna;
            if ($pengguna->is_mahasiswa) {
                $penggunaRef = $pengguna->nim;
            } else {
                $penggunaRef = $pengguna->participant_id;
            }
        }

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();
        if ($event) {
            switch ($event->role) {
                case 'Team':
                    return redirect()->route('event.registration.team', $slug);
                    break;

                default:
                    $is_win = array('is_win' => '0', 'position' => null);
                    $regis = new EventInternalRegistration();
                    $regis->event_internal_id = $event->id_event_internal;
                    if (Session::get('is_mahasiswa') == "1") {
                        $regis->nim = $penggunaRef;
                        $regis->participant_id = null;
                    } else {
                        $regis->nim = null;
                        $regis->participant_id = $penggunaRef;
                    }
                    $regis->is_win = json_encode($is_win);
                    $regis->status = 0;
                    $regis->save();

                    return redirect()->route('peserta.eventinternal.index');
                    break;
            }
        } else {
            return redirect()->back()->with('failed', 'Event tidak ada');
        }
    }

    public function download($id_file)
    {
        $check = FileEventInternalDetail::find($id_file);

        if ($check) {
            $file = public_path() . "/assets/file/dokumen_event/" . $check->filename;

            return response()->download($file, $check->nama_file);
        }
    }

    public function registrationTeam($slug)
    {
        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();

        $user_logged = $this->pengguna;


        if (!$user_logged) {
            return redirect()->route('project.index')->with('failed', 'Anda harus login');
        }

        if ($user_logged->nim) {
            $user_logged->mahasiswaRef = null;
            $mhs = $this->api_mahasiswa->getMahasiswaSomeField($user_logged->nim);
            dd($mhs);
            if ($mhs) {
                $user_logged->mahasiswaRef = $mhs;
            }
        }
        dd($user_logged);
        return view('landing.event.registrationTeam', compact('slug', 'user_logged', 'event'));
    }

    public function saveRegistrationTeam(Request $request, $slug)
    {
        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('slug', $slug)->first();

        $tim = new TimEvent();
        $tim->status = 0;
        $tim->save();

        if ($tim) {

            // registrasi event
            $is_win = array('is_win' => '0', 'position' => null);

            $eir = new EventInternalRegistration();
            $eir->event_internal_id = $event->id_event_internal;
            $eir->tim_event_id = $tim->id_tim_event;
            $eir->is_win = json_encode($is_win);
            $eir->status = 0;
            $eir->save();

            // Ketua
            $pengguna = Pengguna::find($request->ketua);
            $ted = new TimEventDetail();
            $ted->tim_event_id = $tim->id_tim_event;
            if ($pengguna->is_mahasiswa) {
                $ted->nim = $pengguna->nim;
            } else {
                $ted->participant_id = $pengguna->participant_id;
            }
            $ted->role = "ketua";
            $ted->status = "Done";
            $ted->save();

            // Anggota
            foreach ($request->anggota as $key => $item) {
                $anggota = Pengguna::find($item);

                // insert to temporary team detail
                $ted = new TimEventDetail();
                $ted->tim_event_id = $tim->id_tim_event;
                if ($anggota->is_mahasiswa) {
                    $ted->nim = $anggota->nim;
                } else {
                    $ted->participant_id = $anggota->participant_id;
                }
                $ted->role = "anggota";
                $ted->status = "Pending";
                $ted->save();

                // send email
                try {
                    if ($pengguna->is_mahasiswa) {
                        $nama = $this->api_mahasiswa->getMahasiswaByNim($pengguna->nim)->mahasiswa_nama;
                    } else {
                        $nama = $pengguna->participantRef->nama_participant;
                    }
                    Mail::to($pengguna->email)->send(new invitationTeamMail($nama, $slug, $ted->id_tim_event_detail));
                } catch (\Throwable $err) {
                }
            }

            return redirect()->route('peserta.team.index')->with('success', 'Pendaftaran event berhasil');
        }
    }

    // look invitation from someone
    public function lookInvitation($id_detail)
    {
        if (!Session::get('id_pengguna')) {
            return view('landing.login', compact('id_detail'));
        }

        $to_invite = TimEventDetail::find($id_detail);
        if ($to_invite) {
            $from_invite = TimEventDetail::with('participantRef', 'penggunaMhsRef', 'penggunaParticipantRef')->where('tim_event_id', $to_invite->tim_event_id)->where('role', 'ketua')->first();
            if ($from_invite->penggunaMhsRef) {
                $from_invite->penggunaMhsRef->nama_mhs = $from_invite->penggunaMhsRef->nim;
                try {
                    $mhs =  $this->api_mahasiswa->getMahasiswaByNim($from_invite->penggunaMhsRef->nim);
                    $from_invite->penggunaMhsRef->nama_mhs = $mhs->mahasiswa_nama;
                } catch (\Throwable $err) {
                }
            }
        }

        return view('landing.event.invitation_team', compact('id_detail', 'to_invite', 'from_invite'));
    }


    public function searchPengguna($id)
    {
        $year = Carbon::now()->year;
        $cut_year = substr($year, -2);
        (string)$minus_year = (int)$cut_year - 3;

        $api_mahasiswa = $this->api_mahasiswa;
        $mahasiswas = collect();

        $mahasiswa_api = Cache::remember('all_mahasiswa', 120, function () use ($api_mahasiswa) {
            return $api_mahasiswa->getAllMahasiswa();
        });

        foreach ($mahasiswa_api as $api) {
            $mahasiswas->push($api);
        }

        // Cari pengguna yang tidak ada dalam tim detail dan yang tidak terdaftar pada tim $id
        $penggunas = Pengguna::with('participantRef')->where('id_pengguna', '!=', Session::get('id_pengguna'))
            ->where(function ($query) use ($minus_year, $cut_year) {
                $query->where('is_mahasiswa', 1);
                $query->whereBetween('nim', [$minus_year . '%', $cut_year . '%']);
            })->orWhere('is_participant', 1)->get();

        $penggunas->each(function ($item, $key) use ($mahasiswas) {
            if ($item->nim) {
                try {
                    $mhs =  $mahasiswas->where('mahasiswa_nim', $item->nim)->first();
                    $item->mahasiswaRef = $mhs;
                } catch (\Throwable $err) {
                }
            }
        });

        return response()->json($penggunas);
    }
}
