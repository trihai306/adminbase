<?php

namespace Modules\Catalog\Controllers\Shop;

use Modules\Catalog\Repositories\CollectionRepository;
use Modules\Catalog\Requests\Shop\IndexCollectionRequest;
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

    public function show($id)
    {
        if (is_numeric($id)) {
            $collection = $this->collectionRepository->find($id) ?? $this->collectionRepository->findByCode($id);
        } else {
            $collection = $this->collectionRepository->findByCode($id);
        }

        $collections = $this->collectionRepository->query([
            'id' => $collection->id
        ]);

        return new CollectionResource($collections);
    }
}
