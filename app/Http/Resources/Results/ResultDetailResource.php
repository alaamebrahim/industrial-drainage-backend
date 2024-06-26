<?php

namespace App\Http\Resources\Results;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultDetailResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'result_id' => $this->result_id,
            'result_date' => $this->result?->result_date,
            'result_end_date' => $this->result_end_date ?? null,
            'adjustment_date' => $this->adjustment_date ?? null,
            'sample_id' => $this->sample_id,
            'sample_name' => $this->sample?->name,
            'sample_detail_name' => $this->sampleDetail?->description,
            'sample_detail_price' => $this->sampleDetail?->price,
            'sample_detail_id' => $this->sample_detail_id,
            'value' => $this->value,
            'duration' => $this->sampleDetail?->duration,
        ];
    }
}
