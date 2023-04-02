<?php

namespace App\BID\Services;

use App\BID\Contracts\Directs;
use App\Models\DirectToken;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class YandexDirect implements Directs
{
    public function generateDirectCode(Request $request, DirectToken $raw): int
    {
        $clientID = $raw->client_id;
        $clientSecret = $raw->client_secret;

        $exitCode = Artisan::call('app:girect-get-auth', [
            'code' => $request->get('code') ?? 0,
            'client_id' => $clientID,
            'client_secret' => $clientSecret
        ]);

        return $exitCode;
    }
}
