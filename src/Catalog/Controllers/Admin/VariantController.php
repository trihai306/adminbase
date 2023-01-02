<?php

namespace Modules\Catalog\Controllers\Admin;

use Modules\Catalog\Repositories\VariantRepository;
use Modules\Catalog\Requests\Admin\IndexVariantRequest;
use Modules\Catalog\Requests\Admin\StoreProductRequest;
use Modules\Catalog\Requests\Admin\StoreVariantRequest;
use Modules\Catalog\Requests\Admin\UpdateVariantRequest;
use Modules\Catalog\Transformers\VariantCollection;
use Modules\Catalog\Transformers\VariantResource;
use Modules\Core\Controllers\Controller;

class VariantController extends Controller
{
    private $variantRepository;

    public function __construct(VariantRepository $variantRepository)
    {
        $this->variantRepository = $variantRepository;
    }

    public function index(IndexVariantRequest $request)
    {
        $variants = $this->variantRepository->query(
            $request->validated()
        );

        return new VariantCollection($variants);
    }

    public function store(StoreVariantRequest $request)
    {
        $variant = $this->variantRepository->create(
            $request->validated()
        );

        $variant = $this->variantRepository->query([
            'id' => $variant->id
        ]);

        return new VariantResource($variant);
    }

    public function show($id)
    {
        $variant = $this->variantRepository->query([
            'id' => $id
        ]);

        return new VariantResource($variant);
    }

    public function update($id, UpdateVariantRequest $request)
    {
        $variant = $this->variantRepository->find($id);

        $this->variantRepository->update(
            $request->validated(),
            $variant->id
        );

        $variant = $this->variantRepository->query([
            'id' => $variant->id
        ]);

        return new VariantResource($variant);
    }

    public function destroy($id)
    {
        $variant = $this->variantRepository->find($id);

        $this->variantRepository->delete($variant->id);

        return $this->respondSuccess('Xóa biến thể thành công.');
    }
}
