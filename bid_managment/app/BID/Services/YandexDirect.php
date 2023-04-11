<?php

namespace App\BID\Services;

use App\BID\Contracts\Directs;
use App\Models\DirectToken;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

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

    public function getCompaigns(string $accessToken, array $selectionCriteria = [], array $fieldNames = ['Id', 'Name']): array
    {
        $response = Http::withHeaders([
            'Client-Login' => '',
            'Accept-Language' => 'ru',
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withToken($accessToken)
            ->post('https://api-sandbox.direct.yandex.com/json/v5/campaigns', [
                'method' => 'get',
                'params' => [
                    'SelectionCriteria' => (object) $selectionCriteria,
                    'FieldNames' => $fieldNames
                ]
            ]);

        if ($response->ok()) {
            return $response->json();
        }
        return [];
    }

    public function getAdGroups(string $accessToken, array $selectionCriteria = [], array $fieldNames = ["CampaignId", "Id", "Name"]){
        $response = Http::withHeaders([
            'Client-Login' => '',
            'Accept-Language' => 'ru',
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withToken($accessToken)
            ->post('https://api-sandbox.direct.yandex.com/json/v5/adgroups', [
                'method' => 'get',
                'params' => [
                    'SelectionCriteria' => (object) $selectionCriteria,
                    'FieldNames' => $fieldNames
                ]
            ]);

        if ($response->ok()) {
            return $response->json();
        }
        return [];
    }
}
