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
}
