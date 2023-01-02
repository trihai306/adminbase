<?php

namespace Modules\Payment\Requests\Shop;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Modules\Core\Rules\MobileCardCode;
use Modules\Core\Rules\MobileCardSerial;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Bank;
use Modules\Payment\Entities\Card;
use Modules\Payment\Entities\CardExchange;
use Modules\Payment\Entities\Ewallet;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Enums\PaymentMethodType;
use Modules\Payment\Enums\PaymentType;

class StorePaymentRequest extends FormRequest
{
    public function rules(): array
    {
        $type = $this->input('type');

        $rules = [
            'type' => [
                'required',
                new EnumValue(PaymentType::class)
            ],
            'order_id' => [
                new RequiredIf($type === PaymentType::ORDER),
                new Exists(Order::class)
            ],
            'method_id' => [
                'required',
                new Exists(PaymentMethod::class, 'id')
            ],
        ];

        $method = PaymentMethod::find($this->input('method_id'));
        switch ($method->type->value) {
            case PaymentMethodType::BANK_TRANSFER;
                $rules = array_merge($rules, $this->bankTransferRules($method));
            break;
            case PaymentMethodType::EWALLET_TRANSFER;
                $rules = array_merge($rules, $this->ewalletTransferRules($method));
                break;
            case PaymentMethodType::CARD;
                $rules = array_merge($rules, $this->cardExchangeRules($method));
                break;
            default:
        }

        return $rules;
    }

    protected function bankTransferRules($method)
    {
        return [
            'amount' => [
                'required',
                'integer',
                'min:0'
            ],
            'bank_id' => [
                'required',
                (new Exists(Bank::class, 'id'))
                    ->where('payment_method_id', $method->id)
            ],
        ];
    }

    protected function ewalletTransferRules($method)
    {
        return [
            'amount' => [
                'required',
                'integer',
                'min:0'
            ],
            'ewallet_id' => [
                'required',
                (new Exists(Ewallet::class, 'id'))
                    ->where('payment_method_id', $method->id)
            ],
        ];
    }

    public function cardExchangeRules($method)
    {
        return [
            'cards' => ['required', 'array'],
            'cards.*.id' => [
                'required',
                (new Exists(Card::class, 'id'))
                    ->where('payment_method_id', $method->id)
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
