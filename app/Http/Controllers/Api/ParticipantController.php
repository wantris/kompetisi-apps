<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Participant;
use App\Pengguna;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::with('penggunaRef')->get();

        return response()->json($participants);
    }

    public function edit($id_participant)
    {
        try {
            $ps = Participant::with('penggunaRef')->where('id_participant', $id_participant)->first();
            if (!$ps) {
                return response()->json([
                    "success" => false,
                    "status" => 404,
                    "message" => "Data Participant Tidak ada",
                ]);
            }

            return response()->json($ps);
        } catch (Throwable $err) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "message" => $err,
            ]);
        }
    }

    public function update(Request $req, $id_participant)
    {
        try {
            $ps = Participant::where('id_participant', $id_participant)->first();
            $password = $req->oldPassword;
            $namePhoto = null;

            if ($ps) {
                $ps->nama_participant = $req->nama;
                $ps->save();

                if ($req->newPassword != null) {
                    $password = Hash::make($req->newPassword);
                };

                if ($req->file('photo')) {
                    $resorcePhoto = $req->file('photo');
                    $namePhoto   = "photo_" . rand(0000, 9999) . "." . $resorcePhoto->getClientOriginalExtension();
                    $resorcePhoto->move(\base_path() . "/public/assets/img/photo-pengguna/", $namePhoto);
                }

                Pengguna::where('participant_id', $id_participant)->update([
                    'username' => $req->username,
                    'password' => $password,
                    'email' => $req->email,
                    'phone' => $req->phone,
                    'alamat' => $req->alamat,
                    'photo' => $namePhoto
                ]);

                return response()->json([
                    "success" => true,
                    "status" => 200,
                    "message" => 'berhasil',
                ]);
            }
        } catch (Throwable $err) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "message" => $err,
            ]);
        }
    }
}
