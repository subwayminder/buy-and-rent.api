<?php

namespace App\Services\Purchase;

use App\Models\Product;
use App\Models\Rent;
use App\Models\User;
use App\Services\CRUDService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class RentService extends CRUDService
{
    public function getBuilder(): Builder
    {
        return Rent::query();
    }

    public function rent(User $user, Product $product, int $hours): Rent
    {
        $rent = new Rent([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'start_rent' => now(),
            'end_rent' => Carbon::now()->addHours($hours)
        ]);
        $rent->save();
        $user->account_balance -= $product->rent_hour_price * $hours;
        $user->save();
        return $rent;
    }

    public function extendRent(string $rentId, int $hours): Rent
    {
        $checkRent = Rent::query()
            ->where('id', $rentId)
            ->where('end_rent', '>=', Carbon::now()->toDateTimeString())
            ->first();
        if ($checkRent) {
            $checkRent->end_rent = Carbon::parse($checkRent->end_rent)->addHours($hours);
            $product = $checkRent->product;
            $user = $checkRent->user;
            $user->account_balance -= $product->rent_hour_price * $hours;
            $user->save();
            $checkRent->save();
            return $checkRent;
        } else {
            $rent = Rent::where('id', $rentId)->first();
            $product = $rent->product;
            $user = $rent->user;
            $user->account_balance -= $product->rent_hour_price * $hours;
            $user->save();
            $newRent = new Rent([
                'user_id' => $rent->user_id,
                'product_id' => $rent->product_id,
                'start_rent' => now(),
                'end_rent' => Carbon::now()->addHours($hours)
            ]);
            $newRent->save();
            return $newRent;
        }
    }
}
