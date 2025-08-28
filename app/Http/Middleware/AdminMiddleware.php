<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user sudah login DAN rolenya adalah 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        // Jika tidak, kembalikan ke halaman utama dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
