<?php

namespace App\Http\Requests\Clients;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'client_key' => ['required', Rule::unique('clients', 'client_key')],
            'name' => ['required'],
            'address' => ['required'],
            'letter_heading' => ['required'],
            'consumption' => ['nullable'],
            'is_active' => ['nullable'],
        ];
    }
}
