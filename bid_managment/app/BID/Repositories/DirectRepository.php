<?php

namespace App\BID\Repositories;

use App\BID\DTO\DirectCodeDTO;
use App\Models\DirectToken;
use Illuminate\Support\Facades\Cookie;

class DirectRepository
{
    public function createNewDirectCodesForRequests(DirectCodeDTO $DTO)
    {
        return DirectToken::create([
            'code' => null,
            'client_id' => $DTO->getClientID(),
            'client_secret' => $DTO->getClientSecret(),
            'acess_token' => null,
        ]);
    }

    public function setAcessTokenByClientID(string $clientID, string $code, string $accessToken)
    {
        return DirectToken::query()->where([
            'client_id' => $clientID
        ])->update([
            'acess_token' => $accessToken,
            'code' => $code
        ]);
    }

    public function getDataForPrepareTokenByClientId(string $clientID)
    {
        return DirectToken::query()->where([
            'client_id' => $clientID
        ])->first();
    }

    public function getAlRequests()
    {
        return DirectToken::all();
    }
}
