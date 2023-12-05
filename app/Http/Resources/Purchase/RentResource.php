<?php

namespace App\Http\Resources\Purchase;

use App\Http\Resources\Product\ProductResource;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @mixin Rent
 *
 * @OA\Schema (
 *     title="Rent resource",
 *     description="Rent resource",
 *     @OA\Xml(
 *         name="Rent resource"
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
 *     @OA\Property(
 *         property="start_rent",
 *         format="string"
 *     ),
 *     @OA\Property(
 *         property="end_rent",
 *         format="string"
 *     ),
 *     @OA\Property(
 *         property="is_expired",
 *         format="boolean"
 *     ),
 * )
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
