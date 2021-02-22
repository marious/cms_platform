<?php

namespace EG\Ecommerce\Models;

use EG\ACL\Models\User;
use EG\Base\Enums\BaseStatusEnum;
use EG\Base\Models\BaseModel;
use EG\Base\Traits\EnumCastable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\JoinClause;
use Exception;
use Illuminate\Support\Arr;
use Spatie\Translatable\HasTranslations;

class Product extends BaseModel
{
    use EnumCastable, HasTranslations;

    protected $table = 'ec_products';

    protected $fillable = [
        'name',
        'description',
        'content',
        'status',
        'images',
        'sku',
        'order',
        'quantity',
        'allow_checkout_when_out_of_stock',
        'with_storehouse_management',
        'is_featured',
        'options',
        'brand_id',
        'is_variation',
        'is_searchable',
        'is_show_on_list',
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
        'tax_id',
        'status',
        'views',
    ];

    public $translatable = ['name', 'description', 'content'];

    protected $appends = [
        'original_price',
        'front_sale_price',
    ];

    protected $casts = [
        'status'    => BaseStatusEnum::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'ec_product_category_product',
            'product_id',
            'category_id',
        );
    }

    public function productAttributeSets(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAttributeSet::class,
            'ec_product_with_attribute_set',
            'product_id',
            'attribute_set_id'
        );
    }


    public function productAttributes(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductAttribute::class,
            'ec_product_with_attribute',
            'product_id',
            'attribute_id',
        );
    }

    public function productCollections(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductCollection::class,
            'ec_product_collection_products',
            'product_id',
            'product_collection_id',
        );
    }

    public function groupedProduct(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'ec_grouped_products',
            'parent_product_id',
            'product_id',
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductTag::class,
            'ec_product_tag_product',
            'product_id',
            'tag_id',
        );
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }


    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class, 'ec_product_related_relations', 'from_product_id', 'to_product_id')
            ->where('is_variation', 0);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'configurable_product_id');
    }

    public function discounts(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'ec_discount_products', 'product_id', 'discount_id');
    }

    public function variationAttributeSwatchesForProductList(): HasMany
    {
        return $this->hasMany(ProductVariation::class, 'configurable_product_id')
            ->join('ec_product_variation_items', 'ec_product_variation_items.variation_id', '=',
                'ec_product_variations.id')
            ->join('ec_product_attributes', 'ec_product_attributes.id', '=', 'ec_product_variation_items.attribute_id')
            ->join('ec_product_attribute_sets', 'ec_product_attribute_sets.id', '=',
                'ec_product_attributes.attribute_set_id')
            ->where('ec_product_attribute_sets.status', BaseStatusEnum::PUBLISHED)
            ->where('ec_product_attribute_sets.is_use_in_product_listing', 1);
    }

    public function variationInfo(): HasOne
    {
        return $this->hasOne(ProductVariation::class, 'product_id')->withDefault();
    }

    public function defaultVariation(): HasOne
    {
        return $this
            ->hasOne(ProductVariation::class, 'configurable_product_id')
            ->where('ec_product_variations.is_default', 1)
            ->withDefault();
    }

    public function defaultProductAttributes(): BelongsToMany
    {
        return $this
            ->belongsToMany(ProductAttribute::class, 'ec_product_with_attribute', 'product_id', 'attribute_id')
            ->join(
                'ec_product_variation_items',
                'ec_product_variation_items.attribute_id',
                '=',
                'ec_product_with_attribute.attribute_id'
            )
            ->join('ec_product_variations', function ($join) {
                /**
                 * @var JoinClause $join
                 */
                return $join->on('ec_product_variations.id', '=', 'ec_product_variation_items.variation_id')
                    ->where('ec_product_variations.is_default', 1);
            })
            ->distinct();
    }

    public function groupedItems(): HasMany
    {
        return $this->hasMany(GroupedProduct::class, 'parent_product_id');
    }

    public function getImagesAttribute($value)
    {
        try {
            if ($value === '[null]') {
                return [];
            }

            return json_decode($value) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }

    public function getImageAttribute()
    {
        return Arr::first($this->images) ?? null;
    }


    public function getOptionsAttribute($value)
    {
        try {
            return json_decode($value, true) ?: [];
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * get sale price of product, if not exist return false
     * @return float
     */

    public function getFrontSalePriceAttribute()
    {
        $promotion = $this->promotions->first();

        if ($promotion) {
            $price = $this->price;
            switch ($promotion->type_option) {
                case 'same-price':
                    $price = $promotion->value;
                    break;
                case 'amount':
                    $price = $price - $promotion->value;
                    if ($price < 0) {
                        $price = 0;
                    }
                    break;
                case 'percentage':
                    $price = $price - ($price * $promotion->value / 100);
                    if ($price < 0) {
                        $price = 0;
                    }
                    break;
            }
            return $this->getComparePrice($price, $this->sale_price);
        }

        return $this->getComparePrice($this->price, $this->sale_price);
    }

    protected function getComparePrice($price, $salePrice)
    {
        if ($salePrice && $price > $salePrice) {
            if ($this->sale_type == 0) {
                return $salePrice;
            }

            if ((!empty($this->start_date) && $this->start_date > now()) ||
                (!empty($this->end_date && $this->end_date < now()))) {
                return $price;
            }

            return $salePrice;
        }

        return $price;
    }




    public function getOriginalPriceAttribute()
    {
        return $this->front_sale_price ?? $this->price ?? 0;
    }

    public function attributesForProductList(): BelongsToMany
    {
        return $this
            ->belongsToMany(ProductAttribute::class, 'ec_product_with_attribute', 'product_id', 'attribute_id')
            ->join('ec_product_attribute_sets', 'ec_product_attribute_sets.id', '=',
                'ec_product_attributes.attribute_set_id')
            ->where('ec_product_attribute_sets.status', BaseStatusEnum::PUBLISHED)
            ->where('ec_product_attribute_sets.is_use_in_product_listing', 1)
            ->select([
                'ec_product_attributes.*',
                'ec_product_attribute_sets.title as product_attribute_set_title',
                'ec_product_attribute_sets.slug as product_attribute_set_slug',
                'ec_product_attribute_sets.order as product_attribute_set_order',
                'ec_product_attribute_sets.display_layout as product_attribute_set_display_layout',
            ]);
    }

    public function isOutOfStock()
    {
        if (!$this->with_storehouse_management) {
            return false;
        }

        return $this->quantity <= 0 && !$this->allow_checkout_when_out_of_stock;
    }


    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class, 'tax_id')->withDefault();
    }


    public function crossSales(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'ec_product_cross_sale_relations','from_product_id','to_product_id');
    }

    public function upSales(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'ec_product_up_sale_relations','from_product_id','to_product_id');
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Discount::class, 'ec_discount_products', 'product_id')
            ->where('type', 'promotion')
            ->where('start_date', '<=', now())
            ->leftJoin('ec_discount_product_collections', 'ec_discounts.id', '=',
                'ec_discount_product_collections.discount_id')
            ->leftJoin('ec_discount_customers', 'ec_discounts.id', '=', 'ec_discount_customers.discount_id')
            ->where(function ($query) {
                /**
                 * @var Builder $query
                 */
                return $query
                    ->where(function ($sub) {
                        /**
                         * @var Builder $sub
                         */
                        return $sub
                            ->where(function ($subSub) {
                                /**
                                 * @var Builder $subSub
                                 */
                                return $subSub
                                    ->where('target', 'specific-product')
                                    ->orWhere('target', 'product-variant');
                            })
                            ->where('ec_discount_products.product_id', $this->id);
                    })
                    ->orWhere(function ($sub) {
                        $collections = $this->productCollections->pluck('ec_product_collections.id')->all();
                        /**
                         * @var Builder $sub
                         */
                        return $sub
                            ->where('target', 'group-products')
                            ->whereIn('ec_discount_product_collections.product_collection_id', $collections);
                    })
                    ->orWhere(function ($sub) {
                        $customerId = auth('customer')->check() ? auth('customer')->user()->id : -1;

                        /**
                         * @var Builder $sub
                         */
                        return $sub
                            ->where('target', 'customer')
                            ->where('ec_discount_customers.customer_id', $customerId);
                    });
            })
            ->where(function ($query) {
                /**
                 * @var Builder $query
                 */
                return $query
                    ->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->where('product_quantity', 1);
    }


    protected static function boot()
    {
        parent::boot();
        self::deleting(function (Product $product) {
            $variation = ProductVariation::where('product_id', $product->id)->first();
            if ($variation) {
                $variation->delete();
            }
            $productVariations = ProductVariation::where('configurable_product_id', $product->id)->get();
            foreach ($productVariations as $productVariation) {
                $productVariation->delete();
            }

            $product->categories()->detach();
            $product->productAttributeSets()->detach();
            $product->productAttributes()->detach();
            $product->productCollections()->detach();
            $product->discounts()->detach();
            $product->crossSales()->detach();
            $product->upSales()->detach();
            $product->groupedProduct()->detach();

            Review::where('product_id', $product->id)->delete();
        });
    }
}
