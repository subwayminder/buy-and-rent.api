<?php

namespace App\Http\Resources\Purchase;

use App\Http\Resources\Product\ProductResource;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Rent
 */
class RentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product' => ProductResource::make($this->product),
            'start_rent' => $this->start_rent,
            'end_rent' => $this->end_rent,
            'is_expired' => $this->isExpired()
        ];
    }
}
