<?php

Route::group(['namespace' => 'EG\Page\Http\Controllers', 'middleware' => ['web', 'core']], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

        Route::group(['prefix' => 'pages', 'as' => 'pages.'], function () {

            Route::resource('', 'PageController')->parameters(['' => 'page']);

            Route::delete('items/destroy', [
                'as'         => 'deletes',
                'uses'       => 'PageController@deletes',
                'permission' => 'pages.destroy',
            ]);
        });
    });



});
