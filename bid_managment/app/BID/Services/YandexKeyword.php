<?php

namespace App\BID\Services;

use App\BID\Contracts\Keyword;

class YandexKeyword implements Keyword
{
    public function prepareKeywordIDs(array $keywords = [])
    {
        if ($keywords) {
            return array_column(current($keywords), 'Id');
        }
        return [];
    }
}
