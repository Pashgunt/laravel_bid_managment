<?php

namespace App\BID\DTO;

use App\Models\DirectToken;

class AccountsDTO
{
    private int $id;
    private string $clientID;
    private string $clientSecret;
    private ?string $acessToken;
    private ?string $code;

    public function __construct(DirectToken $direct)
    {
        $this->id = $direct->id;
        $this->clientID = $direct->client_id;
        $this->clientSecret = $direct->client_secret;
        $this->acessToken = $direct->acess_token;
        $this->code = $direct->code;
    }

    public function getClientID(): string
    {
        return $this->clientID;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getAccessToken(): ?string
    {
        return $this->acessToken;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getID(): int
    {
        return $this->id;
    }

    public function checkActiveID(int $id): string
    {
        return $this->getID() === $id ? "selected" : '';
    }

    public function prepareDataForSelect(int $id): array
    {
        return [
            'id' => $this->getID(),
            'client_id' => $this->getClientID(),
            'code' => $this->getCode(),
            'client_secret' => $this->getClientSecret(),
            'access_token' => $this->getAccessToken(),
            'selected' => $this->checkActiveID($id)
        ];
    }
}
