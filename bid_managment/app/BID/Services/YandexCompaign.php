<?php

namespace App\BID\Services;

use App\BID\Contracts\Compaign;

class YandexCompaign implements Compaign
{
    public function prepareCompaignIDs(array $compaigns = [])
    {
        if ($compaigns) {
            return array_column(current($compaigns), 'Id');
        }
        return [];
    }
}
