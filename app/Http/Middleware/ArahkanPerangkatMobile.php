<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArahkanPerangkatMobile
{
    /**
     * Alihkan pengunjung dari perangkat mobile ke rute versi mobile.
     */
    public function handle(Request $request, Closure $next, string $tujuan): Response
    {
        if ($this->perangkatMobile($request)) {
            return redirect()->route($tujuan);
        }

        return $next($request);
    }

    private function perangkatMobile(Request $request): bool
    {
        $agen = (string) $request->userAgent();

        if ($agen === '') {
            return false;
        }

        return preg_match(
            '/(android|iphone|ipod|ipad|iemobile|opera mini|mobile|blackberry|windows phone|webos)/i',
            $agen
        ) === 1;
    }
}
