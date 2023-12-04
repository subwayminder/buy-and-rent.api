<?php

namespace App\Services\Auth;

use App\Models\RefreshToken;
use App\Models\User;
use App\Services\Auth\DTO\TokenDTO;
use App\Services\Auth\DTO\UserDTO;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthService
{
    /**
     * @param string $email
     *
     * @return TokenDTO
     */
    public function login(string $email): TokenDTO
    {
        /** @var User $user */
        $user = User::query()
            ->firstWhere('email', $email);

        return $this->getTokens($user);
    }

    public function register(UserDTO $userDto): TokenDTO
    {
        /** @var User $user */
        $user = User::create($userDto->toArray());
        return $this->getTokens($user);
    }

    /**
     * @param string $token
     *
     * @return TokenDTO
     * @throws Exception
     */
    public function refresh(string $token): TokenDTO
    {
        $payload = JWTAuth::setToken($token)->getPayload();

        try {
            $refreshToken = RefreshToken::query()
                ->with('user')
                ->findOrFail($payload->get('jti'));
        } catch (ModelNotFoundException) {
            throw new AuthenticationException('Необхожимо авторизоваться');
        }

        /** @var User $user */
        $user = $refreshToken->user;

        $this->deleteRefreshTokens($user);

        return $this->getTokens($user);
    }

    /**
     * @param User $user
     *
     * @return TokenDTO
     */
    private function getTokens(User $user): TokenDTO
    {
        return TokenDTO::from([
            'access_token' => auth()->login($user),
            'expired_at' => now()->addMinutes(config('jwt.ttl')),
            'refresh_token' => $this->getRefreshToken($user)
        ]);
    }

    /**
     * @param User $user
     */
    private function deleteRefreshTokens(User $user): void
    {
        $user->refreshTokens()->delete();
    }

    /**
     * @param User $user
     *
     * @return string
     */
    private function getRefreshToken(User $user): string
    {
        $refreshToken = $user->refreshTokens()->create();

        $payload = JWTFactory::customClaims([
            'jti' => $refreshToken->id,
            'exp' => now()->addMinutes(config('jwt.refresh_ttl'))->timestamp
        ])->make();

        return JWTAuth::encode($payload);
    }
}
