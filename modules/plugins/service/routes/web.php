<?php

Route::group(['namespace' => 'EG\Service\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'services', 'as' => 'service.'], function () {
            Route::resource('', 'ServiceController')->parameters(['' => 'service']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'ServiceController@deletes',
                'permission' => 'service.destroy',
            ]);
        });

        Route::group(['prefix' => 'business-solutions', 'as' => 'business-solutions.'], function () {
            Route::resource('', 'BusinessSolutionsController')->parameters(['' => 'business-solutions']);
            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'BusinessSolutionsController@deletes',
                'permission' => 'BusinessSolutions.destroy',
            ]);
        });
    });

    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        // Route::get('/business-solutions/{slug}', [
        //     'uses' => 'PublicController@getBySlug',
        // ]);
        Route::get('/business-solutions/{slug}', [
            'uses' => 'PublicController@getServiceBySlug',
        ]);
    });

});
