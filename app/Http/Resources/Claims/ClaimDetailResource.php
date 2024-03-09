<?php

namespace App\Http\Resources\Claims;

use App\Http\Resources\Samples\SampleDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaimDetailResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'claim_id' => $this->claim_id,
            'result_detail_id' => $this->result_detail_id,
            'key' => $this->key,
            'value' => $this->value,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'result_detail_value' => $this->resultDetail?->value,
            'sample_detail' => new SampleDetailResource($this->resultDetail?->sampleDetail),
        ];
    }
}
