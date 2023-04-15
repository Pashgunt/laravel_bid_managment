<?php

namespace App\BID\Services;

use App\BID\Contracts\Directs;
use App\Models\DirectToken;
use App\BID\Enums\FileldNamesYandexDirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class YandexDirect extends Service implements Directs
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

    public function getCompaigns(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::COMPAIGN_FIELD_NAMES): array
    {
        $params = [
            'SelectionCriteria' => (object) $selectionCriteria,
            'FieldNames' => $fieldNames
        ];
        $response = $this->prepareHttpQuery($accessToken, 'campaigns', $params);
        if ($response->ok()) {
            return $response->json();
        }
        return [];
    }

    public function getAdGroups(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::AD_GROUP_FIELD_NAMES)
    {
        $params = [
            'SelectionCriteria' => (object) $selectionCriteria,
            'FieldNames' => $fieldNames
        ];
        $response = $this->prepareHttpQuery($accessToken, 'adgroups', $params);
        if ($response->ok()) {
            return $response->json();
        }
        return [];
    }

    public function getKeywords(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::KEYWORD_FIELD_NAMES)
    {
        $params = [
            'SelectionCriteria' => (object) $selectionCriteria,
            'FieldNames' => $fieldNames
        ];
        $response = $this->prepareHttpQuery($accessToken, 'keywords', $params);
        if ($response->ok()) {
            return $response->json();
        }
        return [];
    }

    public function getKeywordBids(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::KEYWORD_BID_FIELD_NAMES)
    {
        $params = [
            'SelectionCriteria' => (object) $selectionCriteria,
            'FieldNames' => $fieldNames,
            'SearchFieldNames' => ['AuctionBids', 'Bid'],
            "NetworkFieldNames" => ["Bid", "Coverage"],
        ];
        $response = $this->prepareHttpQuery($accessToken, 'keywordbids', $params);
        if ($response->ok()) {
            return $response->json();
        }
        return [];
    }

    public function getBids(string $accessToken, array $selectionCriteria = [], array $fieldNames = FileldNamesYandexDirect::BID_FIELD_NAMES)
    {
    }
}
