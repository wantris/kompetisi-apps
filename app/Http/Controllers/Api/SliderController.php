<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
use App\Slider;

class SliderController extends Controller
{
    public function index()
    {
        try {
            $sliders = Slider::all();
            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $sliders
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
            'title' => 'required',
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        try {
            $name_slider = null;

            if ($request->file('image')) {
                $resorce_slider = $request->file('image');
                $name_slider   = "slider_" . rand(0000, 9999) . "." . $resorce_slider->getClientOriginalExtension();
                $resorce_slider->move(\base_path() . "/public/assets/img/slider/", $name_slider);
            }

            $slider = new Slider();
            $slider->title = $request->title;
            $slider->deskripsi = $request->deskripsi;
            $slider->image_name = $name_slider;
            $slider->is_active = $request->is_active;
            $slider->save();

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Slider berhasil disimpan",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 500,
                "message" => "Something's error",
                "data" => null
            ]);
        }
    }

    public function update(Request $request, $id_slider)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'is_active' => 'required'
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        try {


            $slider = Slider::find($id_slider);


            if ($slider) {
                $name_slider = $request->oldImage;

                if ($request->file('image')) {
                    $resorce_slider = $request->file('image');
                    $name_slider   = "slider_" . rand(0000, 9999) . "." . $resorce_slider->getClientOriginalExtension();
                    $resorce_slider->move(\base_path() . "/public/assets/img/slider/", $name_slider);

                    if (File::exists(public_path('assets/img/slider/' . $slider->image_name))) {
                        File::delete(public_path('assets/img/slider/' . $slider->image_name));
                    }
                }

                $slider->title = $request->title;
                $slider->deskripsi = $request->deskripsi;
                $slider->image_name = $name_slider;
                $slider->is_active = $request->is_active;
                $slider->save();

                return response()->json([
                    "success" => true,
                    'status' => 200,
                    "message" => "Slider berhasil diupdate",
                ]);
            }
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 500,
                "message" => "Something's error",
                "data" => null
            ]);
        }
    }

    public function delete($id_slider)
    {
        $slider = Slider::find($id_slider);
        if ($slider) {
            if (File::exists(public_path('assets/img/slider/' . $slider->image_name))) {
                File::delete(public_path('assets/img/slider/' . $slider->image_name));
            }

            Slider::destroy($id_slider);

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Slider berhasil dihapus",
            ]);
        }

        return response()->json([
            "success" => false,
            'status' => 404,
            "message" => "Slider tidak ada",
        ]);
    }
}
