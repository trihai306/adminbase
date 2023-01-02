<?php

namespace Modules\Order\Requests\Shop;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Modules\Core\Rules\MobileCardCode;
use Modules\Core\Rules\MobileCardSerial;
use Modules\Payment\Entities\Bank;
use Modules\Payment\Entities\Card;
use Modules\Payment\Entities\CardExchange;
use Modules\Payment\Entities\Ewallet;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Enums\PaymentMethodType;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {
        $paymentMethodId = $this->input('payment_method_id');
        $paymentMethod = PaymentMethod::find($paymentMethodId);

        $rules = [
            'cart_id' => 'required',
            'item_ids' => [
                'required',
                'array'
            ],
            'payment_method_id' => [
                'required',
                new Exists(PaymentMethod::class, 'id')
            ]
        ];

        switch ($paymentMethod->type) {
            case PaymentMethodType::BANK_TRANSFER:
                return array_merge($rules, $this->bankTransferRules($paymentMethod));
            case PaymentMethodType::EWALLET_TRANSFER;
                return array_merge($rules, $this->ewalletTransferRules($paymentMethod));
            case PaymentMethodType::CARD:
                return array_merge($rules, $this->cardExchangeRules($paymentMethod));
            default:
                return $rules;
        }
    }

    protected function bankTransferRules($paymentMethod): array
    {
        return [
            'bank_id' => [
                'required',
                (new Exists(Bank::class, 'id'))
                    ->where('payment_method_id', $paymentMethod->id)
            ],
        ];
    }

    protected function ewalletTransferRules($paymentMethod)
    {
        return [
            'ewallet_id' => [
                'required',
                (new Exists(Ewallet::class, 'id'))
                    ->where('payment_method_id', $paymentMethod->id)
            ],
        ];
    }

    protected function cardExchangeRules($paymentMethod): array
    {
        return [
            'cards' => ['required', 'array'],
            'cards.*.id' => [
                'required',
                (new Exists(Card::class, 'id'))
                    ->where('payment_method_id', $paymentMethod->id)
            ],
            'cards.*.serial' => [
                'required',
                new MobileCardSerial(),
                new Unique(CardExchange::class, 'serial')
            ],
            'cards.*.code' => [
                'required',
                new MobileCardCode(),
                new Unique(CardExchange::class, 'code')
            ],
            'cards.*.value' => [
                'required',
                'integer',
                'min:0'
            ]
        ];
    }
}
