<?php

namespace App\Http\Resources\SampleResults;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SampleResultDetailResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sample_result_id' => $this->sample_result_id,
            'sample_id' => $this->sample_id,
            'sample_name' => $this->sample?->name,
            'sample_detail_name' => $this->sampleDetail?->description,
            'sample_detail_id' => $this->sample_detail_id,
            'value' => $this->value,
            'duration' => $this->sampleDetail?->duration,
        ];
    }
}
