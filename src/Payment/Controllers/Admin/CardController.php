<?php

namespace Modules\Payment\Controllers\Admin;

use Modules\Core\Controllers\Controller;
use Modules\Payment\Repositories\CardRepository;
use Modules\Payment\Requests\Admin\IndexCardRequest;
use Modules\Payment\Requests\Admin\StoreCardRequest;
use Modules\Payment\Requests\Admin\UpdateCardRequest;
use Modules\Payment\Transformers\CardCollection;
use Modules\Payment\Transformers\CardResource;

class CardController extends Controller
{
    private $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function index(IndexCardRequest $request)
    {
        $cards = $this->cardRepository->query($request->validated());

        return new CardCollection($cards);
    }

    public function store(StoreCardRequest $request)
    {
        $card = $this->cardRepository->create($request->validated());

        $card = $this->cardRepository->query([
            'id' => $card->id
        ]);

        return new CardResource($card);
    }

    public function update($id, UpdateCardRequest $request)
    {
        $card = $this->cardRepository->update($request->validated(), $id);

        $card = $this->cardRepository->query([
            'id' => $card->id
        ]);

        return new CardResource($card);
    }

    public function destroy($id)
    {
        $card = $this->cardRepository->find($id);

        $this->cardRepository->delete($card->id);

        return $this->respondSuccess('Xóa thẻ thành công.');
    }
}
