<?php

namespace Modules\Catalog\Controllers\Admin;

use Modules\Catalog\Repositories\AttributeRepository;
use Modules\Catalog\Requests\Admin\IndexAttributeRequest;
use Modules\Catalog\Requests\Admin\StoreAttributeRequest;
use Modules\Catalog\Requests\Admin\UpdateAttributeRequest;
use Modules\Catalog\Transformers\AttributeCollection;
use Modules\Catalog\Transformers\AttributeResource;
use Modules\Core\Controllers\Controller;

class AttributeController extends Controller
{
    private $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function index(IndexAttributeRequest $request)
    {
        $attributes = $this->attributeRepository->query(
            $request->validated()
        );

        return new AttributeCollection($attributes);
    }

    public function store(StoreAttributeRequest $request)
    {
        $attribute = $this->attributeRepository->create(
            $request->validated()
        );

        $attribute = $this->attributeRepository->query([
            'id' => $attribute->id
        ]);

        return new AttributeResource($attribute);
    }

    public function update($id, UpdateAttributeRequest $request)
    {
        $attribute = $this->attributeRepository->find($id);

        $this->attributeRepository->update(
            $request->validated(),
            $attribute->id
        );

        $attribute = $this->attributeRepository->query([
            'id' => $attribute->id
        ]);

        return new AttributeResource($attribute);
    }

    public function destroy($id)
    {
        $attribute = $this->attributeRepository->find($id);

        $this->attributeRepository->delete($attribute->id);

        return $this->respondSuccess('Xóa thuộc tính thành công.');
    }
}
