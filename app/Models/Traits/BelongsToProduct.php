<?php

namespace App\Models\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Model
 */
trait BelongsToProduct
{
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
