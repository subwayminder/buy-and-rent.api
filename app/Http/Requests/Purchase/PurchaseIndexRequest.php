<?php

namespace App\Http\Requests\Purchase;

use App\Http\Requests\PaginateRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody (
 *     request = "PurchaseIndexRequest",
 *     required = true,
 *     @OA\JsonContent (
 *         @OA\Property (
 *             property="page",
 *             type="integer"
 *         ),
 *         @OA\Property (
 *             property="limit",
 *             type="integer"
 *         )
 *     )
 * )
 */
class PurchaseIndexRequest extends PaginateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return parent::rules();
    }
}
