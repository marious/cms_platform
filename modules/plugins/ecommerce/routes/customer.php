<?php

Route::group(['namespace' => 'EG\Ecommerce\Http\Controllers\Customers', 'middleware' => 'web', 'core'], function () {

    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

       Route::group(['prefix' => 'customers', 'as' => 'customer.'], function () {
           Route::resource('', 'CustomerController')->parameters(['' => 'customer']);

           Route::delete('items/destroy', [
               'as'         => 'deletes',
               'uses'       => 'CustomerController@deletes',
               'permission' => 'customer.destroy',
           ]);
       });

    });

});
