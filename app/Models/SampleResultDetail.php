<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleResultDetail extends Model
{
    use HasFactory;

    public function result(): BelongsTo
    {
        return $this->belongsTo(SampleResult::class);
    }

    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }

    public function sampleDetail(): BelongsTo
    {
        return $this->belongsTo(SampleDetail::class);
    }
}
