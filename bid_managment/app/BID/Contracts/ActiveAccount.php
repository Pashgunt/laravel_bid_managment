<?php

namespace App\BID\Contracts;

use App\Models\ActiveAccount as ModelsActiveAccount;
use Illuminate\Database\Eloquent\Collection;

interface ActiveAccount
{
    public function prepareSelectedActiveAccount(Collection $allAccounts, ?ModelsActiveAccount $activeAccount);
}
