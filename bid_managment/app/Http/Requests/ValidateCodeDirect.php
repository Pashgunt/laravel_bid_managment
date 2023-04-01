<?php

namespace App\Http\Requests;

use App\BID\DTO\DirectCodeDTO;
use Illuminate\Foundation\Http\FormRequest;

class ValidateCodeDirect extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
        ];
    }

    public function makeDTO(): DirectCodeDTO
    {
        $validated = $this->validated();

        return new DirectCodeDTO($validated['client_id'], $validated['client_secret']);
    }
}
