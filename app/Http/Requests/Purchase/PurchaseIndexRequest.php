<?php

namespace App\Http\Requests\Purchase;

use App\Http\Requests\PaginateRequest;
class PurchaseIndexRequest extends PaginateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return parent::rules();
    }
}
