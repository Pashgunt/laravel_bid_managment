<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ValidateCodeDirect;

class ApiAuthToken extends Controller
{
    public function store(ValidateCodeDirect $validate)
    {
        $DTO = $validate->makeDTO();

        return response('ok', 200)->cookie('client_id', $DTO->getClientID(), 1);
    }
}
