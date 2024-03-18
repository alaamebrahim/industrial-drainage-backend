<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $result_id
 * @property int $sample_id
 * @property int $sample_detail_id
 * @property float $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Result|null $result
 * @property-read \App\Models\Sample $sample
 * @property-read \App\Models\SampleDetail $sampleDetail
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail whereSampleDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail whereSampleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail whereSampleResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail whereResultId($value)
 *
 * @property string|null $adjustment_date
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ResultDetail whereAdjustmentDate($value)
 *
 * @mixin \Eloquent
 */
class ResultDetail extends Model
{
    use HasFactory;

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
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
