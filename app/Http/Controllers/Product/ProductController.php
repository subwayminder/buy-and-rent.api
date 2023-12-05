<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    /**
     * @param ProductIndexRequest $request
     * @return JsonResponse
     *
     * @OA\Get  (
     *  path="/api/products",
     *  summary="Products list",
     *  description="Products list",
     * @OA\Response(
     *     response=200,
     *     description="Products list",
     *      @OA\JsonContent (
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/ProductResource")
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
     *  requestBody={"$ref": "#/components/requestBodies/ProductIndexRequest"}
     * ),
     */
    public function index(ProductIndexRequest $request): JsonResponse
    {
        $data = $this->productService->getList(
            limit: $request->limit ?: 10
        );
        return response()->json(
            ProductCollection::make($data)
        );
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json(
            ProductResource::make($product)
        );
    }
}
