<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => ['auth:admin', 'permission']], function () {
    
    Route::redirect('', '/admin/index');
    Route::any('refresh', ['uses' => 'IndexController@refresh']);

    Route::get('index', ['uses'=>'IndexController@index', 'as'=>'admin.index.index']);
    Route::get('table', ['uses'=>'IndexController@table', 'as'=>'admin.index.table']);
    Route::get('form', ['uses'=>'IndexController@form', 'as'=>'admin.index.form']);
    Route::get('ajax', ['uses'=>'IndexController@ajax', 'as'=>'admin.index.ajax']);

    Route::post('upload', ['uses'=>'IndexController@upload', 'as'=>'admin.index.upload']);

    Route::resource('menu', 'MenusController', ['except'=>'show'])->names('admin.menu');
    Route::resource('permission', 'PermissionsController', ['except'=>'show'])->names('admin.permission');

    Route::get('role/{id}/permission', ['uses'=>'RolesController@permission', 'as'=>'admin.role.permission']);
    Route::resource('role', 'RolesController', ['except'=>'show'])->names('admin.role');

    Route::get('admin_user/{id}/role', ['uses'=>'AdminUsersController@role', 'as'=>'admin.admin_user.role']);
    Route::get('admin_user/{id}/permission', ['uses'=>'AdminUsersController@permission', 'as'=>'admin.admin_user.permission']);
    Route::resource('admin_user', 'AdminUsersController')->names('admin.admin_user');

    Route::resource('keywords_type', 'KeywordsTypeController', ['except'=>'show'])->names('admin.keywords_type');

    Route::resource('keywords', 'KeywordsController', ['except'=>'show'])->names('admin.keywords');
});

Route::get('login', ['uses'=>'AuthController@showLoginForm', 'as'=>'admin.login', 'middleware'=>['guest:admin']]);
Route::post('login', ['uses'=>'AuthController@login', 'as'=>'admin.doLogin']);

Route::post('profile', ['uses'=>'AuthController@profile', 'as'=>'admin.profile', 'middleware'=>['auth:admin']]);
Route::get('logout', ['uses'=>'AuthController@logout', 'as'=>'admin.logout', 'middleware'=>['auth:admin']]);
