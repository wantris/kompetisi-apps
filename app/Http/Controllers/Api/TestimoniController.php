<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Testimoni;
use File;

class TestimoniController extends Controller
{
    public function index()
    {
        try {
            $testimonis = Testimoni::all();
            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $testimonis
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 500,
                "message" => "Get data error",
                "data" => null
            ]);
        }
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        try {
            $name_testimoni = null;

            if ($request->file('photo')) {
                $resorce_testimoni = $request->file('photo');
                $name_testimoni   = "testimoni_" . rand(0000, 9999) . "." . $resorce_testimoni->getClientOriginalExtension();
                $resorce_testimoni->move(\base_path() . "/public/assets/img/testimonial/", $name_testimoni);
            }

            $testimoni = new Testimoni();
            $testimoni->name = $request->name;
            $testimoni->description = $request->description;
            $testimoni->role = $request->role;
            $testimoni->photo = $name_testimoni;

            $testimoni->save();

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Testimoni berhasil disimpan",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 500,
                "message" => "Something's error",
                "data" => $err
            ]);
        }
    }

    public function update(Request $request, $id_testimoni)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        try {
            $name_testimoni = $request->oldPhoto;

            if ($request->file('photo')) {
                $resorce_testimoni = $request->file('photo');
                $name_testimoni   = "testimoni_" . rand(0000, 9999) . "." . $resorce_testimoni->getClientOriginalExtension();
                $resorce_testimoni->move(\base_path() . "/public/assets/img/testimonial/", $name_testimoni);
            }

            $testimoni = Testimoni::find($id_testimoni);
            $testimoni->name = $request->name;
            $testimoni->description = $request->description;
            $testimoni->role = $request->role;
            $testimoni->photo = $name_testimoni;

            $testimoni->save();

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Testimoni berhasil disimpan",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 500,
                "message" => "Something's error",
                "data" => $err
            ]);
        }
    }

    public function delete($id_testimoni)
    {
        $testimoni = Testimoni::find($id_testimoni);
        if ($testimoni) {
            if (File::exists(public_path('assets/img/testimoni/' . $testimoni->image_name))) {
                File::delete(public_path('assets/img/testimoni/' . $testimoni->image_name));
            }

            Testimoni::destroy($id_testimoni);

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "testimoni berhasil dihapus",
            ]);
        }

        return response()->json([
            "success" => false,
            'status' => 404,
            "message" => "testimoni tidak ada",
        ]);
    }
}
