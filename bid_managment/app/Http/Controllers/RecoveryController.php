<?php

namespace App\Http\Controllers;

use App\BID\DTO\UserDTO;
use App\BID\Repositories\RecoveryTokenRepository;
use App\BID\Repositories\UserRepository;
use App\Http\Requests\ValidateRecovery;
use App\Mail\RecoveryPasswordMail;
use App\Models\RecoveryToken;
use Illuminate\Support\Facades\Mail;

class RecoveryController extends Controller
{
    private UserRepository $userRepository;
    private RecoveryTokenRepository $recoveryTokenRepository;
    private RecoveryToken $recoveryToken;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->recoveryTokenRepository = new RecoveryTokenRepository();
        $this->recoveryToken = new RecoveryToken();
    }

    public function index()
    {
        return view('auth.recovery');
    }

    public function store(ValidateRecovery $validate)
    {
        $DTO = $validate->makeDTO();
        $userRaw = $this->userRepository->getUserByEmail($DTO->getEmail());
        if ($userRaw) {
            $userDTO = new UserDTO($userRaw);
            $recoveryToken = $this->recoveryToken->generateRandomString(20);
            $this->recoveryTokenRepository->createNewRecoveryTokenForUser($userDTO->getID(), $recoveryToken);
            Mail::to($DTO->getEmail())->send(new RecoveryPasswordMail($userDTO->getName(), $recoveryToken));
        }
    }

    public function checkRecoveryToken(string $recoveryToken)
    {
        dd($recoveryToken);
    }
}
