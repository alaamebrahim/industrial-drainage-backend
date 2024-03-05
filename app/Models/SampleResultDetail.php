<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $sample_result_id
 * @property int $sample_id
 * @property int $sample_detail_id
 * @property float $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SampleResult|null $result
 * @property-read \App\Models\Sample $sample
 * @property-read \App\Models\SampleDetail $sampleDetail
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail whereSampleDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail whereSampleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail whereSampleResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleResultDetail whereValue($value)
 * @mixin \Eloquent
 */
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
