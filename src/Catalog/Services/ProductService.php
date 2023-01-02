<?php

namespace Modules\Catalog\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Catalog\Repositories\ProductRepository;
use Modules\Catalog\Repositories\VariantRepository;
use Modules\Core\Utils\DataUtil;

class ProductService
{
    private $productRepository;
    private $variantRepository;

    public function __construct(
        ProductRepository $productRepository,
        VariantRepository $variantRepository
    ) {
        $this->productRepository = $productRepository;
        $this->variantRepository = $variantRepository;
    }

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $product = $this->productRepository->create($attributes);

            if (isset($attributes['variants'])) {
                foreach ($attributes['variants'] as $variant) {
                    $this->variantRepository->create(array_merge($variant, [
                        'product_id' => $product->id
                    ]));
                }
            }

            if (isset($attributes['content'])) {
                Storage::put("content/$product->id", $attributes['content']);
            }

            return $product;
        });
    }

    public function update(array $attributes, $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $product = $this->productRepository->update($attributes, $id);

            if (isset($attributes['variants'])) {
                list ($newVariants, $existedVariants, $existedVariantIds) = DataUtil::analyseUpdated($attributes['variants']);

                $product->variants()->whereNotIn('id', $existedVariantIds)
                    ->delete();

                foreach ($newVariants as $variant) {
                    $this->variantRepository->create(array_merge($variant, [
                        'product_id' => $product->id
                    ]));
                }

                foreach ($existedVariants as $variant) {
                    $this->variantRepository->update($variant, $variant['id']);
                }
            }

            if (isset($attributes['content'])) {
                Storage::put("content/$product->id", $attributes['content']);
            }

            return $product;
        });
    }
}
