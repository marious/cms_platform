<?php

namespace EG\Ecommerce\Providers;

use EG\Base\Traits\LoadAndPublishTrait;
use EG\Ecommerce\Facades\EcommerceHelperFacade;
use EG\Ecommerce\Models\Brand;
use EG\Ecommerce\Models\Currency;
use EG\Ecommerce\Models\Customer;
use EG\Ecommerce\Models\GroupedProduct;
use EG\Ecommerce\Models\Product;
use EG\Ecommerce\Models\ProductAttribute;
use EG\Ecommerce\Models\ProductAttributeSet;
use EG\Ecommerce\Models\ProductCategory;
use EG\Ecommerce\Models\ProductCollection;
use EG\Ecommerce\Models\ProductTag;
use EG\Ecommerce\Models\ProductVariation;
use EG\Ecommerce\Models\ProductVariationItem;
use EG\Ecommerce\Models\Shipping;
use EG\Ecommerce\Models\ShippingRule;
use EG\Ecommerce\Models\ShippingRuleItem;
use EG\Ecommerce\Models\StoreLocator;
use EG\Ecommerce\Models\Tax;
use EG\Ecommerce\Repositories\Caches\BrandCacheDecorator;
use EG\Ecommerce\Repositories\Caches\CurrencyCacheDecorator;
use EG\Ecommerce\Repositories\Caches\CustomerCacheDecorator;
use EG\Ecommerce\Repositories\Caches\GroupedProductCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ProductAttributeCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ProductAttributeSetCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ProductCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ProductCategoryCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ProductCollectionCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ProductTagCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ProductVariationCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ProductVariationItemCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ShippingCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ShippingRuleCacheDecorator;
use EG\Ecommerce\Repositories\Caches\ShippingRuleItemCacheDecorator;
use EG\Ecommerce\Repositories\Caches\StoreLocatorCacheDecorator;
use EG\Ecommerce\Repositories\Caches\TaxCacheDecorator;
use EG\Ecommerce\Repositories\Eloquent\BrandRepository;
use EG\Ecommerce\Repositories\Eloquent\CurrencyRepository;
use EG\Ecommerce\Repositories\Eloquent\CustomerRepository;
use EG\Ecommerce\Repositories\Eloquent\GroupedProductRepository;
use EG\Ecommerce\Repositories\Eloquent\ProductAttributeRepository;
use EG\Ecommerce\Repositories\Eloquent\ProductAttributeSetRepository;
use EG\Ecommerce\Repositories\Eloquent\ProductCategoryRepository;
use EG\Ecommerce\Repositories\Eloquent\ProductCollectionRepository;
use EG\Ecommerce\Repositories\Eloquent\ProductRepository;
use EG\Ecommerce\Repositories\Eloquent\ProductTagRepository;
use EG\Ecommerce\Repositories\Eloquent\ProductVariationItemRepository;
use EG\Ecommerce\Repositories\Eloquent\ProductVariationRepository;
use EG\Ecommerce\Repositories\Eloquent\ShippingRepository;
use EG\Ecommerce\Repositories\Eloquent\ShippingRuleItemRepository;
use EG\Ecommerce\Repositories\Eloquent\ShippingRuleRepository;
use EG\Ecommerce\Repositories\Eloquent\StoreLocatorRepository;
use EG\Ecommerce\Repositories\Eloquent\TaxRepository;
use EG\Ecommerce\Repositories\Interfaces\BrandInterface;
use EG\Ecommerce\Repositories\Interfaces\CurrencyInterface;
use EG\Ecommerce\Repositories\Interfaces\CustomerInterface;
use EG\Ecommerce\Repositories\Interfaces\GroupedProductInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductAttributeInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductAttributeSetInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductCollectionInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductTagInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductVariationInterface;
use EG\Ecommerce\Repositories\Interfaces\ProductVariationItemInterface;
use EG\Ecommerce\Repositories\Interfaces\ShippingInterface;
use EG\Ecommerce\Repositories\Interfaces\ShippingRuleInterface;
use EG\Ecommerce\Repositories\Interfaces\ShippingRuleItemInterface;
use EG\Ecommerce\Repositories\Interfaces\StoreLocatorInterface;
use EG\Ecommerce\Repositories\Interfaces\TaxInterface;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use EG\Base\Supports\Helper;
use Event;
use Illuminate\Routing\Events\RouteMatched;
use Language;
use SlugHelper;
use SeoHelper;

class EcommerceServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        config([
            'auth.guards.customer'     => [
                'driver'   => 'session',
                'provider' => 'customers',
            ],
            'auth.providers.customers' => [
                'driver' => 'eloquent',
                'model'  => Customer::class,
            ],
            'auth.passwords.customers' => [
                'provider' => 'customers',
                'table'    => 'ec_customer_password_resets',
                'expire'   => 60,
            ],
        ]);

        $this->app->bind(ProductCategoryInterface::class, function () {
            return new ProductCategoryCacheDecorator(
                new ProductCategoryRepository(new ProductCategory)
            );
        });

        $this->app->bind(ProductTagInterface::class, function () {
            return new ProductTagCacheDecorator(
                new ProductTagRepository(new ProductTag)
            );
        });


        $this->app->bind(BrandInterface::class, function () {
            return new BrandCacheDecorator(
                new BrandRepository(new Brand)
            );
        });

        $this->app->bind(ProductCollectionInterface::class, function () {
            return new ProductCollectionCacheDecorator(
                new ProductCollectionRepository(new ProductCollection)
            );
        });

        $this->app->bind(CustomerInterface::class, function () {
            return new CustomerCacheDecorator(
                new CustomerRepository(new Customer)
            );
        });

        $this->app->bind(ProductAttributeSetInterface::class, function () {
            return new ProductAttributeSetCacheDecorator(
                new ProductAttributeSetRepository(new ProductAttributeSet),
                ECOMMERCE_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(ProductAttributeInterface::class, function () {
            return new ProductAttributeCacheDecorator(
                new ProductAttributeRepository(new ProductAttribute),
                ECOMMERCE_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(ProductInterface::class, function () {
            return new ProductCacheDecorator(
                new ProductRepository(new Product)
            );
        });


        $this->app->bind(ProductVariationInterface::class, function () {
            return new ProductVariationCacheDecorator(
                new ProductVariationRepository(new ProductVariation),
                ECOMMERCE_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(ProductVariationItemInterface::class, function () {
            return new ProductVariationItemCacheDecorator(
                new ProductVariationItemRepository(new ProductVariationItem),
                ECOMMERCE_GROUP_CACHE_KEY
            );
        });

        $this->app->bind(GroupedProductInterface::class, function () {
            return new GroupedProductCacheDecorator(
                new GroupedProductRepository(new GroupedProduct)
            );
        });


        $this->app->bind(TaxInterface::class, function () {
            return new TaxCacheDecorator(
                new TaxRepository(new Tax)
            );
        });

        $this->app->bind(CurrencyInterface::class, function () {
            return new CurrencyCacheDecorator(
                new CurrencyRepository(new Currency)
            );
        });

        $this->app->bind(StoreLocatorInterface::class, function () {
            return new StoreLocatorCacheDecorator(
                new StoreLocatorRepository(new StoreLocator)
            );
        });

        $this->app->bind(ShippingInterface::class, function () {
            return new ShippingCacheDecorator(
                new ShippingRepository(new Shipping)
            );
        });

        $this->app->bind(ShippingRuleInterface::class, function () {
            return new ShippingRuleCacheDecorator(
                new ShippingRuleRepository(new ShippingRule)
            );
        });

        $this->app->bind(ShippingRuleItemInterface::class, function () {
            return new ShippingRuleItemCacheDecorator(
                new ShippingRuleItemRepository(new ShippingRuleItem)
            );
        });


        Helper::autoload(__DIR__ . '/../../helpers');

        $loader = AliasLoader::getInstance();
        $loader->alias('EcommerceHelper', EcommerceHelperFacade::class);
    }

    public function boot()
    {
        SlugHelper::registerModule(Brand::class, 'Brands');
        SlugHelper::registerModule(ProductCollection::class, 'Product Collections');
        SlugHelper::registerModule(ProductCategory::class, 'Product Categories');
        SlugHelper::registerModule(ProductTag::class, 'Product Tags');
        SlugHelper::registerModule(Brand::class, 'brands');
        SlugHelper::registerModule(ProductCategory::class, 'product-categories');
        SlugHelper::registerModule(ProductTag::class, 'product-tags');
        SlugHelper::registerModule(ProductCollection::class, 'product-collections');


        $this->setNamespace('plugins/ecommerce')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadAndPublishTranslations()
            ->loadRoutes([
                'base',
                'products',
                'customer',
                'tax',
                'shipping',
            ])
            ->loadAndPublishViews()
            ->loadMigrations()
            ->publishAssets();


        Event::listen(RouteMatched::class, function () {



            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-ecommerce',
                'priority'    => 8,
                'parent_id'   => null,
                'name'        => 'plugins/ecommerce::ecommerce.name',
                'icon'        => 'fa fa-shopping-cart',
                'url'         => '',
                'permissions' => ['products.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-ecommerce.product',
                'priority'    => 4,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::products.name',
                'icon'        => 'fa fa-camera',
                'url'         => route('products.index'),
                'permissions' => ['products.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-product-categories',
                'priority'    => 5,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::product-categories.name',
                'icon'        => 'fa fa-archive',
                'url'         => route('product-categories.index'),
                'permissions' => ['product-categories.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-product-tag',
                'priority'    => 10,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::product-tag.name',
                'icon'        => 'fa fa-tag',
                'url'         => route('product-tag.index'),
                'permissions' => ['product-tag.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-product-attribute',
                'priority'    => 15,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::product-attributes.name',
                'icon'        => 'fas fa-glass-martini',
                'url'         => route('product-attribute-sets.index'),
                'permissions' => ['product-attribute-sets.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-brands',
                'priority'    => 20,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::brands.name',
                'icon'        => 'fa fa-registered',
                'url'         => route('brands.index'),
                'permissions' => ['brands.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-product-collections',
                'priority'    => 25,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::product-collections.name',
                'icon'        => 'fa fa-file-excel',
                'url'         => route('product-collections.index'),
                'permissions' => ['product-collections.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-ecommerce-shipping-provider',
                'priority'    => 30,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::shipping.shipping',
                'icon'        => 'fas fa-shipping-fast',
                'url'         => route('shipping_methods.index'),
                'permissions' => ['shipping_methods.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-ecommerce-customer',
                'priority'    => 35,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::customers.name',
                'icon'        => 'fa fa-users',
                'url'         => route('customer.index'),
                'permissions' => ['customer.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-ecommerce-tax',
                'priority'    => 40,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::tax.name',
                'icon'        => 'fas fa-money-bill',
                'url'         => route('tax.index'),
                'permissions' => ['tax.index'],
            ])
            ->registerItem([
                'id'          => 'cms-plugins-ecommerce.settings',
                'priority'    => 999,
                'parent_id'   => 'cms-plugins-ecommerce',
                'name'        => 'plugins/ecommerce::ecommerce.settings',
                'icon'        => 'fas fa-cogs',
                'url'         => route('ecommerce.settings'),
                'permissions' => ['ecommerce.settings'],
            ]);
        });

        $this->app->booted(function () {

            SeoHelper::registerModule([
                Brand::class,
                ProductCategory::class,
                ProductTag::class,
//                ProductCollection::class,
            ]);

        });
    }
}
