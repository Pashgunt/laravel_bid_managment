<?php

namespace App\Http\Controllers;

use App\BID\DTO\UserDTO;
use App\BID\Repositories\RecoveryTokenRepository;
use App\BID\Repositories\UserRepository;
use App\Http\Requests\Api\ValidateRecovery;
use App\Http\Requests\Api\ValidateRecoveryNewPass;
use App\Jobs\RecoveryPasswordJob;
use App\Models\RecoveryToken;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

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

    public function store(ValidateRecovery $validate)
    {
        $DTO = $validate->makeDTO();
        $userRaw = $this->userRepository->getUserByEmail($DTO->getEmail());
        $hasFaild = false;
        if ($userRaw) {
            $userDTO = new UserDTO($userRaw);
            $recoveryToken = $this->recoveryToken->generateRandomString(20);
            $this->recoveryTokenRepository->createNewRecoveryTokenForUser($userDTO->getID(), $recoveryToken);
            Bus::batch([
                new RecoveryPasswordJob($userDTO->getEmail(), $userDTO->getName(), $recoveryToken)
            ])->catch(function (Batch $batch, Throwable $e) use (&$hasFaild) {
                $hasFaild = true;
                Log::error($e->__toString());
            })->dispatch();

            return !$hasFaild ? response(compact('recoveryToken')) : $this->prepareErrorResponse(['result' => ['Something going wrong']]);
        }

        return $this->prepareErrorResponse(['result' => ['Something going wrong']]);
    }

    public function checkRecoveryToken($recoveryToken)
    {
        $token = $this->recoveryTokenRepository->getUserByRecoveryToken($recoveryToken);
        if ($token) {
            return response(compact('token'));
        }
        return $this->prepareErrorResponse(['result' => ['Something going wrong']]);
    }

    public function createNewPass(ValidateRecoveryNewPass $request, string $tokenParam)
    {
        $validated = $request->validated();
        $token = $this->recoveryTokenRepository->getUserByRecoveryToken($tokenParam);
        $this->userRepository->updateUserPassword($token->user_id, Hash::make($validated['password']));
        $this->recoveryTokenRepository->updateActualStateForToken($tokenParam, $token->user_id);

        return response(compact('token'));
    }

    public function makeInnactive(string $tokenParam)
    {
        $token = $this->recoveryTokenRepository->getUserByRecoveryToken($tokenParam);
        $this->recoveryTokenRepository->updateActualStateForToken($tokenParam, $token->user_id);

        return response('ok', 200);
    }
}
