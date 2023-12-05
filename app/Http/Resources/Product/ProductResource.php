<?php

namespace App\Http\Resources\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @mixin Product
 *
 * @OA\Schema (
 *     title="Product resource",
 *     description="Product resource",
 *     @OA\Xml(
 *         name="Product resource"
 *     ),
 *     @OA\Property(
 *         property="id",
 *         format="integer",
 *     ),
 *     @OA\Property(
 *         property="name",
 *         format="string"
 *     ),
 *     @OA\Property(
 *         property="buy_price",
 *         format="number"
 *     ),
 *     @OA\Property(
 *         property="rent_hour_price",
 *         format="number"
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         format="integer"
 *     ),
 * )
 */
class ProductResource extends JsonResource
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
            'name' => $this->name,
            'buy_price' => $this->buy_price,
            'rent_hour_price' => $this->rent_hour_price,
            'quantity' => $this->quantity
        ];
    }
}
