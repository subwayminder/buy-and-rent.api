<?php

namespace App\Http\Requests;

use OpenApi\Annotations as OA;

/**
 * Class PaginateRequest
 * @package App\Http\Requests
 *
 *  @property-read string $page
 *  @property-read string $limit
 *  @property-read string $query
 *
 * @OA\RequestBody (
 *     request = "PaginateRequest",
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
abstract class PaginateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'limit' => [
                'nullable',
                'integer',
                'between:5,100'
            ],
            'page' => [
                'nullable',
                'integer'
            ],
        ];
    }
}
