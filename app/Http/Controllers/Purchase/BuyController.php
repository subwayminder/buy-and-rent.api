<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\BuyRequest;
use App\Http\Requests\Purchase\PurchaseIndexRequest;
use App\Http\Resources\Purchase\PurchaseCollection;
use App\Http\Resources\Purchase\PurchaseResource;
use App\Models\Product;
use App\Models\User;
use App\Services\Purchase\BuyService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class BuyController extends Controller
{
    public function __construct(private readonly BuyService $buyService)
    {
    }

    /**
     * @param PurchaseIndexRequest $request
     * @return JsonResponse
     *
     *
     * @OA\Get  (
     *  path="/api/purchases",
     *  summary="purchases get list",
     *  description="purchases get list",
     * @OA\Response(
     *     response=200,
     *     description="purchases get list",
     *      @OA\JsonContent (
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/PurchaseResource")
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
     *  requestBody={"$ref": "#/components/requestBodies/PurchaseIndexRequest"}
     * ),
     */
    public function index(PurchaseIndexRequest $request): JsonResponse
    {
        $data = $this->buyService->getList(
            limit: $request->limit ?: 10,
            userId: auth()->user()->getAuthIdentifier()
        );
        return response()->json(
            PurchaseCollection::make($data)
        );
    }

    /**
     * @param $productId
     * @param BuyRequest $request
     * @return JsonResponse
     *
     * @OA\Post  (
     *  path="/api/{productId}/buy",
     *  summary="Buy product",
     *  description="Buy product",
     * @OA\Response(
     *     response=200,
     *     description="Buy product",
     *      @OA\JsonContent (
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/PurchaseResource")
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
     *  requestBody={"$ref": "#/components/requestBodies/BuyRequest"}
     * ),
     */
    public function store($productId, BuyRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $purchase = $this->buyService->buy($user, Product::find($productId));
        return response()->json(PurchaseResource::make($purchase));
    }
}
