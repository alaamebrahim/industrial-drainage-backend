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
            'result_date' => $this->result?->result_date,
            'claim_consumption' => $this->consumption,
            'total_amount' => $this->total_amount,
            'amount_paid' => $this->payments()->sum('amount'),
            'details' => ClaimDetailResource::collection($this->details)
        ];
    }
}
