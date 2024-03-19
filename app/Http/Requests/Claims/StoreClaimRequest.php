<?php

namespace App\Http\Requests\Claims;

use App\Http\Requests\JsonFormRequest;
use App\Models\Claim;
use Illuminate\Validation\Validator;

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

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator){
            $startDateExists = Claim::query()
                ->where('client_id', $this->get('client_id'))
                ->whereBetween('start_date', [$this->get('start_date'), $this->get('start_date')])
                ->exists();
            $endDateExists = Claim::query()
                ->where('client_id', $this->get('client_id'))
                ->whereBetween('end_date', [$this->get('start_date'), $this->get('start_date')])
                ->exists();
            if ($startDateExists || $endDateExists) {
                $validator->errors()->add('swal', 'تاريخ المطالبة غير صحيح حيث يوجد مطالبة أخرى عن نفس الفترة');
            }
        });
    }
}
