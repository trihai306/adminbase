<?php

namespace Modules\Payment\Requests\Admin;

use Illuminate\Validation\Rules\Exists;
use Modules\Core\Requests\FormRequest;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Enums\PaymentMethodType;

class StoreBankRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_method_id' => [
                'required',
                (new Exists(PaymentMethod::class, 'id'))
                    ->where('type', PaymentMethodType::BANK_TRANSFER)
            ],
            'name' => 'required',
            'image' => 'nullable',
            'account_name' => 'required',
            'account_number' => 'required',
            'branch' => 'required',
            'discount_rate' => [
                'required',
                'integer',
                'min:0',
                'max:100'
            ],
            'enabled' => [
                'required',
                'boolean'
            ],
        ];
    }
}
