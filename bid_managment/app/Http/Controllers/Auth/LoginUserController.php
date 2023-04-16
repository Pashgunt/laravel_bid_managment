<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ValidateLogin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginUserController
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(ValidateLogin $validate)
    {
        $DTO = $validate->makeDTO();
        if (Auth::attempt([
            'email' => $DTO->getEmail(),
            'password' => $DTO->getPassword()
        ])) {
            $user = Auth::user();
            $token = $user->createToken('main')->plainTextToken;
            return response(compact('user','token'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('auth-page'));
    }
}
