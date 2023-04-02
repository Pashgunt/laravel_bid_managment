<?php

namespace App\BID\DTO;

use Illuminate\Support\Facades\Hash;

class RegisterDTO
{
    private string $email;
    private string $name;
    private string $password;

    public function __construct(string $email, string $name, string $password)
    {
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return Hash::make($this->password);
    }
}
