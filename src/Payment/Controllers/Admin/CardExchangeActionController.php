<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Enums\CardExchangeStatus;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Requests\Admin\DenyCardExchangeRequest;
use Modules\Payment\Requests\Admin\IndexCardExchangeRequest;
use Modules\Payment\Services\CardExchangeService;
use Modules\Payment\Transformers\CardExchangeCollection;
use Modules\Payment\Transformers\CardExchangeResource;

class CardExchangeActionController extends Controller
{
    private $cardExchangeRepository;
    private $cardExchangeService;

    public function __construct(
        CardExchangeRepository $cardExchangeRepository,
        CardExchangeService $cardExchangeService
    )
    {
        $this->cardExchangeRepository = $cardExchangeRepository;
        $this->cardExchangeService = $cardExchangeService;
    }

    public function send($cardExchangeId)
    {
        $cardExchange = $this->cardExchangeRepository->find($cardExchangeId);

        $this->cardExchangeService->send($cardExchange);

        return $this->respondSuccess('Gửi thẻ thành công.');
    }

    public function accept($cardExchangeId)
    {
        $cardExchange = $this->cardExchangeRepository->find($cardExchangeId);

        $this->cardExchangeService->accept($cardExchange);

        return $this->respondSuccess('Chấp nhận thẻ thành công.');
    }

    public function deny($cardExchangeId, DenyCardExchangeRequest $request)
    {
        $cardExchange = $this->cardExchangeRepository->find($cardExchangeId);

        $this->cardExchangeService->deny($cardExchange, $request->input('feedback'));

        return $this->respondSuccess('Từ chối thẻ thành công.');
    }
}
