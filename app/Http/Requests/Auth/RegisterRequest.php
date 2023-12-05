<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\RequestBody (
 *     request="RegisterRequest",
 *     required=true,
 *     @OA\JsonContent (
 *         @OA\Property (
 *             property="name",
 *             type="string"
 *         ),
 *         @OA\Property (
 *             property="email",
 *             type="string"
 *         ),
 *         @OA\Property (
 *             property="password",
 *             type="string"
 *         ),
 *         @OA\Property (
 *             property="password_confirmation",
 *             type="string"
 *         ),
 *     )
 * )
 */
class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => [
                'required',
                Rule::unique(User::class, 'email')
            ],
            'password' => [
                'required',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
                'min:6',
                'confirmed'
            ],
            'password_confirmation' => 'required|string'
        ];
    }
}
