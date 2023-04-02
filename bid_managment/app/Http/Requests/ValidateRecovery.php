<?php

namespace App\Http\Requests;

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
        ];
    }

    public function makeDTO(): RecoveryDTO
    {
        $validated = $this->validated();

        return new RecoveryDTO($validated['email']);
    }
}