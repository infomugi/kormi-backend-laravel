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

        // Jika akun dinonaktifkan
        if (isset($user->status_aktif) && !$user->status_aktif) {
            \Illuminate\Support\Facades\Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda sedang dinonaktifkan atau belum disetujui.']);
        }

        // Jika tidak ada peran/izin spesifik yang dicek, loloskan
        if (empty($peranSlugs)) {
            return $next($request);
        }

        $userPeranSlug = $user->peran?->slug;

        // Super Administrator selalu memiliki akses penuh ke seluruh modul
        if ($userPeranSlug === 'super-admin' || $userPeranSlug === 'superadmin' || $userPeranSlug === 'admin') {
            return $next($request);
        }

        // Flatten jika ada format "admin-korcam,admin-inorga" atau "admin-korcam|admin-inorga"
        $allowed = [];
        foreach ($peranSlugs as $slugItem) {
            $parts = preg_split('/[,|]/', $slugItem);
            foreach ($parts as $p) {
                $allowed[] = trim($p);
            }
        }

        // 1. Cek langsung via kecocokan slug role
        if (in_array($userPeranSlug, $allowed, true)) {
            return $next($request);
        }

        // 2. Cek dinamis via izin modul (hak_akses array pada Peran)
        if ($user->peran) {
            foreach ($allowed as $item) {
                if ($user->peran->punyaAkses($item)) {
                    return $next($request);
                }
            }
        }

        abort(403, 'Akses ditolak. Peran akun Anda (' . ($user->peran?->nama_peran ?? 'Pengguna') . ') tidak memiliki izin untuk mengakses modul ini.');
    }
}
