<?php

namespace App\Http\Requests\SampleResults;

use App\Http\Requests\JsonFormRequest;

class UpdateResultRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required'],
            'result_date' => ['required'],
            'items' => ['required'],
        ];
    }
}
