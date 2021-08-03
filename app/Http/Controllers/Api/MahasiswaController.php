<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\endpoint\ApiMahasiswaController;
use App\Pengguna;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Throwable;

class MahasiswaController extends Controller
{
    protected $api_mahasiswa;

    public function __construct()
    {
        $this->api_mahasiswa = new ApiMahasiswaController;
    }

    public function index()
    {

        $mahasiswas = $this->getAllData();


        if ($mahasiswas->count() > 0) {
            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $mahasiswas
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => "Data not found!",
            'data' => $mahasiswas
        ], 404);
    }
    public function edit($nim)
    {
        try {
            $ps = Pengguna::where('nim', $nim)->first();
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

    public function update(Request $req, $nim)
    {
        $namePhoto = $req->oldPhoto;
        $password = $req->oldPassword;

        if ($req->newPassword != null) {
            $password = Hash::make($req->newPassword);
        };

        if ($req->file('photo')) {
            $resorcePhoto = $req->file('photo');
            $namePhoto   = "photo_" . rand(0000, 9999) . "." . $resorcePhoto->getClientOriginalExtension();
            $resorcePhoto->move(\base_path() . "/public/assets/img/photo-pengguna/", $namePhoto);
        }

        try {

            $ps = Pengguna::where('nim', $nim)->first();
            $ps->username = $req->username;
            $ps->password = $password;
            $ps->email = $req->email;
            $ps->phone = $req->phone;
            $ps->alamat = $req->alamat;
            $ps->photo = $namePhoto;
            $ps->save();

            return response()->json([
                "success" => true,
                "status" => 200,
                "message" => 'berhasil',
            ]);
        } catch (Throwable $err) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "message" => $namePhoto,
            ]);
        }
    }

    public function getAllData()
    {
        $api_mahasiswa = $this->api_mahasiswa;

        $mahasiswas = Pengguna::where('is_mahasiswa', 1)->get();

        if ($mahasiswas->count() > 0) {
            $mahasiswas->each(function ($item, $key) use ($api_mahasiswa) {
                $item->mahasiswaRef = null;
                $mhs = $api_mahasiswa->getMahasiswaSomeField($item->nim);
                if ($mhs) {
                    $item->mahasiswaRef = $mhs;
                }
            });
        }

        return $mahasiswas;
    }
}
