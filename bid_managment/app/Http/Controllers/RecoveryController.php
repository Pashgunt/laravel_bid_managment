<?php

namespace App\Http\Controllers;

use App\BID\DTO\UserDTO;
use App\BID\Repositories\RecoveryTokenRepository;
use App\BID\Repositories\UserRepository;
use App\Http\Requests\ValidateRecovery;
use App\Http\Requests\ValidateRecoveryNewPass;
use App\Jobs\RecoveryPasswordJob;
use App\Mail\RecoveryPasswordMail;
use App\Models\RecoveryToken;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Hash;
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
            dispatch(new RecoveryPasswordJob($userDTO->getEmail(), $userDTO->getName(), $recoveryToken));
        }
    }

    public function checkRecoveryToken($recoveryToken)
    {
        if ($this->recoveryTokenRepository->getUserByRecoveryToken($recoveryToken)) {
            return $this->changePasswordForm($recoveryToken);
        }
        return view('auth.login');
    }

    public function changePasswordForm(string $recoveryToken)
    {
        return view('auth.recoveryNewPassword', ['token' => $recoveryToken]);
    }

    public function createNewPass(ValidateRecoveryNewPass $request)
    {
        $validated = $request->validated();
        $tokenRaw = $this->recoveryTokenRepository->getUserByRecoveryToken($request->query('token'));
        $this->userRepository->updateUserPassword($tokenRaw->user_id, Hash::make($validated['password']));
        $this->recoveryTokenRepository->updateActualStateForToken($request->query('token'), $tokenRaw->user_id);

        return redirect(route('auth-page'));
    }
}
