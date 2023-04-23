<?php

namespace App\BID\Contracts;

use App\Models\ActiveAccount as ModelsActiveAccount;
use Illuminate\Database\Eloquent\Collection;

interface ActiveAccount
{
    public function prepareSelectedActiveAccount(Collection $allAccounts, ?ModelsActiveAccount $activeAccount);
    public function chooseOnceActiveAccountByRequest(array $accounts, ?int $accountID);
    public function prepareCampaigns(
        Directs $direct,
        string $accessToken,
        bool $includeAdGroups = true,
        bool $includeKeywords = true,
        bool $includeKeywordBids = true
    );
    public function prepareThroughArrayForPipline(
        Directs $direct,
        string $accessToken,
        bool $includeAdGroups = true,
        bool $includeKeywords = true,
        bool $includeKeywordBids = true
    );
    public function prepareAdGroups(Directs $direct, string $accessToken);
}
