<?php

namespace App\Http\Middleware\JWT;

use App\Exceptions\TokenExpiredCustomException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTGuard
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     * @throws TokenInvalidException
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $payload = JWTAuth::parseToken()->getPayload();
        } catch (TokenExpiredException $e) {
            throw new TokenExpiredCustomException(message: $e->getMessage(), code: 401, previous: $e->getPrevious());
        }
        if (($aud = $payload->get('aud')) && ($guard = data_get($aud, '0'))) {
            auth()->shouldUse($guard);
        } else {
            throw new TokenInvalidException('Invalid token');
        }

        return $next($request);
    }
}
