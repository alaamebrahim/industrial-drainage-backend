<?php

namespace App\Http\Requests\Payments;

use App\Http\Requests\JsonFormRequest;

class StorePaymentRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'claim_id' => ['required'],
            'amount' => ['required', 'numeric'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required'],
            'notes' => ['nullable'],
        ];
    }
}
