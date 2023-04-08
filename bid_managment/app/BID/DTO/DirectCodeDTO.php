<?php

namespace App\BID\DTO;

class DirectCodeDTO
{
    private string $clientID;
    private string $clientSecret;

    public function __construct(string $clientID, string $clientSecret, ?string $acessToken = null, ?string $code = null)
    {
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
    }

    public function getClientID(): string
    {
        return $this->clientID;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }
}
