<?php

namespace App\Data\Claims;

use Spatie\LaravelData\Data;

class UpdateClaimAdjustmentDateData extends Data
{
    public function __construct(
        public int $claim_id,
        public int $claim_detail_id,
        public ?string $adjustment_date
    ) {
    }
}
