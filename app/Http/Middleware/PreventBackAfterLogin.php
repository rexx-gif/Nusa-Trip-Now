<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventBackAfterLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is authenticated and trying to access login/register pages
        if (Auth::check() && ($request->is('login') || $request->is('register'))) {
            // Check if they have a login timestamp (meaning they logged in recently)
            if (session('login_timestamp')) {
                // Redirect to appropriate dashboard based on user role
                if (Auth::user()->hasRole('admin')) {
                    return redirect('/admin/dashboard');
                }
                return redirect('/tours');
            }
        }

        // Set cache control headers to prevent back navigation
        if (Auth::check()) {
            $response = $next($request);
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            return $response;
        }

        return $next($request);
    }
}
