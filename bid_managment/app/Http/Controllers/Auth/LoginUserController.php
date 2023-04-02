<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ValidateLogin;
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
            return redirect(route('auth-list-requests'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('auth-page'));
    }
}
