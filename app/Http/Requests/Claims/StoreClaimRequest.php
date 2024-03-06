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
            'result_id' => ['required'],
            'client_id' => ['required'],
            'consumption' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'result_date' => ['required', 'date'],
        ];
    }
}
