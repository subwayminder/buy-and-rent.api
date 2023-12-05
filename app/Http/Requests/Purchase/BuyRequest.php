<?php

namespace App\Http\Requests\Purchase;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Rent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use OpenApi\Annotations as OA;

/**
 * @class BuyRequest
 * @property-read integer $product_id
 *
 * @OA\RequestBody (
 *     request = "BuyRequest",
 *     required = true,
 *     @OA\JsonContent (
 *         @OA\Property (
 *             property="product_id",
 *             type="integer",
 *             description="Product id"
 *         ),
 *     )
 * )
 */
class BuyRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge(['product_id' => $this->route('productId')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'integer',
                Rule::exists(Product::class, 'id')
            ]
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            /** @var User $user */
            $user = auth()->user();
            /** @var Product $product */
            $product = Product::find($this->product_id);
            $checkPurchase = Purchase::query()
                ->where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();
            $rentCount = Rent::query()
                ->where('product_id', $product->id)
                ->where('end_rent', '>=', Carbon::now()->toDateTimeString())
                ->count();
            if ($checkPurchase) {
                $validator->errors()
                    ->add('message', 'You already own this product, your buy code is - ' . $checkPurchase->id);
            }
            if ($product->buy_price > $user->account_balance) {
                $validator->errors()
                    ->add('message', 'There are insufficient funds in the account.');
            }
            if ($product->quantity - $rentCount <= 0) {
                $validator->errors()
                    ->add('message', 'This product is not available for now. Try later or pick another product.');
            }
        });
    }
}
