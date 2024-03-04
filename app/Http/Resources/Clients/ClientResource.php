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
            'last_consumption' => $this->last_consumption,
            'is_active' => $this->is_active,
        ];
    }
}
