<?php

namespace App\Services\Purchase;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Rent;
use App\Models\User;
use App\Services\CRUDService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BuyService extends CRUDService
{
    public function getBuilder(): Builder
    {
        return Purchase::query();
    }

    public function getList(
        int $limit = 0,
        array|string $orderBy = '',
        string $sortType = 'asc',
        bool $returnBuilder = false,
        ?int $userId = null
    ): LengthAwarePaginator|Collection|Builder {
        $builder = parent::getList($limit, $orderBy, $sortType, true);
        if ($userId) {
            $builder->where('user_id', $userId);
        }
        return $builder->paginate($this->getLimit($limit, $builder->count()));
    }

    public function buy(User $user, Product $product): Model|Purchase|null
    {
        /** @var Purchase $checkPurchase */
        $product->quantity--;
        $product->save();
        $user->account_balance -= $product->buy_price;
        $user->save();
        Rent::where('product_id', $product->id)
            ->where('user_id', $user->id)
            ->delete();
        $purchase = new Purchase();
        $purchase->user_id = $user->id;
        $purchase->product_id = $product->id;
        $purchase->save();
        return $purchase;
    }
}
