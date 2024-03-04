<?php

namespace App\Http\Requests\SampleDetails;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSampleDetailRequest extends FormRequest
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
