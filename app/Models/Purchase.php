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
 * App\Models\Purchase
 *
 * @property string $id
 * @property int $user_id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Purchase newModelQuery()
 * @method static Builder|Purchase newQuery()
 * @method static Builder|Purchase query()
 * @method static Builder|Purchase whereCreatedAt($value)
 * @method static Builder|Purchase whereProductId($value)
 * @method static Builder|Purchase whereUpdatedAt($value)
 * @method static Builder|Purchase whereUserId($value)
 * @method static Builder|Purchase whereUuid($value)
 * @mixin Eloquent
 * @property-read Product $product
 * @property-read User $user
 */
class Purchase extends Model
{
    use HasFactory, BelongsToProduct, BelongsToUser, HasUuids;
}
