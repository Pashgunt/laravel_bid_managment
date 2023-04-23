<?php

namespace App\BID\Services;

use App\BID\Contracts\ActiveAccount as InterfaceActiveAccount;
use App\BID\Contracts\Directs;
use App\BID\DTO\AccountsDTO;
use App\Models\ActiveAccount as ModelsActiveAccount;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pipeline\Pipeline;

class ActiveAccount implements InterfaceActiveAccount
{
    public function prepareSelectedActiveAccount(Collection $allAccounts, ?ModelsActiveAccount $activeAccount)
    {
        if (!$allAccounts) return [];
        $result = [];
        foreach ($allAccounts as $account) {
            $accountDTO = new AccountsDTO($account);
            $result[$accountDTO->getID()] = $accountDTO->prepareDataForSelect($activeAccount->direct_id ?? 0);
        }
        return $result;
    }

    public function chooseOnceActiveAccountByRequest(array $accounts, ?int $accountID)
    {
        if ($accountID) return $accounts[$accountID];

        foreach ($accounts as $accountData) {
            if ($accountData['selected']) return $accountData;
        }
    }

    public function prepareCampaigns(
        Directs $direct,
        string $accessToken = '',
        bool $includeAdGroups = true,
        bool $includeKeywords = true,
        bool $includeKeywordBids = true
    ) {
        return app(Pipeline::class)
            ->send([])
            ->through($this->prepareThroughArrayForPipline($direct, $accessToken, $includeAdGroups, $includeKeywords, $includeKeywordBids))
            ->via('piplineHandler')
            ->thenReturn();
    }

    public function prepareThroughArrayForPipline(
        Directs $direct,
        string $accessToken,
        bool $includeAdGroups = true,
        bool $includeKeywords = true,
        bool $includeKeywordBids = true
    ) {
        $through = [
            new YandexCompaign($direct->getCompaigns($accessToken))
        ];

        if ($includeAdGroups) {
            $through[] = function ($request, Closure $next) use ($direct, $accessToken) {
                return $next((new YandexAdGroup($direct->getAdGroups($accessToken, [
                        "CampaignIds" => array_keys($request),
                    ])))->piplineHandler($request, $next)
                );
            };
        }
        if ($includeKeywords) {
            $through[] = function ($request, Closure $next) use ($direct, $accessToken) {
                return $next((new YandexKeyword($direct->getKeywords($accessToken, [
                    'AdGroupIds' => $request['adGroupIDs'],
                    'CampaignIds' => $request['campaignIDs'],
                ])))->piplineHandler($request, $next));
            };
        }
        if ($includeKeywordBids) {
            $through[] = function ($request, Closure $next) use ($direct, $accessToken) {
                return $next((new YandexKeywordBid($direct->getKeywordBids($accessToken, [
                    'AdGroupIds' => $request['adGroupIDs'],
                    'CampaignIds' => $request['campaignIDs'],
                    "KeywordIds" => $request['keywordIDs'],
                    "ServingStatuses" => ["ELIGIBLE", "RARELY_SERVED"],
                ])))->piplineHandler($request, $next));
            };
        }

        return $through;
    }

    public function prepareAdGroups(Directs $direct, string $accessToken)
    {
        $compaigns = $this->prepareCampaigns($direct, $accessToken);
        
        return ['result' => array_column($compaigns['result'], 'adGroups')];
    }
}
