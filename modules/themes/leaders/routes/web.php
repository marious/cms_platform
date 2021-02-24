<?php
Theme::routes();


Route::group(['namespace' => 'Theme\Leaders\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {

        Route::get('/',  'LeaderThemeController@getIndex')->name('public.index');

    });
});
