<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Pengguna;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $penggunas = Pengguna::with('pembinaRef', 'participantRef', 'wadir3Ref')->get();

        if ($penggunas->count() > 0) {
            return response()->json($penggunas, 200);
        }

        return response()->json([
            "success" => false,
            "status" => 404,
            "message" => "Data pengguna Tidak ada",
        ], 404);
    }

    public function detail($id_pengguna)
    {
        $pengguna = Pengguna::with('wadir3Ref', 'pembinaRef', 'participantRef')->where('id_pengguna', $id_pengguna)->first();
        $pengguna->mahasiswa_ref = null;
        $pengguna->dosen_ref = null;


        if ($pengguna) {
            // Jika ada pembina
            if ($pengguna->pembinaRef && !$pengguna->nim) {
                try {
                    $client = new Client();
                    $url = env('SOURCE_API') . "dosen/" . $pengguna->pembinaRef->nidn;
                    $response = $client->request('GET', $url, [
                        'verify'  => false,
                    ]);
                    $dosen = json_decode($response->getBody());
                    $pengguna->pembinaRef->nama_dosen = $dosen->nama_dosen;
                } catch (\Throwable $err) {
                    return response()->json([
                        "success" => false,
                        "status" => 404,
                        "message" => $err,
                    ], 404);
                }
            } else if ($pengguna->wadir3Ref && !$pengguna->nim) {
                try {
                    $client = new Client();
                    $url = env('SOURCE_API') . "dosen/" . $pengguna->wadir3Ref->nidn;
                    $response = $client->request('GET', $url, [
                        'verify'  => false,
                    ]);
                    $dosen = json_decode($response->getBody());
                    $pengguna->wadir3Ref->nama_dosen = $dosen->nama_dosen;
                } catch (\Throwable $err) {
                    return response()->json([
                        "success" => false,
                        "status" => 404,
                        "message" => $err,
                    ], 404);
                }
            } else if ($pengguna->nim) {
                try {
                    $client = new Client();
                    $urlM = env('SOURCE_API') . "mahasiswa/detail/" . $pengguna->nim;
                    $responseM = $client->request('GET', $urlM, [
                        'verify'  => false,
                    ]);
                    $mhs = json_decode($responseM->getBody());
                    $pengguna->mahasiswa_ref = $mhs->nama;
                } catch (\Throwable $err) {
                    return response()->json([
                        "success" => false,
                        "status" => 404,
                        "message" => $err,
                    ], 404);
                }
            } else if ($pengguna->nidn) {
                try {
                    $client = new Client();
                    $url = env('SOURCE_API') . "dosen/" . $pengguna->nidn;
                    $response = $client->request('GET', $url, [
                        'verify'  => false,
                    ]);
                    $dosen = json_decode($response->getBody());
                    $pengguna->dosen_ref = $dosen->nama_dosen;
                } catch (\GuzzleHttp\Exception\RequestException $err) {
                    return response()->json([
                        "success" => false,
                        "status" => 404,
                        "message" => $err,
                    ], 404);
                }
            }



            return response()->json($pengguna, 200);
        }

        return response()->json([
            "success" => false,
            "status" => 404,
            "message" => "Data pengguna Tidak ada",
        ], 404);
    }

    public function update(Request $req, $id_pengguna)
    {
        $validator = Validator::make($req->all(), [
            'username' => 'required',
            'oldPassword' => 'required',
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        try {
            $ps = Pengguna::where('id_pengguna', $id_pengguna)->first();
            $password = $req->oldPassword;
            $namePhoto = null;

            if ($ps) {

                if ($req->newPassword != null) {
                    $password = Hash::make($req->newPassword);
                };

                if ($req->file('photo')) {
                    $resorcePhoto = $req->file('photo');
                    $namePhoto   = "photo_" . rand(0000, 9999) . "." . $resorcePhoto->getClientOriginalExtension();
                    $resorcePhoto->move(\base_path() . "/public/assets/img/photo-pengguna/", $namePhoto);
                }

                Pengguna::where('id_pengguna', $id_pengguna)->update([
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
                ], 200);
            }
        } catch (\Throwable $err) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "message" => $err,
            ], 500);
        }
    }
}
