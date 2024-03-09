<?php

namespace App\Http\Requests\Claims;

use App\Http\Requests\JsonFormRequest;

class StoreClaimRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required'],
            'consumption' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ];
    }
}
