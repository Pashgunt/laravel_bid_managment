<?php

namespace App\BID\Services;

use App\BID\Contracts\Directs;
use App\Models\DirectToken;
use App\BID\Enums\FileldNamesYandexDirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class YandexDirect implements Directs
{
    // TODO create parent class generate for all Services
    // TODO make prepapre HTTP request in parent class 
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

    public function getCompaigns(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::COMPAIGN_FIELD_NAMES): array
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

    public function getAdGroups(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::AD_GROUP_FIELD_NAMES)
    {
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

    public function getKeywords(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::KEYWORD_FIELD_NAMES)
    {
        $response = Http::withHeaders([
            'Client-Login' => '',
            'Accept-Language' => 'ru',
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withToken($accessToken)
            ->post('https://api-sandbox.direct.yandex.com/json/v5/keywords', [
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

    public function getKeywordBids(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::KEYWORD_BID_FIELD_NAMES)
    {
        $response = Http::withHeaders([
            'Client-Login' => '',
            'Accept-Language' => 'ru',
            'Content-Type' => 'application/json; charset=utf-8'
        ])->withToken($accessToken)
            ->post('https://api-sandbox.direct.yandex.com/json/v5/keywordbids', [
                'method' => 'get',
                'params' => [
                    'SelectionCriteria' => (object) $selectionCriteria,
                    'FieldNames' => $fieldNames,
                    'SearchFieldNames' => ['AuctionBids', 'Bid'],
                    "NetworkFieldNames" => ["Bid", "Coverage"],
                ]
            ]);

        if ($response->ok()) {
            return $response->json();
        }
        return [];
    }

    public function getBids(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::BID_FIELD_NAMES)
    {
    }
}
