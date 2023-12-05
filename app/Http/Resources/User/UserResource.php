<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @mixin User
 *
 * @OA\Schema (
 *     title="User resource",
 *     description="User resource",
 *     @OA\Xml(
 *         name="User resource"
 *     ),
 *     @OA\Property(
 *         property="id",
 *         format="integer",
 *     ),
 *     @OA\Property(
 *         property="name",
 *         format="string",
 *     ),
 *     @OA\Property(
 *         property="email",
 *         format="string",
 *     ),
 *     @OA\Property(
 *         property="balance",
 *         format="number",
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         format="string",
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         format="string",
 *     ),
 * )
 */
class UserResource extends JsonResource
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
            'email' => $this->email,
            'balance' => $this->account_balance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
