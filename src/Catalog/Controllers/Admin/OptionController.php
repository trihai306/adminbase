<?php

namespace Modules\Catalog\Controllers\Admin;

use Modules\Catalog\Repositories\OptionRepository;
use Modules\Catalog\Requests\Admin\IndexOptionRequest;
use Modules\Catalog\Requests\Admin\StoreOptionRequest;
use Modules\Catalog\Requests\Admin\UpdateOptionRequest;
use Modules\Catalog\Transformers\OptionCollection;
use Modules\Catalog\Transformers\OptionResource;
use Modules\Core\Controllers\Controller;

class OptionController extends Controller
{
    private $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function index(IndexOptionRequest $request)
    {
        $options = $this->optionRepository->query(
            $request->validated()
        );

        return new OptionCollection($options);
    }

    public function store(StoreOptionRequest $request)
    {
        $option = $this->optionRepository->create(
            $request->validated()
        );

        $option = $this->optionRepository->query([
            'id' => $option->id
        ]);

        return new OptionResource($option);
    }

    public function update($id, UpdateOptionRequest $request)
    {
        $option = $this->optionRepository->find($id);

        $this->optionRepository->update(
            $request->validated(),
            $option->id
        );

        $option = $this->optionRepository->query([
            'id' => $option->id
        ]);

        return new OptionResource($option);
    }

    public function show($id)
    {
        $option = $this->optionRepository->query([
            'id' => $id
        ]);

        return new OptionResource($option);
    }

    public function destroy($id)
    {
        $option = $this->optionRepository->find($id);

        $this->optionRepository->delete($option->id);

        return $this->respondSuccess('Xóa lựa chọn thành công.');
    }
}
