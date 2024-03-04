<?php

namespace App\Http\Requests\SampleDetails;

use App\Http\Requests\JsonFormRequest;
use Illuminate\Validation\Rule;

class StoreSampleDetailRequest extends JsonFormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'sample_id' => ['required', 'exists:samples,id'],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'duration' => ['nullable'],
        ];
    }
}
