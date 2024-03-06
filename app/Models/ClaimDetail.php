<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $claim_id
 * @property string $key
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereClaimId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClaimDetail whereValue($value)
 * @mixin \Eloquent
 */
class ClaimDetail extends Model
{
    use HasFactory;

    protected $casts = [
        'value' => 'float'
    ];
}
