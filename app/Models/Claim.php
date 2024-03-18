<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $client_id
 * @property string $result_date
 * @property string $start_date
 * @property string $end_date
 * @property int $consumption
 * @property string|null $total_amount
 * @property string $amount_paid
 * @property bool $is_paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client $client
 * @property-read \App\Models\Result $result
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Claim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Claim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Claim query()
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereConsumption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereResultDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereUpdatedAt($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClaimDetail> $details
 * @property-read int|null $details_count
 * @property int $is_cancelled
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Claim whereIsCancelled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Claim active()
 *
 * @mixin \Eloquent
 */
class Claim extends Model
{
    use HasFactory;

    protected $casts = [
        'total_amount' => 'float',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_cancelled', false);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(ClaimDetail::class)->orderBy('id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
