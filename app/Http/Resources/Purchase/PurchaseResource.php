<?php

namespace App\Http\Resources\Purchase;

use App\Http\Resources\Product\ProductUserResource;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @mixin Purchase
 *
 * @OA\Schema (
 *     title="Purchase resource",
 *     description="Purchase resource",
 *     @OA\Xml(
 *         name="Purchase resource"
 *     ),
 *     @OA\Property(
 *         property="id",
 *         format="integer",
 *     ),
 *     @OA\Property(
 *         property="product",
 *         format="object",
 *         ref="#/components/schemas/ProductUserResource"
 *     ),
 * )
 */
class PurchaseResource extends JsonResource
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
            'product' => ProductUserResource::make($this->product),
        ];
    }
}
