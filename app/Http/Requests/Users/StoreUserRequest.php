<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasPermissionTo('ROLE_STORE_USERS');
    }

    public function rules(): array
    {
        return [
            'fullName' => 'required',
            'username' => ['required', 'unique:users,username'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', Password::min(6)->uncompromised()],
        ];
    }
}
