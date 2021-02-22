<?php

namespace EG\Ecommerce\Services\Products;

use EG\Ecommerce\Models\Product;
use EG\Ecommerce\Repositories\Interfaces\ProductAttributeInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductVariationInterface;

class StoreAttributesOfProductService
{
    protected $productAttributeRepository;

    protected $productVariationRepository;

    public function __construct(
        ProductAttributeInterface $productAttributeRepository,
        ProductVariationInterface $productVariationRepository
    )
    {
        $this->productAttributeRepository = $productAttributeRepository;
        $this->productVariationRepository = $productVariationRepository;
    }

    public function execute(Product $product, array $attributeSets)
    {
        $product->productAttributeSets()->sync($attributeSets);

        $attributes = $this->productAttributeRepository->getModel()
            ->whereIn('attribute_set_id', $attributeSets)
            ->pluck('id')
            ->all();

        $product->productAttributes()->sync($this->getSelectedAttributes($product, $attributes));

        $this->productVariationRepository->correctVariationItems($product->id, $attributes);

        return $product;
    }


    protected function getSelectedAttributes(Product $product, array $attributes)
    {
        $attributeSets = $product->productAttributeSets()
            ->select('attribute_set_id')
            ->pluck('attribute_set_id')
            ->toArray();

        $allRelatedAttributeBySet = $this->productAttributeRepository
            ->allBy([
                ['attribute_set_id', 'IN', $attributeSets],
            ], [], ['id'])
            ->pluck('id')
            ->toArray();

        $newAttributes = [];

        foreach ($attributes as $item) {
            if (in_array($item, $allRelatedAttributeBySet)) {
                $newAttributes[] = $item;
            }
        }

        return $newAttributes;
    }
}
