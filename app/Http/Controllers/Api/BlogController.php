<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use File;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $blogs = Blog::all();
            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $blogs
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
            'konten' => 'required',
            'status' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        try {
            $name_blog = null;

            if ($request->file('image')) {
                $resorce_blog = $request->file('image');
                $name_blog   = "blog_" . rand(0000, 9999) . "." . $resorce_blog->getClientOriginalExtension();
                $resorce_blog->move(\base_path() . "/public/assets/img/blog/", $name_blog);
            }

            $blog = new Blog();
            $blog->title = $request->title;
            $blog->slug =  Str::slug($request->title);
            $blog->konten = $request->konten;
            $blog->image_name = $name_blog;
            $blog->status = $request->status;
            $blog->save();

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Blog berhasil disimpan",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 500,
                "message" => "Something's error",
                "data" => null
            ]);
        }
    }

    public function search()
    {
        try {
            $blog = Blog::where('slug', request()->slug)->orWhere('id_blog', request()->id)->first();
            if ($blog) {
                return response()->json([
                    'status' => 200,
                    'message' => "Get data success!",
                    'data' => $blog
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => "Data not found!",
                'data' => null
            ], 404);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 500,
                "message" => "Get data error",
                "data" => null
            ]);
        }
    }

    public function update(Request $request, $id_blog)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'konten' => 'required',
            'status' => 'required',
            'old_image' => 'required',
        ]);

        if ($validator->fails()) {
            $failed = array(
                'success' => false,
                'messages' => $validator->errors(),
            );
            return response()->json($failed, 401);
        }

        try {

            $blog = Blog::find($id_blog);

            $name_blog = $request->old_image;

            if ($request->file('image')) {
                $resorce_blog = $request->file('image');
                $name_blog   = "blog_" . rand(0000, 9999) . "." . $resorce_blog->getClientOriginalExtension();
                $resorce_blog->move(\base_path() . "/public/assets/img/blog/", $name_blog);

                if (File::exists(public_path('assets/img/blog/' . $blog->image_name))) {
                    File::delete(public_path('assets/img/blog/' . $blog->image_name));
                }
            }


            $blog->title = $request->title;
            $blog->slug =  Str::slug($request->title);
            $blog->konten = $request->konten;
            $blog->image_name = $name_blog;
            $blog->status = $request->status;
            $blog->save();

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Blog berhasil diupdate",
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                "status" => 500,
                "message" => "Something's error",
                "data" => null
            ]);
        }
    }

    public function delete($id_blog)
    {
        $blog = Blog::find($id_blog);
        if ($blog) {
            if (File::exists(public_path('assets/img/blog/' . $blog->image_name))) {
                File::delete(public_path('assets/img/blog/' . $blog->image_name));
            }

            Blog::destroy($id_blog);

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "Blog berhasil dihapus",
            ]);
        }

        return response()->json([
            "success" => false,
            'status' => 404,
            "message" => "Blog tidak ada",
        ]);
    }
}
