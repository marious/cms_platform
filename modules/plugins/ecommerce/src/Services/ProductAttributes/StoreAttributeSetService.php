<?php
namespace EG\Ecommerce\Services\ProductAttributes;

use EG\Ecommerce\Models\ProductAttributeSet;
use EG\Ecommerce\Repositories\Interfaces\ProductAttributeInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductAttributeSetInterface;
use EG\Support\Http\Requests\Request;
use Illuminate\Support\Str;

class StoreAttributeSetService
{
    /**
     * @var ProductAttributeSetInterface
     */
    protected $productAttributeSetRepository;

    /**
     * @var ProductAttributeInterface
     */
    protected $productAttributeRepository;

    public function __construct(
        ProductAttributeSetInterface $productAttributeSet,
        ProductAttributeInterface $productAttribute
    ) {
        $this->productAttributeSetRepository = $productAttributeSet;
        $this->productAttributeRepository = $productAttribute;
    }

    public function execute(Request $request, ProductAttributeSet $productAttributeSet)
    {
        $data = $request->input();
        $productAttributeSet->fillMultiLang($data);
        $productAttributeSet = $this->productAttributeSetRepository->createOrUpdate($productAttributeSet);

        $attributes = json_decode($request->get('attributes', '[]'), true) ?: [];
        $deletedAttributes = json_decode($request->get('deleted_attributes', '[]'), true) ?: [];

        $this->deleteAttributes($productAttributeSet->id, $deletedAttributes);
        $this->storeAttributes($productAttributeSet->id, $attributes);

        return $productAttributeSet;
    }

    protected function deleteAttributes($productAttributeSetId, array $attributeIds)
    {
        foreach ($attributeIds as $id) {
            $this->productAttributeRepository
                ->deleteBy([
                    'id'               => $id,
                    'attribute_set_id' => $productAttributeSetId,
                ]);
        }
    }

    protected function storeAttributes($productAttributeSetId, array $attributes)
    {
        foreach ($attributes as $item) {
            if (isset($item['id'])) {
                $attribute = $this->productAttributeRepository->findById($item['id']);
                if (!$attribute) {
                    $item['attribute_set_id'] = $productAttributeSetId;
                    $item['slug'] = isset($item['title']['en']) ? Str::slug($item['title']['en']) : $item['title'][Langauge::getCurrentLocale()];
                    $this->productAttributeRepository->create($item);
                } else {
                    $attribute->fill($item);
                    $attribute->slug = $attribute->getTranslation('title', 'en') ? Str::slug($attribute->getTranslation('title', 'en')) :
                        Str::slug($attribute->title);
                    $this->productAttributeRepository->createOrUpdate($attribute);
                }
            }
        }
    }
}
