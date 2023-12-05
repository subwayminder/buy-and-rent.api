<?php

namespace App\Http\Requests\Purchase;

use App\Http\Requests\PaginateRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody (
 *     request = "RentIndexRequest",
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
class RentIndexRequest extends PaginateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return parent::rules();
    }
}
