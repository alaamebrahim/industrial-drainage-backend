<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class JsonFormRequest extends BaseFormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $errorBag = [];
        foreach ($errors as $error) {
            if (is_array($error)) {
                foreach ($error as $err) {
                    $errorBag[] = $err;
                }
            } else {
                $errorBag[] = $error;
            }
        }
        throw new HttpResponseException(
            response()->json(['success' => false, 'errors' => $validator->errors()], 400)
        );
    }
}
