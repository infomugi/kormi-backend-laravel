<?php

namespace App\Http\Middleware;

use App\Models\Core\Pengguna;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CatatAktivitasPengguna
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user instanceof Pengguna) {
            $sekarang = now();

            if ($user->terakhir_aktif === null || $user->terakhir_aktif->lt($sekarang->copy()->subMinute())) {
                Pengguna::query()->whereKey($user->getKey())->update(['terakhir_aktif' => $sekarang]);

                $user->setAttribute('terakhir_aktif', $sekarang);
                $user->syncOriginalAttribute('terakhir_aktif');
            }
        }

        return $next($request);
    }
}
