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
        bool $includeAdGroups = false,
        bool $includeKeywords = false,
        bool $includeKeywordBids = false
    );
    public function prepareThroughArrayForPipline(
        Directs $direct,
        string $accessToken,
        bool $includeAdGroups = false,
        bool $includeKeywords = false,
        bool $includeKeywordBids = false
    );
}
