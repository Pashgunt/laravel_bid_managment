<?php

namespace App\BID\Enums;

class FileldNamesYandexDirect
{
    public const COMPAIGN_FIELD_NAMES = [
        'Id',
        'Name',
        'StartDate',
        'Type',
        'Status',
        'State',
        'StatusPayment',
        'Statistics',
        'Funds'
    ];
    public const AD_GROUP_FIELD_NAMES = [
        "CampaignId",
        "Id",
        "Name",
        "NegativeKeywords"
    ];
    public const KEYWORD_FIELD_NAMES = [
        "Id",
        "Keyword",
        "State",
        "Status",
        "ServingStatus",
        "AdGroupId",
        "CampaignId",
        "Bid",
        "ContextBid",
        "StrategyPriority",
        "Productivity",
        "StatisticsSearch",
        "StatisticsNetwork",
        "AutotargetingCategories"
    ];
    public const KEYWORD_BID_FIELD_NAMES = [
        "KeywordId",
        "AdGroupId",
        "CampaignId",
        "ServingStatus",
        "StrategyPriority"
    ];
    public const BID_FIELD_NAMES = [];
}
