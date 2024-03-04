<?php

namespace App\Http\Resources\Samples;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SampleDetailResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sample_id' => $this->sample_id,
            'sample_name' => $this->sample?->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
        ];
    }
}
