<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $sample_id
 * @property string $description
 * @property int $price
 * @property string|null $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Sample $sample
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail whereSampleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SampleDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SampleDetail extends Model
{
    use HasFactory;

    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class, 'sample_id');
    }
}
