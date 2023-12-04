<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\PaginateRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * Class ProductIndexRequest
 * @package App\Http\Requests\Product
 *
 *  @property-read string $page
 *  @property-read string $limit
 *
 * @OA\RequestBody (
 *     request = "ProductIndexRequest",
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
class ProductIndexRequest extends PaginateRequest
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
