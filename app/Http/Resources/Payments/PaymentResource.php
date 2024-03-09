<?php

namespace App\Http\Resources\Payments;

use App\Http\Resources\Claims\ClaimDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' =>$this->amount,
            'payment_date' =>$this->payment_date,
            'payment_method' =>$this->payment_method,
            'payment_method_string' =>$this->getPaymentMethodString(),
            'notes' =>$this->notes,
            'client_key' => $this->claim?->client?->client_key,
            'client_id' => $this->claim?->client_id,
            'client_name' => $this->claim?->client?->name,
            'client_address' => $this->claim?->client?->address,
            'claim_start_date' => $this->claim?->start_date,
            'claim_end_date' => $this->claim?->end_date,
            'claim_total_amount' => $this->claim?->total_amount,
            'claim_amount_paid' => $this->claim?->payments()->sum('amount'),
        ];
    }

    protected function getPaymentMethodString(): string
    {
        return [
            'CASH' => 'نقدأ',
            'CHEQUE' => 'شيك',
            'ORDER' => 'أمر دفع',
        ][$this->payment_method];
    }
}
