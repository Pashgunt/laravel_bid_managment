<?php

namespace App\Http\Requests;

use App\BID\DTO\RegisterDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ValidateRegistration extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users',
            'name' => 'required|string|min:10|not_regex:/(?=.*[!@#$%^&*"])/',
            'password' => Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
            're_password' => 'required|same:password',
        ];
    }

    public function makeDTO(): RegisterDTO
    {
        $validated = $this->validated();
        
        return new RegisterDTO($validated['email'], $validated['name'], $validated['password']);
    }
}
