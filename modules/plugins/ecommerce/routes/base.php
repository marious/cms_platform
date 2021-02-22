<?php

Route::group(['namespace' => 'EG\Ecommerce\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix() . '/ecommerce', 'middleware' => 'auth'], function () {

        Route::get('settings', [
            'as'   => 'ecommerce.settings',
            'uses' => 'EcommerceController@getSettings',
        ]);

        Route::post('settings', [
            'as'         => 'ecommerce.settings.post',
            'uses'       => 'EcommerceController@postSettings',
            'permission' => 'ecommerce.settings',
        ]);

        Route::get('ajax/countries', [
            'as'   => 'ajax.countries.list',
            'uses' => 'EcommerceController@ajaxGetCountries',
        ]);

        Route::get('store-locators/form/{id?}', [
            'as'         => 'ecommerce.store-locators.form',
            'uses'       => 'EcommerceController@getStoreLocatorForm',
            'permission' => 'ecommerce.settings',
        ]);

        Route::post('store-locators/edit/{id}', [
            'as'         => 'ecommerce.store-locators.edit.post',
            'uses'       => 'EcommerceController@postUpdateStoreLocator',
            'permission' => 'ecommerce.settings',
        ]);

        Route::post('store-locators/create', [
            'as'         => 'ecommerce.store-locators.create',
            'uses'       => 'EcommerceController@postCreateStoreLocator',
            'permission' => 'ecommerce.settings',
        ]);

        Route::post('store-locators/delete/{id}', [
            'as'         => 'ecommerce.store-locators.destroy',
            'uses'       => 'EcommerceController@postDeleteStoreLocator',
            'permission' => 'ecommerce.settings',
        ]);

        Route::post('store-locators/update-primary-store', [
            'as'         => 'ecommerce.store-locators.update-primary-store',
            'uses'       => 'EcommerceController@postUpdatePrimaryStore',
            'permission' => 'ecommerce.settings',
        ]);


        Route::group(['prefix' => 'product-categories', 'as' => 'product-categories.'], function () {
            Route::resource('', 'ProductCategoryController')
                ->parameters(['' => 'product_category']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ProductCategoryController@deletes',
                'permission' => 'product-categories.destroy',
            ]);
        });

        Route::group(['prefix' => 'product-tags', 'as' => 'product-tag.'], function () {
            Route::resource('', 'ProductTagController')
                ->parameters(['' => 'product-tag']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ProductTagController@deletes',
                'permission' => 'product-tag.destroy',
            ]);

            Route::get('all', [
                'as'         => 'all',
                'uses'       => 'ProductTagController@getAllTags',
                'permission' => 'product-tag.index',
            ]);
        });


        Route::group(['prefix' => 'product-attribute-sets', 'as' => 'product-attribute-sets.'], function () {
            Route::resource('', 'ProductAttributeSetsController')
                ->parameters(['' => 'product_attribute_set']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ProductAttributeSetsController@deletes',
                'permission' => 'product-attribute-sets.destroy',
            ]);
        });



        Route::group(['prefix' => 'brands', 'as' => 'brands.'], function () {
            Route::resource('', 'BrandController')
                ->parameters(['' => 'brand']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'BrandController@deletes',
                'permission' => 'brands.destroy',
            ]);
        });

        Route::group(['prefix' => 'product-collections', 'as' => 'product-collections.'], function () {
            Route::resource('', 'ProductCollectionController')
                ->parameters(['' => 'product-collection']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ProductCollectionController@deletes',
                'permission' => 'product-collections.destroy',
            ]);

            Route::get('get-list-product-collections-for-select', [
                'as'         => 'get-list-product-collections-for-select',
                'uses'       => 'ProductCollectionController@getListForSelect',
                'permission' => 'product-collections.index',
            ]);
        });


    });

});
