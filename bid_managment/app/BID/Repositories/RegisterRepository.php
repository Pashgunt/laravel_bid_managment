<?php

namespace App\BID\Repositories;

use App\BID\DTO\RegisterDTO;
use App\Models\User;

class RegisterRepository
{
    public function createNewUser(RegisterDTO $DTO)
    {
        return User::create([
            'name' => $DTO->getName(),
            'email' => $DTO->getEmail(),
            'password' => $DTO->getPassword(),
        ]);
    }
}
