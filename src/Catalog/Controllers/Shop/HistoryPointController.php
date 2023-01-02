<?php

namespace Modules\Catalog\Controllers\Shop;


use Modules\Catalog\Repositories\HistoryPointRepository;
use Modules\Catalog\Requests\Admin\IndexProductRequest;
use Modules\Catalog\Transformers\HistoryPointCollection;
use Modules\Catalog\Transformers\HistoryPointResource;
use Modules\Core\Controllers\Controller;
use Modules\User\Services\AuthenticationService;

class HistoryPointController extends Controller
{
    private $historyPointRepository;
    private $authenticationService;

    public function __construct(
        HistoryPointRepository $historyPointRepository,

        AuthenticationService $authenticationService
    )
    {
        $this->historyPointRepository = $historyPointRepository;

        $this->authenticationService = $authenticationService;
    }

    public function index(IndexProductRequest $request)
    {
        $data = $request->validated();

        $data[] = ['user_id'=>$this->authenticationService->currentUser()->id];

        $voucher = $this->historyPointRepository->query(
            $data
        );
        return new HistoryPointCollection($voucher);
    }

    public function show($id)
    {
        $voucher = $this->historyPointRepository->query(compact('id'));
        return new HistoryPointResource($voucher);
    }
}
