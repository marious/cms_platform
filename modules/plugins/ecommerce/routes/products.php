<?php
Route::group(['namespace' => 'EG\Ecommerce\Http\Controllers', 'middleware' => 'web', 'core'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix() . '/ecommerce', 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'products', 'as' => 'products.'], function () {

            Route::resource('', 'ProductController')->parameters(['' => 'product']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ProductController@deletes',
                'permission' => 'posts.destroy',
            ]);

            Route::post('update-order-by', [
                'as'         => 'update-order-by',
                'uses'       => 'ProductController@postUpdateOrderby',
                'permission' => 'products.edit',
            ]);

            Route::get('get-list-product-for-search/{id?}', [
                'as'            => 'get-list-product-for-search',
                'uses'          => 'ProductController@getListProductForSearch',
                'permission'    => 'products.edit',
            ]);

            Route::get('get-related-box/{id?}', [
                'as'            => 'get-relations-boxes',
                'uses'          => 'ProductController@getRelationBoxes',
                'permission'    => 'products.edit',
            ]);

            Route::get('get-version-form/{id}', [
                'as'         => 'get-version-form',
                'uses'       => 'ProductController@getVersionForm',
                'permission' => 'products.edit',
            ]);

            Route::post('update-version/{id}', [
                'as'         => 'update-version',
                'uses'       => 'ProductController@postUpdateVersion',
                'permission' => 'products.edit',
            ]);

            Route::post('generate-all-version/{id}', [
                'as'         => 'generate-all-versions',
                'uses'       => 'ProductController@postGenerateAllVersions',
                'permission' => 'products.edit',
            ]);

            Route::post('store-related-attributes/{id}', [
                'as'         => 'store-related-attributes',
                'uses'       => 'ProductController@postStoreRelatedAttributes',
                'permission' => 'products.edit',
            ]);

            Route::post('add-version/{id}', [
                'as'         => 'add-version',
                'uses'       => 'ProductController@postAddVersion',
                'permission' => 'products.edit',
            ]);

            Route::post('delete-version/{id}', [
                'as'         => 'delete-version',
                'uses'       => 'ProductController@postDeleteVersion',
                'permission' => 'products.edit',
            ]);

        });

    });



});
