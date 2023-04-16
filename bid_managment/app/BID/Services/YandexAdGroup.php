<?php

namespace App\BID\Services;

use App\BID\Contracts\AdGroup;
use Closure;

class YandexAdGroup extends Service implements AdGroup
{

    private array $adGroups;

    public function __construct(array $adGroups)
    {
        $this->adGroups = $adGroups;
    }

    public function piplineHandler($request, Closure $next)
    {
        $prepareAdGroups = $this->makeGroupDataByColumn($this->adGroups, 'AdGroups', 'CampaignId');
        $data['result'] = $request;
        foreach ($prepareAdGroups as $compaignID => $groups) {
            $prepareAdGroupData = $this->makeColumnByIndex(data: $groups, model: '', column: 'Id');
            $data['result'][$compaignID]['adGroups'] = $prepareAdGroupData;
        }
        $request = $data;
        $request['campaignIDs'] = array_keys($request['result']);
        $request['adGroupIDs'] = array_column(current($this->adGroups)['AdGroups'], 'Id');
        return $next($request);
    }
}
