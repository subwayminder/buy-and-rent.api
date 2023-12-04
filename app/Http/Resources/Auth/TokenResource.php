<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * Class AdminResource
 *
 * @package App\Http\Resources\Auth
 *
 * @property string $access_token
 * @property string $expired_at
 * @property string $refresh_token
 *
 * @OA\Schema (
 *     description = "Token resource",
 *     title = "Token resource",
 *     @OA\Xml (
 *         name = "Token resource"
 *     ),
 *     @OA\Property (
 *         property="access_token",
 *         format="string",
 *         description="Access token"
 *     ),
 *     @OA\Property (
 *         property="expired_at",
 *         format="datetime",
 *         description="Expired at"
 *     ),
 *     @OA\Property (
 *         property="refresh_token",
 *         format="string",
 *         description="Refresh token"
 *     )
 * )
 */
class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->access_token,
            'expired_at' => $this->expired_at,
            'refresh_token' => $this->refresh_token,
        ];
    }
}
