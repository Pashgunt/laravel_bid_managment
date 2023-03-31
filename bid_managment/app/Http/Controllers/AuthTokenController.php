<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AuthTokenController extends Controller
{
    public function direct(Request $request)
    {
        $exitCode = Artisan::call('app:girect-get-auth', [
            'code' => $request->get('code') ?? 0,
            'client_id' => '03805a89832b40a2b028dca6df3a9435',
            'client_secret' => '64a685ee53924ac8b7d39c30a28c6f41'
        ]);
    }
}
