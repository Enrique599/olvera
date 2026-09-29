<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        App::setLocale('es');
        Carbon::setLocale('es');

        config(['app.timezone' => 'America/Mexico_City']);
        date_default_timezone_set('America/Mexico_City');

        $hora = now()->hour;
        View::share('saludo', match (true) {
            $hora < 12 => '☀️ ¡Buenos días!',
            $hora < 19 => '🌤️ ¡Buenas tardes!',
            default    => '🌙 ¡Buenas noches!',
        });
    }
}
