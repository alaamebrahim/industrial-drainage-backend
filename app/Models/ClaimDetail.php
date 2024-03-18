<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $claim_id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereClaimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereValue($value)
 *
 * @property int $result_detail_id
 * @property string $start_date
 * @property string $end_date
 * @property string|null $adjustment_date
 * @property string|null $old_value
 * @property-read \App\Models\ResultDetail|null $resultDetail
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereAdjustmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereOldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereResultDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereStartDate($value)
 *
 * @mixin \Eloquent
 */
class ClaimDetail extends Model
{
    use HasFactory;

    protected $casts = [
        'value' => 'float',
    ];

    public function resultDetail(): BelongsTo
    {
        return $this->belongsTo(ResultDetail::class);
    }
}
