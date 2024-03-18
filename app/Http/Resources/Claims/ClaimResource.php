<?php

namespace App\Http\Resources\Claims;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaimResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'client_key' => $this->client?->client_key,
            'client_id' => $this->client_id,
            'client_name' => $this->client?->name,
            'client_address' => $this->client?->address,
            'client_consumption' => $this->client?->consumption,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_paid' => $this->is_paid,
            'is_cancelled' => $this->is_cancelled,
            'claim_consumption' => $this->consumption,
            'total_amount' => number_format($this->total_amount, 2),
            'amount_paid' => number_format($this->payments()->sum('amount'), 2),
            'details' => ClaimDetailResource::collection($this->details),
        ];
    }
}
