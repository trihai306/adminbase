<?php

namespace Modules\Payment\Requests\Shop;

use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Validation\Rules\Unique;
use Modules\Core\Requests\FormRequest;
use Modules\Core\Rules\MobileCardCode;
use Modules\Core\Rules\MobileCardSerial;
use Modules\Media\Enums\MediaType;
use Modules\Media\Rules\MediaFile;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Bank;
use Modules\Payment\Entities\Card;
use Modules\Payment\Entities\CardExchange;
use Modules\Payment\Entities\Ewallet;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Enums\PaymentMethodType;
use Modules\Payment\Enums\PaymentType;

class UpdateBankTransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bill' => new MediaFile(MediaType::IMAGE)
        ];
    }
}
