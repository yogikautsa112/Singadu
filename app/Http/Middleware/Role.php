<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */    public function handle(Request $request, Closure $next, $roles)
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role === $roles) {
                return $next($request);
            }

            // Menangani pengalihan berdasarkan role pengguna
            // Menangani pengalihan berdasarkan role pengguna
            $redirects = [
                'staff' => route('staff.dashboard'),
                'head_staff' => route('head-staff.dashboard'),
                'guest' => route('reports.index'),
            ];


            // Jika ada pengalihan untuk role tersebut, lakukan redirect
            if (array_key_exists($user->role, $redirects)) {
                return redirect($redirects[$user->role]);
            }
        }

        // Jika pengguna tidak memiliki akses atau belum login
        return redirect('/')->with('error', 'Akses ditolak.');
    }
}
