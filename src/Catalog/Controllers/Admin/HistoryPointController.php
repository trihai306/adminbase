<?php

namespace Modules\Catalog\Controllers\Admin;



use Modules\Catalog\Repositories\HistoryPointRepository;
use Modules\Catalog\Requests\Admin\IndexProductRequest;
use Modules\Catalog\Transformers\HistoryPointCollection;
use Modules\Catalog\Transformers\HistoryPointResource;
use Modules\Core\Controllers\Controller;

class HistoryPointController extends Controller
{
    private $historyPointRepository;

    public function __construct(
        HistoryPointRepository $historyPointRepository
    )
    {
        $this->historyPointRepository = $historyPointRepository;

    }

    public function index(IndexProductRequest $request)
    {
        $voucher = $this->historyPointRepository->query(
            $request->validated()
        );

        return new HistoryPointCollection($voucher);
    }


    public function show($id)
    {
        $voucher = $this->historyPointRepository->query(compact('id'));
        return new HistoryPointResource($voucher);
    }



}
