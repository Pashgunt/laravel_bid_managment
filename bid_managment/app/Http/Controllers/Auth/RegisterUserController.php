<?php

namespace App\Http\Controllers\Auth;

use App\BID\Repositories\RegisterRepository;
use App\Http\Requests\ValidateRegistration;

class RegisterUserController
{

    private RegisterRepository $registerRepository;

    public function __construct()
    {
        $this->registerRepository = new RegisterRepository();
    }

    public function index()
    {
        return view('auth.register');
    }

    public function store(ValidateRegistration $validate)
    {
        $DTO = $validate->makeDTO();

        $this->registerRepository->createNewUser($DTO);

        return redirect(route('auth-page'));
    }
}
