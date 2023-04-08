<?php

namespace App\Http\Requests\Api;

use App\BID\DTO\DirectCodeDTO;
use Illuminate\Foundation\Http\FormRequest;

class ValidateMakeInnactive extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
    }
}
