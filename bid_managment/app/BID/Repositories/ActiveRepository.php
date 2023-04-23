<?php

namespace App\BID\Repositories;

use App\BID\Abstracts\RepositoryForActiveAccount;
use App\Models\ActiveAccount;

class ActiveRepository
{
    public function getActiveAccountForUser(int $userID)
    {
        return ActiveAccount::query()->where([
            ['user_id', '=', $userID],
            ['is_actual', '=', 1]
        ])->first();
    }

    public function makeInnactiveAccountForUser(int $userID)
    {
        return ActiveAccount::query()->where([
            ['user_id', '=', $userID]
        ])->delete();
    }

    public function makeActiveAccountForUser(int $userID, int $accountID)
    {
        return ActiveAccount::create([
            'user_id' => $userID,
            'direct_id' => $accountID,
            'is_actual' => 1
        ]);
    }
}
