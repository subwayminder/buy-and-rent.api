<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use OpenApi\Annotations as OA;

/**
 * Class AdminLoginRequest
 * @package App\Http\Requests\Auth\Admin
 *
 * @property-read string $email
 * @property-read string $password
 *
 * @OA\RequestBody (
 *     request="LoginRequest",
 *     required=true,
 *     @OA\JsonContent (
 *         @OA\Property (
 *             property="email",
 *             type="string"
 *         ),
 *         @OA\Property (
 *             property="password",
 *             type="string"
 *         )
 *     )
 * )
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email:filter',
                'max:255'
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            /** @var User $user */
            $user = User::query()->where('email', $this->email)->first();

            if (!$user || !Hash::check($this->password, $user->password)) {
                $validator->errors()->add('message', 'The provided credentials are incorrect.');
            }
        });
    }
}
