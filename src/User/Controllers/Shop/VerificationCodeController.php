<?php

namespace Modules\User\Controllers\Shop;

use Modules\Core\Controllers\Controller;
use Modules\User\Events\NewVerificationCode;
use Modules\User\Requests\Shop\StoreVerificationCodeRequest;
use Modules\User\Services\OTPGenerator;
use ParagonIE\ConstantTime\Base32;

class VerificationCodeController extends Controller
{
    private $OTPGenerator;

    public function __construct(OTPGenerator $OTPGenerator)
    {
        $this->OTPGenerator = $OTPGenerator;
    }

    public function store(StoreVerificationCodeRequest $request)
    {
        $email = $request->input('email');
        $action = $request->input('action');
        $domain = $request->input('domain');
        $identifier = Base32::encodeUpper("$email|$action");

        $code = $this->OTPGenerator->generate($identifier, [
            'digits' => 6,
            'period' => 600
        ]);

        NewVerificationCode::dispatch($code, $email, $action, $domain);

        return $this->respondSuccess('Tạo mã xác thực thành công.');
    }
}
