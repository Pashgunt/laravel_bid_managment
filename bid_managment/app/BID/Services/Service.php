<?php

namespace App\BID\Services;

use Illuminate\Support\Facades\Http;
use App\BID\Enums\Settings;

class Service
{
    protected function prepareHttpQuery(
        string $accessToken,
        string $method,
        array $params
    ) {
        return Http::withHeaders([
            'Client-Login' => '',
            'Accept-Language' => 'ru',
            'Content-Type' => 'application/json; charset=utf-8'
        ])
            ->withToken($accessToken)
            ->post(Settings::YANDEX_DIRECT_JSON_URL . $method, [
                'method' => 'get',
                'params' => $params
            ]);
    }

    // TODO make adapt to universal method without model
    protected function makeColumnByIndex(array $data, string $model, string $column)
    {
        return array_combine(array_column(current($data)[$model], $column), current($data)[$model]);
    }

    protected function makeGroupDataByColumn(array $data, string $model, string $column)
    {
        $result = [];
        foreach (current($data)[$model] as $group) {
            $result[$group[$column]]   = $result[$group[$column]] ?? [];
            $result[$group[$column]][] = $group;
        }
        return $result;
    }
}
