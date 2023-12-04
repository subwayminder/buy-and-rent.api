<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\TokenResource;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\AuthService;
use App\Services\Auth\DTO\UserDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json(
            TokenResource::make(
                $this->authService->login(
                    email: $request->email
                )
            )
        );
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = UserDTO::from($request->toArray());
        $response = TokenResource::make(
            $this->authService->register($dto)
        );
        return response()->json($response);
    }

    public function me(): JsonResponse
    {
        return response()->json(UserResource::make(
            auth()->user()
        ));
    }

    /**
     * @return JsonResponse
     *
     * @OA\Get  (
     *  path="/api/auth/logout",
     *  summary="Logout",
     *  description="Logout",
     *     @OA\Response(
     *     response=200,
     *     description="Logged out",
     *     ),
     *     @OA\Response(
     *     response=500,
     *     description="Server error",
     *     ),
     * ),
     */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Logged out',
        ]);
    }

    /**
     * @throws Exception
     */
    public function refresh(RefreshTokenRequest $request): JsonResponse
    {
        return response()->json(TokenResource::make(
            $this->authService->refresh($request->refresh_token)
        ));
    }
}
