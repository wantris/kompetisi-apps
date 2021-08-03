<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Participant;
use App\Pengguna;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ParticipantController extends Controller
{
    public function index()
    {
        try {
            $participants = $this->getAllData();

            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $participants
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 500,
                'message' => "Get data failed!",
                'data' => null
            ], 500);
        }
    }

    public function save(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama_participant' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        $participant = new Participant();
        $participant->nama_participant = $req->nama_participant;
        $participant->save();

        if ($participant) {
            $pengguna = new Pengguna();
            $pengguna->username = $req->username;
            $pengguna->password = Hash::make($req->password);
            $pengguna->is_mahasiswa = 0;
            $pengguna->is_wadir3 = 0;
            $pengguna->is_pembina = 0;
            $pengguna->is_participant = 1;
            $pengguna->is_dosen = 0;
            $pengguna->participant_id = $participant->id_participant;
            $pengguna->save();

            return response()->json([
                'status' => 200,
                'message' => "Save data success!",
                'data' => $participant
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Save data failed!",
                'data' => null
            ], 500);
        }
    }

    public function detail($id_participant)
    {
        $participant = Participant::with('penggunaRef')->find($id_participant);

        if ($participant) {
            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $participant
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => "Get data failed!",
            'data' => null
        ], 404);
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

                if ($req->new_password != null) {
                    $password = Hash::make($req->new_password);
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



    public function getAllData()
    {
        $participants = Participant::with('penggunaRef')->get();

        return $participants;
    }
}
