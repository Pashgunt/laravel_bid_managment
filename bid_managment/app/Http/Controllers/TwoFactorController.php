<?php

namespace App\Http\Controllers;

use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{

    public function index()
    {
        $user = auth('api')->user();
        return response(compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'string|required',
        ]);
        $user = auth()->user();
        if ($request->post('two_factor_code') == $user->two_factor_code) {
            $user->resetTwoFactorCode();
            return response('ok', 200);
        }
        return $this->prepareErrorResponse([
            'two_factor_code' => ['The two factor code you have entered does not match']
        ]);
    }

    public function resend()
    {
        $user = auth('api')->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return response('ok', 200);
    }
}
