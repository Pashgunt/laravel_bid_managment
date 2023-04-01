<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateCodeDirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ApiAuthToken extends Controller
{
    public function store(ValidateCodeDirect $validate)
    {
        $DTO = $validate->makeDTO();

        return response('ok', 200)->cookie('client_id', $DTO->getClientID(), 1);
    }
}
