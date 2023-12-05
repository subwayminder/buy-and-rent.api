<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\RentExtendRequest;
use App\Http\Requests\Purchase\RentIndexRequest;
use App\Http\Requests\Purchase\RentRequest;
use App\Http\Resources\Purchase\RentCollection;
use App\Http\Resources\Purchase\RentResource;
use App\Models\Product;
use App\Models\User;
use App\Services\Purchase\RentService;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class RentController extends Controller
{
    public function __construct(private readonly RentService $rentService)
    {
    }

    /**
     * @param RentIndexRequest $request
     * @return JsonResponse
     *
     * @OA\Get  (
     *  path="/api/rent",
     *  summary="Rent get list",
     *  description="Rent get list",
     * @OA\Response(
     *     response=200,
     *     description="Rent get list",
     *      @OA\JsonContent (
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/RentResource")
     *      )
     * ),
     * @OA\Response(
     *     response=404,
     *     description="Not found",
     *     ),
     * @OA\Response(
     *     response=422,
     *     description="Invalid data",
     *     ),
     * @OA\Response(
     *     response=500,
     *     description="Server error",
     *     ),
     *  requestBody={"$ref": "#/components/requestBodies/RentIndexRequest"}
     * ),
     */
    public function index(RentIndexRequest $request): JsonResponse
    {
        $data = $this->rentService->getList(
            limit: $request->limit ?: 10,
            orderBy: 'end_rent',
            sortType: 'desc'
        );
        return response()->json(
            RentCollection::make($data)
        );
    }

    /**
     * @param int $productId
     * @param RentRequest $request
     * @return JsonResponse
     *
     * @OA\Post  (
     *  path="/api/{productId}/rent",
     *  summary="Rent product",
     *  description="Rent product",
     * @OA\Response(
     *     response=200,
     *     description="Rent product",
     *      @OA\JsonContent (
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/RentResource")
     *      )
     * ),
     * @OA\Response(
     *     response=404,
     *     description="Not found",
     *     ),
     * @OA\Response(
     *     response=422,
     *     description="Invalid data",
     *     ),
     * @OA\Response(
     *     response=500,
     *     description="Server error",
     *     ),
     *  requestBody={"$ref": "#/components/requestBodies/RentRequest"}
     * ),
     */
    public function store(int $productId, RentRequest $request): JsonResponse
    {
        /** @var Authenticatable|User $user */
        $user = auth()->user();
        $rent = $this->rentService->rent($user, Product::find($productId), $request->rent_hours);
        return response()->json(
            RentResource::make($rent)
        );
    }

    /**
     * @param string $rentId
     * @param RentExtendRequest $request
     * @return JsonResponse
     *
     * @OA\Put  (
     *  path="/api/rent/{rentId}",
     *  summary="Extend the rent",
     *  description="Extend the rent",
     * @OA\Response(
     *     response=200,
     *     description="Extend the rent",
     *      @OA\JsonContent (
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/RentResource")
     *      )
     * ),
     * @OA\Response(
     *     response=404,
     *     description="Not found",
     *     ),
     * @OA\Response(
     *     response=422,
     *     description="Invalid data",
     *     ),
     * @OA\Response(
     *     response=500,
     *     description="Server error",
     *   ),
     *  requestBody={"$ref": "#/components/requestBodies/RentRequest"}
     * ),
     */
    public function update(string $rentId, RentExtendRequest $request): JsonResponse
    {
        $rent = $this->rentService->extendRent($rentId, $request->rent_hours);
        return response()->json(
            RentResource::make($rent)
        );
    }
}
