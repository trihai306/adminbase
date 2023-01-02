<?php

namespace Modules\Catalog\Controllers\Shop;

use Modules\Catalog\Repositories\VariantRepository;
use Modules\Catalog\Requests\Shop\IndexVariantRequest;
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

    public function show($id)
    {
        $variant = $this->variantRepository->find($id);

        return new VariantResource($variant);
    }
}
