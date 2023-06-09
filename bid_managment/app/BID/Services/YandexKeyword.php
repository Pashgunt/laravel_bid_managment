<?php

namespace App\BID\Services;

use App\BID\Contracts\Keyword;
use Closure;

class YandexKeyword extends Service implements Keyword
{
    private array $keywords;

    public function __construct(array $keywords)
    {
        $this->keywords = $keywords;
    }

    public function piplineHandler($request, Closure $next)
    {
        $prepareKeywords = $this->makeGroupDataByColumn($this->keywords, 'Keywords', 'AdGroupId');
        foreach ($prepareKeywords as $adGropID => $keywords) {
            $compaignID = current($keywords)['CampaignId'];
            $prepareKeywordData = $this->makeColumnByIndex(data: $keywords, model: '', column: 'Id');
            $request['result'][$compaignID]['adGroups'][$adGropID]['keywords'] = $prepareKeywordData;
        }
        $request['keywordIDs'] = array_column(current($this->keywords)['Keywords'], 'Id');
        return $next($request);
    }
}
