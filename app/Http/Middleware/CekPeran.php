<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekPeran
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$peranSlugs
     */
    public function handle(Request $request, Closure $next, string ...$peranSlugs): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Jika tidak ada peran spesifik yang dicek, loloskan
        if (empty($peranSlugs)) {
            return $next($request);
        }

        $userPeranSlug = $user->peran?->slug;

        // Superadmin / admin selalu lolos
        if ($userPeranSlug === 'superadmin' || $userPeranSlug === 'admin') {
            return $next($request);
        }

        if (in_array($userPeranSlug, $peranSlugs, true)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Akun Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
