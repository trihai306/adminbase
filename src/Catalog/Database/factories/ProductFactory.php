<?php
namespace Modules\Catalog\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\Collection;
use Modules\Catalog\Entities\Option;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Variant;
use Modules\Catalog\Enums\Currency;
use Modules\Catalog\Enums\ProductStatus;

class ProductFactory extends Factory
{
    protected $model = \Modules\Catalog\Entities\Product::class;

    public function definition()
    {
        $name = $this->faker->unique()->sentence(
            $this->faker->numberBetween(3, 10)
        );

        return [
            'code' => null,
            'name' => $name,
            'image' => null,
            'images' => null,
            'category_id' => Category::inRandomOrder()->first()->id,
            'initial_sold_count' => $this->faker->numberBetween(0, 1000),
            'important_message' => $this->faker->sentence,
            'status' => $this->faker->randomElement(ProductStatus::getValues())
        ];
    }

    public function configure()
    {
        return parent::configure()->afterCreating(function (Product $product) {
            $categoryIds = Category::inRandomOrder()
                ->limit($this->faker->numberBetween(0, 5))
                ->pluck('id');

            $product->categories()->attach($categoryIds->toArray());

            $collectionIds = Collection::inRandomOrder()
                ->limit($this->faker->numberBetween(0, 5))
                ->pluck('id');

            $product->collections()->attach($collectionIds->toArray());

            $options = Option::with('values')
                ->inRandomOrder()
                ->limit($this->faker->numberBetween(0, 5))
                ->get();

            $product->options()->attach($options->pluck('id')->toArray());

            Variant::factory($this->faker->numberBetween(1, 5))
                ->afterCreating(function (Variant $variant) use ($options) {
                    $optionValueIds = $options->map(function ($option) {
                        return $option->values->random()->id;
                    });
                    $variant->optionValues()->attach($optionValueIds->toArray());
                })
                ->create(['product_id' => $product->id]);
        });
    }
}

