<?php

namespace App\Http\Requests\Api;

use App\BID\DTO\LoginDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ValidateLogin extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
            'captcha' => 'required',
        ];
    }

    public function makeDTO(): LoginDTO
    {
        $validated = $this->validated();

        return new LoginDTO($validated['email'],  $validated['password']);
    }
}
