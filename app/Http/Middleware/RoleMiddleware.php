<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses sistem.');
        }

        $user = auth()->user();

        // Check if user has one of the allowed roles
        if (! in_array($user->role, $roles)) {
            // Optional friendly redirect to user's home dashboard
            $targetRoute = match ($user->role) {
                'admin' => 'admin.dashboard',
                'kepala_sekolah' => 'kepsek.dashboard',
                'pemohon' => 'pemohon.dashboard',
                default => 'login',
            };

            return redirect()->route($targetRoute)->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses rute tersebut.');
        }

        return $next($request);
    }
}
