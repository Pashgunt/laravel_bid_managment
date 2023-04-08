<?php

namespace App\BID\Repositories;

use App\Models\RecoveryToken;

class RecoveryTokenRepository
{
    public function createNewRecoveryTokenForUser(int $userID, string $recoveryToken)
    {
        return RecoveryToken::create([
            'user_id' => $userID,
            'recovery_token' => $recoveryToken
        ]);
    }

    public function getUserByRecoveryToken(string $recoveryToken)
    {
        return RecoveryToken::query()->where([
            'recovery_token' => $recoveryToken,
            'is_actual' => 1
        ])->first();
    }

    public function updateActualStateForToken(string $recoveryToken, int $userID)
    {
        return RecoveryToken::query()->where([
            'recovery_token' => $recoveryToken,
            'user_id' => $userID
        ])->update([
            'is_actual' => 0
        ]);
    }

    public function checkVaidTokenByDate(string $date){
        return RecoveryToken::query()->where([
            'created_at', '<=', $date
        ])->update([
            'is_actual' => 0
        ]);
    }
}
