<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ValidateLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    public function store(ValidateLogin $validate)
    {
        $DTO = $validate->makeDTO();
        if (Auth::attempt([
            'email' => $DTO->getEmail(),
            'password' => $DTO->getPassword()
        ])) {
            $user = Auth::user();
            $token = $user->createToken('main')->accessToken;
            return response(compact('user', 'token'));
        }
        return $this->prepareErrorResponse([
            'email' => ['Email is incorrect'],
            'password' => ['Password is incorrect']
        ]);
    }

    public function logout(Request $request)
    {
        $user  = $request->user();
        $user->tokens()->delete();
        return response(compact('user'));
    }
}
