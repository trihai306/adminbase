<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Requests\Admin\IndexCardExchangeRequest;
use Modules\Payment\Transformers\CardExchangeCollection;

class CardExchangeController extends Controller
{
    private $cardExchangeRepository;

    public function __construct(CardExchangeRepository $cardExchangeRepository)
    {
        $this->cardExchangeRepository = $cardExchangeRepository;
    }

    public function index(IndexCardExchangeRequest $request)
    {
        $cardExchanges = $this->cardExchangeRepository->query(
            $request->validated()
        );

        return new CardExchangeCollection($cardExchanges);
    }
}
