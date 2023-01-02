<?php

namespace Modules\Payment\Requests\Callback;

use Illuminate\Foundation\Http\FormRequest;

class BankTransferCallbackRequest extends FormRequest
{
    public function rules()
    {
        return [
            'ref' => 'required',
            'date' => 'required',
            'content' => 'required',
            'amount' => [
                'required',
                'integer'
            ],
            'hash' => 'required'
        ];
    }
}
