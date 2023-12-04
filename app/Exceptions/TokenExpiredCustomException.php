<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class TokenExpiredCustomException extends \RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json(
            [
                'message' => 'Token expired'
            ],
            $this->getCode(),
            [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }
}
