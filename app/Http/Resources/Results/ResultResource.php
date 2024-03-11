<?php

namespace App\Http\Resources\Results;

use App\Models\Claim;
use App\Models\ClaimDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'result_date' => $this->result_date,
            'details' => ResultDetailResource::collection($this->resultDetails),
            'hasClaims' => ClaimDetail::query()->whereIn('result_detail_id', $this->resultDetails()->pluck('id')->toArray())->exists()
        ];
    }
}
