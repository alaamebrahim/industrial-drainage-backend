<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'client_key' => ['required', Rule::unique('clients')->ignore($this->get('id'))],
            'name' => ['required'],
            'address' => ['required'],
            'letter_heading' => ['required'],
            'last_consumption' => ['nullable'],
            'is_active' => ['nullable'],
        ];
    }
}
