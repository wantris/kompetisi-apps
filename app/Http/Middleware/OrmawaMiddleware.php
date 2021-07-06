<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class OrmawaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::get('is_ormawa') != "1") {
            /* 
            silahkan modifikasi pada bagian ini
            apa yang ingin kamu lakukan jika rolenya tidak sesuai
            */
            return redirect()->route('project.index')->with('failed', 'Anda harus login');
        }
        return $next($request);
    }
}
