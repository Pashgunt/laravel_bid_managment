<?php

namespace App\BID\Services;

use App\BID\Contracts\KeywordBid;
use Closure;

class YandexKeywordBid extends Service implements KeywordBid
{
    private array $keywordBids;

    public function __construct(array $keywordBids)
    {
        $this->keywordBids = $keywordBids;
    }

    public function piplineHandler($request, Closure $next)
    {
        $prepareKeywordBids = $this->makeGroupDataByColumn($this->keywordBids, 'KeywordBids', 'KeywordId');
        foreach ($prepareKeywordBids as $keywordId => $keywordBids) {
            $compaignID = current($keywordBids)['CampaignId'];
            $adGroupID = current($keywordBids)['AdGroupId'];
            $request['result'][$compaignID]['adGroups'][$adGroupID]['keywords'][$keywordId]['keywordBid'] = $keywordBids;
        }
        return $next($request);
    }
}
