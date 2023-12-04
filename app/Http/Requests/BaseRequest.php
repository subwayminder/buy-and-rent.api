<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * Class BaseRequest
 * @package App\Http\Requests
 *
 * @OA\RequestBody (
 *     request = "BaseRequest",
 *     required = true
 * )
 */
abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
