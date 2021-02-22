<?php

Route::group(['namespace' => 'EG\PluginManagement\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'plugins'], function () {
            Route::get('', [
                'as'   => 'plugins.index',
                'uses' => 'PluginManagementController@index',
            ]);

            Route::put('status', [
                'as'         => 'plugins.change.status',
                'uses'       => 'PluginManagementController@update',
                'permission' => 'plugins.index',
            ]);

            Route::delete('{plugin}', [
                'as'         => 'plugins.remove',
                'uses'       => 'PluginManagementController@destroy',
                'permission' => 'plugins.index',
            ]);
        });
    });
});
