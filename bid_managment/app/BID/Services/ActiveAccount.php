<?php

namespace App\BID\Services;

use App\BID\Contracts\ActiveAccount as InterfaceActiveAccount;
use App\BID\DTO\AccountsDTO;
use App\Models\ActiveAccount as ModelsActiveAccount;
use Illuminate\Database\Eloquent\Collection;

class ActiveAccount implements InterfaceActiveAccount
{
    public function prepareSelectedActiveAccount(Collection $allAccounts, ?ModelsActiveAccount $activeAccount)
    {
        if (!$allAccounts) return [];
        $result = [];
        foreach ($allAccounts as $account) {
            $accountDTO = new AccountsDTO($account);
            $result[] = $accountDTO->prepareDataForSelect($activeAccount->direct_id ?? 0);
        }
        return $result;
    }
}
