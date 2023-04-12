<?php

namespace App\Providers;

use App\BID\Contracts\ActiveAccount;
use App\BID\Contracts\AdGroup;
use App\BID\Contracts\Compaign;
use App\BID\Contracts\Directs;
use App\BID\Contracts\Keyword;
use App\BID\Services\ActiveAccount as ServiceActiveAccount;
use App\BID\Services\YandexAdGroup;
use App\BID\Services\YandexCompaign;
use App\BID\Services\YandexDirect;
use App\BID\Services\YandexKeyword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(Directs::class, function () {
            return new YandexDirect();
        });
        $this->app->bind(ActiveAccount::class, function () {
            return new ServiceActiveAccount();
        });
        $this->app->bind(Compaign::class, function () {
            return new YandexCompaign();
        });
        $this->app->bind(AdGroup::class, function () {
            return new YandexAdGroup();
        });
        $this->app->bind(Keyword::class, function () {
            return new YandexKeyword();
        });
    }

    public function boot(): void
    {
    }
}
