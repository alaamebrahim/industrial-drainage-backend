<?php

namespace App\Http\Requests\Samples;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Validation\Rule;

class StoreSampleRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
}
