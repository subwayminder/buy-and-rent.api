<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * Class RefreshTokenRequest
 *
 * @package App\Http\Requests\Auth
 * @property-read string $refresh_token
 *
 * @OA\RequestBody (
 *     request="RefreshTokenRequest",
 *     required=true,
 *     @OA\JsonContent (
 *         @OA\Property (
 *             property="refresh_token",
 *             type="string"
 *         )
 *     )
 * )
 */
class RefreshTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'refresh_token' => [
                'required',
                'string'
            ]
        ];
    }
}
