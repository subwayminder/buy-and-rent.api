<?php

namespace App\Http\Requests\Purchase;

use App\Models\Rent;
use App\Models\User;
use App\Services\Purchase\Enum\RentRangeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

/**
 * @property-read int $rent_id
 * @property-read int $rent_hours
 */
class RentExtendRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge(['rent_id' => $this->route('rentId')]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'rent_id' => [
                'required',
                'uuid',
                Rule::exists(Rent::class, 'id')
            ],
            'rent_hours' => [
                'required',
                'integer',
                Rule::in(array_column(RentRangeEnum::cases(), 'value'))
            ]
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            /** @var User $user */
            $user = auth()->user();
            $rent = Rent::query()
                ->where('id', $this->rent_id)
                ->where('user_id', $user->id)
                ->first();
            if ($rent == null) {
                $validator->errors()
                    ->add('message', 'Rent not found');
            }
            $product = $rent?->product;
            if ($product?->rent_hour_price * $this->rent_hours > $user->account_balance) {
                $validator->errors()
                    ->add('message', 'There are insufficient funds in the account.');
            }
        });
    }
}
