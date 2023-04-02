<?php

namespace App\Providers;

use App\BID\Contracts\Directs;
use App\BID\Services\YandexDirect;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(Directs::class, function ($app) {
            return new YandexDirect();
        });
    }

    public function boot(): void
    {
    }
}
