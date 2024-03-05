<?php

namespace App\Http\Resources\SampleResults;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SampleResultResource extends JsonResource
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
            'sample_result_date' => $this->sample_result_date,
            'details' => SampleResultDetailResource::collection($this->resultDetails)
        ];
    }
}
