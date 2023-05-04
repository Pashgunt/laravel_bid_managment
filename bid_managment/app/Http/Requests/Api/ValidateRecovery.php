<?php

namespace App\Http\Requests\Api;

use App\BID\DTO\RecoveryDTO;
use Illuminate\Foundation\Http\FormRequest;

class ValidateRecovery extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'captcha' => 'required',
        ];
    }

    public function makeDTO(): RecoveryDTO
    {
        $validated = $this->validated();

        return new RecoveryDTO($validated['email']);
    }
}
