<?php

namespace App\Http\Requests\Claims;

use App\Http\Requests\JsonFormRequest;

class UpdateClaimAdjustmentDatesRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'claim_id' => ['required'],
            'details' => ['required'],
        ];
    }
}
