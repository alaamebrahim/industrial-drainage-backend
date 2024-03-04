<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermissionTo('ROLE_STORE_USERS');
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:users,id'],
            'fullName' => 'required',
            'password' => ['nullable', Password::min(6)->uncompromised()],
            'username' => ['required', 'unique:users,username'],
            'email' => ['required', 'unique:users,email,'.$this->get('id')],
        ];
    }
}
