<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sample newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sample newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sample query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sample whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sample whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sample whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sample whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sample extends Model
{
    use HasFactory;

}
