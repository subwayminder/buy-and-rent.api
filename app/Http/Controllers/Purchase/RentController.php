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

class RentController extends Controller
{
    public function __construct(private readonly RentService $rentService)
    {
    }
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

    public function store(int $productId, RentRequest $request): JsonResponse
    {
        /** @var Authenticatable|User $user */
        $user = auth()->user();
        $rent = $this->rentService->rent($user, Product::find($productId), $request->rent_hours);
        return response()->json(
            RentResource::make($rent)
        );
    }

    public function update(string $rentId, RentExtendRequest $request): JsonResponse
    {
        $rent = $this->rentService->extendRent($rentId, $request->rent_hours);
        return response()->json(
            RentResource::make($rent)
        );
    }
}
