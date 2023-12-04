<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Services\CRUDService;
use Illuminate\Database\Eloquent\Builder;

class ProductService extends CRUDService
{

    public function getBuilder(): Builder
    {
        return Product::query();
    }
}
