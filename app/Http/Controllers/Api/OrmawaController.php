<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Ormawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\File;

class OrmawaController extends Controller
{
    public function index()
    {
        $ormawas = Ormawa::all();

        return response()->json([
            'status' => 200,
            'message' => "Data Ormawa tersedia",
            'data' => $ormawas
        ], 200);
    }


    public function detail($id_ormawa)
    {
        $ormawa = Ormawa::find($id_ormawa);

        if ($ormawa) {
            return response()->json(
                [
                    'status' => 200,
                    'message' => "Data Ormawa tersedia",
                    'data' => $ormawa
                ],
                200
            );
        }

        return response()->json([
            "success" => false,
            "message" => "Data ormawa tidak ada",
        ], 404);
    }



    public function update(Request $req, $id_ormawa)
    {
        $validator = Validator::make($req->all(), [
            'nama' => 'required',
            'username' => 'required',
            'oldPassword' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $ormawa = Ormawa::find($id_ormawa);

            if ($req->newPassword == null) {

                $ormawa->nama_ormawa = $req->nama;
                $ormawa->nama_akronim = $req->akronim;
                $ormawa->username = $req->username;
                $ormawa->password = $req->oldPassword;
                $ormawa->email = $req->email;
                $ormawa->website = $req->website;
                $ormawa->deskripsi = $req->deskripsi;
            } else {
                $ormawa->nama_ormawa = $req->nama;
                $ormawa->nama_akronim = $req->akronim;
                $ormawa->username = $req->username;
                $ormawa->password = Hash::make($req->newPassword);
                $ormawa->email = $req->email;
                $ormawa->website = $req->website;
                $ormawa->deskripsi = $req->deskripsi;
            }

            $ormawa->photo = $req->oldPhoto;
            $ormawa->Banner = $req->oldBanner;

            if ($req->file('photo')) {
                $resorcePhoto = $req->file('photo');
                $namePhoto   = "photo_" . rand(0000, 9999) . "." . $resorcePhoto->getClientOriginalExtension();
                $resorcePhoto->move(\base_path() . "/public/assets/img/ormawa-logo/", $namePhoto);
                $ormawa->photo = $namePhoto;
            }
            if ($req->file('banner')) {
                $resorceBanner = $req->file('banner');
                $nameBanner   = "photo_" . rand(0000, 9999) . "." . $resorceBanner->getClientOriginalExtension();
                $resorceBanner->move(\base_path() . "/public/assets/img/banner-ormawa/", $nameBanner);
                $ormawa->Banner = $nameBanner;
            }

            $ormawa->save();

            return response()->json([
                "success" => true,
                "message" => "Ormawa berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "success" => false,
                "message" => $th,
            ]);
        }
    }
}
