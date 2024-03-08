<?php

namespace App\Http\Requests\Manage\Users;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('users', 'name')],
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed'],
            'is_active' => ['required', 'bool'],
        ];
    }
}
