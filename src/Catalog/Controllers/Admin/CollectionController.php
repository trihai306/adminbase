<?php

namespace Modules\Catalog\Controllers\Admin;

use Modules\Catalog\Repositories\CollectionRepository;
use Modules\Catalog\Requests\Admin\IndexCollectionRequest;
use Modules\Catalog\Requests\Admin\StoreCollectionRequest;
use Modules\Catalog\Requests\Admin\UpdateCollectionRequest;
use Modules\Catalog\Transformers\CollectionCollection;
use Modules\Catalog\Transformers\CollectionResource;
use Modules\Core\Controllers\Controller;

class CollectionController extends Controller
{
    private $collectionRepository;

    public function __construct(CollectionRepository $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    public function index(IndexCollectionRequest $request)
    {
        $collections = $this->collectionRepository->query(
            $request->validated()
        );

        return new CollectionCollection($collections);
    }

    public function store(StoreCollectionRequest $request)
    {
        $collection = $this->collectionRepository->create(
            $request->validated()
        );

        $collection = $this->collectionRepository->query([
            'id' => $collection->id
        ]);

        return new CollectionResource($collection);
    }

    public function show($id)
    {
        $collection = $this->collectionRepository->find($id) ?? $this->collectionRepository->findByCode($id);

        $collections = $this->collectionRepository->query([
            'id' => $collection->id
        ]);

        return new CollectionResource($collections);
    }

    public function update($id, UpdateCollectionRequest $request)
    {
        $collection = $this->collectionRepository->find($id);

        $this->collectionRepository->update(
            $request->validated(),
            $collection->id
        );

        $collection = $this->collectionRepository->query([
            'id' => $collection->id
        ]);

        return new CollectionResource($collection);
    }

    public function destroy($id)
    {
        $collection = $this->collectionRepository->find($id);

        $this->collectionRepository->delete($collection->id);

        return $this->respondSuccess('Xóa bộ sưu tập thành công.');
    }
}
