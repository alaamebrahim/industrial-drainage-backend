<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'client_key' => $this->client_key,
            'letter_heading' => $this->letter_heading,
            'consumption' => $this->consumption,
            'is_active' => $this->is_active,
            'total_amount' => $totalAmount = $this->claims->sum('total_amount'),
            'amount_paid' => $amountPaid = $this->payments->sum('amount'),
            'net_amount' => $totalAmount - $amountPaid,
            'claims_count' => $this->claims()->count(),
            'results_count' => $this->results()->count(),
        ];
    }
}
