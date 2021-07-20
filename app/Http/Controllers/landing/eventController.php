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
use App\TmpTimEventDetail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class eventController extends Controller
{
    public function index()
    {
        $events = EventInternal::where('status', '1')->paginate(1);
        $kategoris = KategoriEvent::all();
        $tipes = TipePeserta::all();
        $ormawas = Ormawa::all();
        return view('landing.event.index', compact('events', 'kategoris', 'tipes', 'ormawas'));
    }

    public function detail($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();
        $check_regis = null;
        if ($event) {
            $id_eventinternal = $event->id_event_internal;

            // Check apakah user yg login sudah mendaftar event
            if (Session::get('id_pengguna') != null) {
                $pengguna = Pengguna::find(Session::get('id_pengguna'));

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

                // dd($check_regis);
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
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        if ($event) {
            $tls = Timeline::where('event_internal_id', $event->id_event_internal)->get();
            return view('landing.event.timeline', compact('slug', 'tls', 'event'));
        }

        return redirect()->back()->with('failed', 'Upps terjadi error');
    }


    // ADDITIONAL FEATURE
    public function registration($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);

        if (Session::get('id_pengguna') != null) {
            $pengguna = Pengguna::find(Session::get('id_pengguna'));
            if ($pengguna->is_mahasiswa) {
                $penggunaRef = $pengguna->nim;
            } else {
                $penggunaRef = $pengguna->participant_id;
            }
        }

        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();
        if ($event) {
            switch ($event->role) {
                case 'Team':
                    return redirect()->route('event.registration.team', $slug);
                    break;

                default:
                    $regis = new EventInternalRegistration();
                    $regis->event_internal_id = $event->id_event_internal;
                    if (Session::get('is_mahasiswa') == "1") {
                        $regis->nim = $penggunaRef;
                        $regis->participant_id = null;
                    } else {
                        $regis->nim = null;
                        $regis->participant_id = $penggunaRef;
                    }
                    $regis->is_win = "{}";
                    $regis->save();

                    return redirect()->route('peserta.eventeventinternal.index');
                    break;
            }
        } else {
            return redirect()->back()->with('failed', 'Event tidak ada');
        }
    }

    public function registrationTeam($slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);
        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        $penggunas = Pengguna::with('participantRef')->where('is_mahasiswa', 1)->orWhere('is_participant', 1)->get();
        foreach ($penggunas as $item) {
            $item->nama_mhs = null;
            if ($item->nim) {
                try {
                    $mhs = $this->getMahasiswaByNim($item->nim);

                    $item->nama_mhs = $mhs->nama;
                } catch (\Throwable $err) {
                }
            }
        }

        $user_logged = Pengguna::find(Session::get('id_pengguna'));

        if (!$user_logged) {
            return redirect()->route('project.index')->with('failed', 'Anda harus login');
        }

        if ($user_logged->nim) {
            try {
                $mhs = $this->getMahasiswaByNim($user_logged->nim);

                $user_logged->nama_mhs = $mhs->nama;
            } catch (\Throwable $err) {
            }
        }

        return view('landing.event.registrationTeam', compact('slug', 'penggunas', 'user_logged', 'event'));
    }

    public function saveRegistrationTeam(Request $request, $slug)
    {
        // remove slug string "-"
        $removeSlug = str_ireplace(array('-'), ' ', $slug);
        $event = EventInternal::with('ormawaRef', 'kategoriRef', 'tipePesertaRef')->where('nama_event', $removeSlug)->first();

        $tim = new TimEvent();
        $tim->save();

        if ($tim) {

            // registrasi event
            $is_win = array('is_win' => '0', 'position' => null);

            $eir = new EventInternalRegistration();
            $eir->event_internal_id = $event->id_event_internal;
            $eir->tim_event_id = $tim->id_tim_event;
            $eir->is_win = json_encode($is_win);
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
                        $nama = $this->getMahasiswaByNim($pengguna->nim)->nama;
                    } else {
                        $nama = $pengguna->participantRef->nama_participant;
                    }
                    Mail::to($pengguna->email)->send(new invitationTeamMail($nama, $removeSlug, $ted->id_tim_event_detail));
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
                    $mhs = $this->getMahasiswaByNim($from_invite->penggunaMhsRef->nim);
                    $from_invite->penggunaMhsRef->nama_mhs = $mhs->nama;
                } catch (\Throwable $err) {
                }
            }
        }

        return view('landing.event.invitation_team', compact('id_detail', 'to_invite', 'from_invite'));
    }


    public function searchPengguna($id)
    {
        // Cari pengguna yang tidak ada dalam tim detail dan yang tidak terdaftar pada tim $id
        $invites = Pengguna::with('participantRef')->where('id_pengguna', '!=', Session::get('id_pengguna'))
            ->where(function ($query) {
                $query->where('is_mahasiswa', 1);
                $query->orWhere('is_participant', 1);
            })->get();

        // get name mahasiswa from api
        foreach ($invites as $item2) {
            $item2->nama_mhs = null;
            if ($item2->nim) {
                try {
                    // Get nama mahasiswa
                    $item2->nama_mhs = $this->getMahasiswaByNim($item2->nim)->nama;
                } catch (\Throwable $err) {
                }
            }
        }

        return response()->json($invites);
    }


    public function getMahasiswaByNim($nim)
    {
        $client = new Client();
        $url = env("SOURCE_API") . "mahasiswa/detail/" . $nim;
        $rMhs = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $mhs = json_decode($rMhs->getBody());

        return $mhs;
    }
}
