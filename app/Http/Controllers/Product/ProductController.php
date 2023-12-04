<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

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
