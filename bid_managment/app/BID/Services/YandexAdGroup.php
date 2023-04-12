<?php

namespace App\BID\Services;

use App\BID\Contracts\AdGroup;

class YandexAdGroup implements AdGroup
{
    public function prepareAdGroupIDs(array $adGroups = [])
    {
        if ($adGroups) {
            return array_column(current($adGroups), 'Id');
        }
        return [];
    }
}
