<?php

namespace App\Http\Controllers\peserta;

use App\EventInternal;
use App\EventInternalRegistration;
use App\Http\Controllers\Controller;
use App\Pengguna;
use App\TimEvent;
use App\TimEventDetail;
use App\EventEksternal;
use Illuminate\Support\Facades\Mail;
use App\TmpTimEventDetail;
use App\Mail\invitationTeamMail;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Http\Controllers\endpoint\ApiDosenController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TeamController extends Controller
{
    protected $id_tim;
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
        $navTitle = '<span class="micon dw dw-user-11 mr-2"></span>Team';

        $pengguna = $this->pengguna;

        // Tim yg status nya Done bukan pending
        $tims = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
            $query->where('status', 'Done');
        })->get();

        // Anggota tim dengan status pending
        $tim_pendings = TimEvent::with('timDetailRef')->whereHas('timDetailRef', function ($query) use ($pengguna) {
            $query->where('status', 'Pending');
            if ($pengguna->is_mahasiswa) {
                $query->where('nim', $pengguna->nim);
            } else {
                $query->where('participant_id', $pengguna->participant_id);
            }
        })->get();

        // Search who invites
        foreach ($tim_pendings as $items) {
            foreach ($items->timDetailRef as $item) {
                $item->invited_by = null;
                if ($item->status == "Pending") {
                    $search = null;
                    $search = TimEventDetail::with('penggunaMhsRef', 'penggunaParticipantRef')->where('tim_event_id', $item->tim_event_id)->where('role', 'ketua')->first();
                    if ($search) {
                        $search->mahasiswaRef = null;
                        if ($search->nim) {
                            try {
                                $search->mahasiswaRef = $this->api_mahasiswa->getMahasiswaSomeField($search->nim);
                            } catch (\Throwable $err) {
                            }
                        }
                        $item->invited_by = $search;
                    }
                }
            }
        }

        return view('peserta.team.index', compact('navTitle', 'tims', 'tim_pendings', 'pengguna'));
    }

    public function detail($id)
    {
        $navTitle = '<span class="micon dw dw-user-11 mr-2"></span>Detail Team';
        $tim = TimEvent::with('timDetailRef')->find($id);
        $pengguna = $this->pengguna;

        if ($tim) {

            // Get all dosen
            $dosens = $this->api_dosen->getAllDosen();

            // Get nama dosen
            if ($tim->nidn) {
                $tim->dosenRef = null;
                $dosen =  $this->api_dosen->getDosenOnlySomeField($tim->nidn);
                if ($dosen) {
                    $tim->dosenRef = $dosen;
                }
            }

            // Check if session login has role ketua
            $check = null;
            if (Session::get('is_mahasiswa') == "1" && Session::get('nim')) {
                $check = TimEventDetail::where('tim_event_id', $tim->id_tim_event)->where('nim', Session::get('nim'))
                    ->where('role', 'ketua')->first();
            } else {
                $check = TimEventDetail::where('tim_event_id', $tim->id_tim_event)->where('participant_id', Session::get('participant_id'))
                    ->where('role', 'ketua')->first();
            }

            // Get name of mahasiswa
            foreach ($tim->timDetailRef as $detail) {
                if ($detail->nim) {
                    $detail->mahasiswaRef = $detail->nim;
                    try {
                        $detail->mahasiswaRef = $this->api_mahasiswa->getMahasiswaSomeField($detail->nim);
                    } catch (\Throwable $err) {
                    }
                }
            }


            // get tim detail for tabs invitational status
            $invitationals = TimEventDetail::with('participantRef', 'penggunaParticipantRef', 'penggunaMhsRef')->where('tim_event_id', $tim->id_tim_event)->where('role', 'anggota')->get();
            if ($invitationals->count() > 0) {
                foreach ($invitationals as $tim_detail) {
                    if ($tim_detail->nim) {
                        $tim_detail->mahasiswaRef = $tim_detail->nim;
                        try {
                            $tim_detail->mahasiswaRef = $this->api_mahasiswa->getMahasiswaSomeField($tim_detail->nim);
                        } catch (\Throwable $err) {
                        }
                    }
                }
            }

            return view('peserta.team.detail', compact(
                'id',
                'navTitle',
                'tim',
                'check',
                'invitationals',
                'dosens',
                'pengguna'
            ));
        }

        return redirect()->back()->with('failed', 'Terjadi error');
    }

    // Terima undangan tim
    public function acceptInvitation(Request $request, $id)
    {
        try {
            $detail = TimEventDetail::where('id_tim_event_detail', $request->id_detail)->update([
                'status' => "Done"
            ]);

            return response()->json([
                "status" => 1,
                "message" => "Berhasil menerima undangan",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 1,
                "message" => $err,
            ]);
        }
    }


    // Tolak undangan
    public function deniedInvitation(Request $request, $id)
    {
        TimEventDetail::destroy($request->id_detail);
        return response()->json([
            "status" => 1,
            "message" => "Berhasil menolak undangan",
        ]);
    }

    public function ajukanPembimbing(Request $request, $id_tim)
    {
        $nidn = $request->nidn;

        try {
            $pengajuan = TimEvent::where('id_tim_event', $id_tim)->update([
                'nidn' => $nidn
            ]);

            return redirect()->back()->with('success', 'Pengajuan Berhasil');
        } catch (\Throwable $err) {
            dd($err);
        }
    }

    public function searchPengguna($id)
    {
        // Cari pengguna yang tidak ada dalam tim detail dan yang tidak terdaftar pada tim $id
        $penggunas = Cache::remember('invite_internal', 120, function () use ($id) {
            return Pengguna::with('participantRef')->doesntHave('timParticipantRef', 'or', function ($query) use ($id) {
                $query->where('tim_event_id', $id);
            })->whereDoesntHave('timMhsRef', function ($query) use ($id) {
                $query->where('tim_event_id', $id);
            })->get();
        });


        // Filter hanya untuk maahasiswa dan participant
        $invites = collect();
        foreach ($penggunas as $item) {
            if ($item->is_mahasiswa == 1 || $item->is_participant == 1) {
                $invites->push($item);
            }
        }

        // get name mahasiswa from api
        foreach ($invites as $item2) {
            $item2->mahasiswaRef = null;
            if ($item2->nim) {
                try {
                    // Get nama mahasiswa
                    $item2->mahasiswaRef = $this->api_mahasiswa->getMahasiswaSomeField($item2->nim);
                } catch (\Throwable $err) {
                }
            }
        }

        return response()->json($invites);
    }


    public function invitePengguna(Request $request, $id_tim)
    {
        $pengguna = Pengguna::with('participantRef')->find($request->id_pengguna);
        $nama_mhs = null;


        if ($request->type == "internal") {
            $event = EventInternal::find($request->id_event);
        } else {
            $event = EventEksternal::find($request->id_event);
        }

        // insert to temporary team detail
        $ted = new TimEventDetail();
        $ted->tim_event_id = $id_tim;
        if ($pengguna->is_mahasiswa) {
            $nama = $this->api_mahasiswa->getMahasiswaSomeField($pengguna->nim)->mahasiswa_nama;
            $ted->nim = $pengguna->nim;
        } else {
            $ted->participant_id = $pengguna->participant_id;
            $nama = $pengguna->participantRef->nama_participant;
        }
        $ted->role = "anggota";
        $ted->status = "Pending";
        $ted->save();

        Mail::to($pengguna->email)->send(new invitationTeamMail($nama, $event->nama_event, $ted->id_tim_event_detail));
        if ($ted) {
            return redirect()->back()->with('success', 'Berhasil mengundang');
        }
    }
}
