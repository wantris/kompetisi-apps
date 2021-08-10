<?php

namespace App\Http\Controllers\landing;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class blogController extends Controller
{
    public function index()
    {
        $blogs = Blog::paginate(10);
        $recents = Blog::latest()->take(5)->get();
        return view('landing.blog.index', compact('blogs', 'recents'));
    }

    public function detail($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if ($blog) {
            return view('landing.blog.detail', compact('slug', 'blog'));
        }
    }
}
