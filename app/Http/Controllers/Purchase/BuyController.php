<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\BuyRequest;
use App\Http\Requests\Purchase\PurchaseIndexRequest;
use App\Http\Resources\Purchase\PurchaseCollection;
use App\Models\Product;
use App\Models\User;
use App\Services\Purchase\BuyService;
use Illuminate\Http\JsonResponse;

class BuyController extends Controller
{
    public function __construct(private readonly BuyService $buyService)
    {
    }

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

    public function show()
    {

    }

    public function store($productId, BuyRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $purchase = $this->buyService->buy($user, Product::find($productId));
        return response()->json($purchase);
    }
}
