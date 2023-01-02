<?php

namespace Modules\Catalog\Controllers\Admin;

use Modules\Catalog\Repositories\BrandRepository;
use Modules\Catalog\Requests\Admin\IndexBrandRequest;
use Modules\Catalog\Requests\Admin\StoreBrandRequest;
use Modules\Catalog\Transformers\BrandCollection;
use Modules\Catalog\Transformers\BrandResource;
use Modules\Core\Controllers\Controller;

class BrandController extends Controller
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index(IndexBrandRequest $request)
    {
        $brands = $this->brandRepository->query(
            $request->validated()
        );

        return new BrandCollection($brands);
    }

    public function store(StoreBrandRequest $request)
    {
        $brand = $this->brandRepository->create(
            $request->validated()
        );

        $brand = $this->brandRepository->query([
            'id' => $brand->id
        ]);

        return new BrandResource($brand);
    }

    public function show($id)
    {
        $brand = $this->brandRepository->query([
            'id' => $id
        ]);

        return new BrandResource($brand);
    }

    public function update($id, StoreBrandRequest $request)
    {
        $brand = $this->brandRepository->find($id);

        $this->brandRepository->update(
            $request->validated(),
            $brand->id
        );

        $brand = $this->brandRepository->query([
            'id' => $brand->id
        ]);

        return new BrandResource($brand);
    }

    public function destroy($id)
    {
        $brand = $this->brandRepository->find($id);

        $this->brandRepository->delete($brand->id);

        return $this->respondSuccess('Xóa thương hiệu thành công.');
    }
}
