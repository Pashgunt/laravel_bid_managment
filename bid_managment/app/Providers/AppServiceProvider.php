<?php

namespace App\Providers;

use App\BID\Contracts\Directs;
use App\BID\Services\YandexDirect;
use App\Http\Controllers\RecoveryController;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(Directs::class, function () {
            return new YandexDirect();
        });
    }

    public function boot(): void
    {
    }
}
