<?php

Route::group(['namespace' => 'EG\Blog\Http\Controllers', 'middleware' => ['web', 'core']], function () {

  Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

      Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
          Route::resource('', 'PostController')
              ->parameters(['' => 'post']);

          Route::delete('items/destroy', [
              'as'         => 'deletes',
              'uses'       => 'PostController@deletes',
              'permission' => 'posts.destroy',
          ]);

//          Route::get('widgets/recent-posts', [
//              'as'         => 'widget.recent-posts',
//              'uses'       => 'PostController@getWidgetRecentPosts',
//              'permission' => 'posts.index',
//          ]);
      });

      Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
         Route::resource('', 'CategoryController')->parameters(['' => 'category']);

         Route::delete('items/destroy', [
             'as'           => 'deletes',
             'uses'         => 'CategoryController@deletes',
             'permission'   => 'categories.index',
         ]);
      });

      Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
        Route::resource('', 'TagController')
            ->parameters(['' => 'tag']);

        Route::delete('items/destroy', [
          'as'         => 'deletes',
          'uses'       => 'TagController@deletes',
          'permission' => 'tags.destroy',
        ]);

        Route::get('all', [
          'as'         => 'all',
          'uses'       => 'TagController@getAllTags',
          'permission' => 'tags.index',
        ]);

      });

  });

});
