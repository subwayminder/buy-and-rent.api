<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\TokenResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
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

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     *
     * @OA\Post  (
     *  path="/api/auth/login",
     *  summary="Login endpoint",
     *  description="Login endpoint",
     *     @OA\Response(
     *     response=200,
     *     description="Login endpoint",
     *       @OA\JsonContent (
     *       type="array",
     *        @OA\Items(
     *          ref="#/components/schemas/TokenResource"
     *        )
     *      )
     *     ),
     *     @OA\Response(
     *     response=422,
     *     description="Invalid data",
     *     ),
     *     @OA\Response(
     *     response=500,
     *     description="Server error",
     *     ),
     *  requestBody={"$ref": "#/components/requestBodies/LoginRequest"}
     * ),
     */
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

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     *
     * @OA\Post  (
     *  path="/api/auth/register",
     *  summary="Register endpoint",
     *  description="Register endpoint",
     *     @OA\Response(
     *     response=200,
     *     description="Register endpoint",
     *       @OA\JsonContent (
     *       type="array",
     *        @OA\Items(
     *          ref="#/components/schemas/TokenResource"
     *        )
     *      )
     *     ),
     *     @OA\Response(
     *     response=422,
     *     description="Invalid data",
     *     ),
     *     @OA\Response(
     *     response=500,
     *     description="Server error",
     *     ),
     *  requestBody={"$ref": "#/components/requestBodies/RegisterRequest"}
     * ),
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = UserDTO::from($request->toArray());
        $response = TokenResource::make(
            $this->authService->register($dto)
        );
        return response()->json($response);
    }

    /**
     * @return JsonResponse
     *
     * @OA\Get  (
     *  path="/api/auth/me",
     *  summary="Me resource",
     *  description="Me resource",
     *     @OA\Response(
     *     response=200,
     *     description="Me resource",
     *       @OA\JsonContent (
     *       type="array",
     *        @OA\Items(
     *          ref="#/components/schemas/UserResource"
     *        )
     *      )
     *     ),
     *     @OA\Response(
     *     response=500,
     *     description="Server error",
     *     ),
     * ),
     */
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
     *
     * @OA\Post  (
     *  path="/api/auth/refresh",
     *  summary="Refresh token",
     *  description="Refresh token",
     *     @OA\Response(
     *     response=200,
     *     description="Refresh token",
     *       @OA\JsonContent (
     *       type="array",
     *        @OA\Items(
     *          ref="#/components/schemas/TokenResource"
     *        )
     *      )
     *     ),
     *     @OA\Response(
     *     response=422,
     *     description="Invalid data",
     *     ),
     *     @OA\Response(
     *     response=500,
     *     description="Server error",
     *     ),
     *  requestBody={"$ref": "#/components/requestBodies/RefreshTokenRequest"}
     * ),
     */
    public function refresh(RefreshTokenRequest $request): JsonResponse
    {
        return response()->json(TokenResource::make(
            $this->authService->refresh($request->refresh_token)
        ));
    }

    /**
     * @return bool
     *
     * @OA\Get  (
     *  path="/api/auth/test_deposit",
     *  summary="Add 10000 to your balance",
     *  description="Add 10000 to your balance",
     *     @OA\Response(
     *      response=200,
     *      description="ok"
     *     ),
     *     @OA\Response(
     *      response=500,
     *      description="Server error",
     *     ),
     * ),
     */
    public function testDeposit(): bool
    {
        /** @var User $user */
        $user = auth()->user();
        $user->account_balance += 10000;
        $user->save();
        return true;
    }
}
