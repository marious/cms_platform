<?php
namespace EG\Ecommerce\Services\Products;

use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Ecommerce\Models\Product;
use EG\Ecommerce\Repositories\Interfaces\ProductInterface;
use Illuminate\Http\Request;

class StoreProductService
{
    protected $productRepository;

    public function __construct(ProductInterface $product)
    {
        $this->productRepository = $product;
    }

    public function execute(Request $request, Product $product, bool $forceUpdateAll = false)
    {
        // Solve foreign key problem if given is 0
        if ($request->input('brand_id') == 0) {
            $request->merge(['brand_id' => null]);
        }

        $data = $request->input();


        $hasVariation = $product->variations()->count() > 0;


        if ($hasVariation && !$forceUpdateAll) {
            $data = $request->except([
                'images',
                'sku',
                'quantity',
                'allow_checkout_when_out_of_stock',
                'with_storehouse_management',
                'sale_type',
                'price',
                'sale_price',
                'start_date',
                'end_date',
                'length',
                'wide',
                'height',
                'weight',
                'barcode',
                'length_unit',
                'wide_unit',
                'height_unit',
                'weight_unit',
            ]);
        }

        $product->fillMultiLang($data);

        if (!$hasVariation || $forceUpdateAll) {
            $product->images = json_encode(array_values(array_filter($request->input('images', []))));

            if ($product->sale_price > $product->price) {
                $product->sale_price = null;
            }

            if ($product->sale_type == 0) {
                $product->start_date = null;
                $product->end_date = null;
            }
        }


        /**
         * @var Product $product
         */
        $product = $this->productRepository->createOrUpdate($product);

        if (!$product->id) {
            event(new CreatedContentEvent(PRODUCT_MODULE_SCREEN_NAME, $request, $product));
        } else {
            event(new UpdatedContentEvent(PRODUCT_MODULE_SCREEN_NAME, $request, $product));
        }

        if ($product) {
            if ($request->has('categories')) {
                $product->categories()->sync($request->input('categories', []));
            }

            if ($request->has('product_collections')) {
                $product->productCollections()->detach();
                $product->productCollections()->attach($request->input('product_collections', []));
            }

            if ($request->has('related_products')) {
                $product->products()->detach();
                $product->products()->attach(array_filter(explode(',', $request->input('related_products', ''))));
            }

            if ($request->has('cross_sale_products')) {
                $product->crossSales()->detach();
                $product->crossSales()->attach(array_filter(explode(',', $request->input('cross_sale_products', ''))));
            }

            if ($request->has('up_sale_products')) {
                $product->upSales()->detach();
                $product->upSales()->attach(array_filter(explode(',', $request->input('up_sale_products', ''))));
            }
        }

        return $product;
    }
}
