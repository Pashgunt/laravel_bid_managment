<?php

namespace App\Http\Controllers\Auth;

use App\BID\Repositories\RegisterRepository;
use App\Http\Requests\Api\ValidateRegistration;

class RegisterUserController
{
    private RegisterRepository $registerRepository;

    public function __construct()
    {
        $this->registerRepository = new RegisterRepository();
    }

    public function store(ValidateRegistration $validate)
    {
        $DTO = $validate->makeDTO();

        $user = $this->registerRepository->createNewUser($DTO);

        return response(compact('user'));
    }
}
