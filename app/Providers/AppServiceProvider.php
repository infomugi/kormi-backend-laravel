<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS URL scheme when behind SSL reverse proxy (Coolify / Traefik / Docker / Production)
        if (app()->environment('production') || request()->header('X-Forwarded-Proto') === 'https' || str_starts_with(config('app.url', ''), 'https://')) {
            URL::forceScheme('https');
        }

        $observer = \App\Observers\AktivitasObserver::class;
        
        \App\Models\Berita::observe($observer);
        \App\Models\Inorga::observe($observer);
        \App\Models\Event::observe($observer);
        \App\Models\EventCabang::observe($observer);
        \App\Models\EventJadwal::observe($observer);
        \App\Models\Sapras::observe($observer);
        \App\Models\GaleriAlbum::observe($observer);
        \App\Models\GaleriFoto::observe($observer);
        \App\Models\Unduhan::observe($observer);
        \App\Models\Pengguna::observe($observer);
        \App\Models\DutaOlahraga::observe($observer);
        \App\Models\ProgramKerja::observe($observer);
        \App\Models\PengurusModel::observe($observer);
        \App\Models\KordikPengurus::observe($observer);
        \App\Models\PengaturanSitus::observe($observer);
    }
}
