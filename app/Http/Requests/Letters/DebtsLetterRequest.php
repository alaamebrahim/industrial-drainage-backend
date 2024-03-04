<?php

namespace App\Http\Requests\Letters;

use App\Http\Requests\JsonFormRequest;

class DebtsLetterRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => 'required',
            'amountstring' => 'required',
            'date' => 'required',
            'letter' => 'required',
        ];
    }
}
