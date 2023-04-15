<?php

namespace App\BID\Services;

use App\BID\Contracts\Compaign;
use Closure;

class YandexCompaign extends Service implements Compaign
{

    private array $compaigns;

    public function __construct(array $compaigns)
    {
        $this->compaigns = $compaigns;
    }

    public function piplineHandler($request, Closure $next)
    {
        $request = $this->makeColumnByIndex($this->compaigns, 'Campaigns', 'Id');
        return $next($request);
    }
}
