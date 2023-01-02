<?php

namespace Modules\Payment\Requests\Callback;

use Illuminate\Foundation\Http\FormRequest;

class CardExchangeCallbackRequest extends FormRequest
{
    public function rules()
    {
        return [
            'Pin' => 'required',
            'Seri' => 'required',
            'CardValue' => [
                'required',
                'integer'
            ],
            'requestid' => 'required',
            'Hash' => 'required',
        ];
    }
}
