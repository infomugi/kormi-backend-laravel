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
        
        \App\Models\Content\Berita::observe($observer);
        \App\Models\Kormi\Inorga::observe($observer);
        \App\Models\Kormi\Event::observe($observer);
        \App\Models\Kormi\EventCabang::observe($observer);
        \App\Models\Kormi\EventJadwal::observe($observer);
        \App\Models\Kormi\Sapras::observe($observer);
        \App\Models\Content\GaleriAlbum::observe($observer);
        \App\Models\Content\GaleriFoto::observe($observer);
        \App\Models\Content\Unduhan::observe($observer);
        \App\Models\Core\Pengguna::observe($observer);
        \App\Models\Kormi\DutaOlahraga::observe($observer);
        \App\Models\Kormi\ProgramKerja::observe($observer);
        \App\Models\Kormi\PengurusModel::observe($observer);
        \App\Models\Kormi\KordikPengurus::observe($observer);
        \App\Models\Core\PengaturanSitus::observe($observer);
    }
}
