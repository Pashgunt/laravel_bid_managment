<?php

namespace App\BID\Repositories;

use App\BID\DTO\RegisterDTO;
use App\Models\User;

class UserRepository
{
    public function getUserByEmail(string $email)
    {
        return User::query()->where([
            'email' => $email
        ])->first();
    }
}
