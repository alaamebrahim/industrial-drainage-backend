<?php

namespace App\Data\SampleResults;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class SampleResultCalculationData extends Data
{
    public function __construct(
        public int $sampleResultId,
        public CarbonImmutable $calculationDate
    )
    {
    }
}
