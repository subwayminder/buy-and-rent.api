<?php

namespace App\Models;

use App\Models\Traits\BelongsToProduct;
use App\Models\Traits\BelongsToUser;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Rent
 *
 * @property string $uuid
 * @property int $user_id
 * @property int $product_id
 * @property string $start_rent
 * @property string $end_rent
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Rent newModelQuery()
 * @method static Builder|Rent newQuery()
 * @method static Builder|Rent query()
 * @method static Builder|Rent whereCreatedAt($value)
 * @method static Builder|Rent whereEndRent($value)
 * @method static Builder|Rent whereProductId($value)
 * @method static Builder|Rent whereStartRent($value)
 * @method static Builder|Rent whereUpdatedAt($value)
 * @method static Builder|Rent whereUserId($value)
 * @method static Builder|Rent whereUuid($value)
 * @property-read Product $product
 * @property-read User $user
 * @mixin Eloquent
 */
class Rent extends Model
{
    use HasFactory, BelongsToProduct, BelongsToUser, HasUuids;

    public function isExpired(): bool
    {
        return $this->end_rent < now();
    }
}
