<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
*/

// Route::get('/', ['uses' => 'IndexController@index', 'middleware' => 'auth:admin']);

Route::group(['middleware' => ['auth:admin', 'permission']], function () {
    
    Route::redirect('', '/admin/index');

    Route::get('index', ['uses'=>'IndexController@index', 'as'=>'admin.index.index']);
    Route::get('table', ['uses'=>'IndexController@table', 'as'=>'admin.index.table']);
    Route::get('form', ['uses'=>'IndexController@form', 'as'=>'admin.index.form']);
    Route::get('ajax', ['uses'=>'IndexController@ajax', 'as'=>'admin.index.ajax']);

    Route::post('form_upload', ['uses'=>'IndexController@formUpload', 'as'=>'admin.index.form_upload']);

    Route::resource('menu', 'MenusController', ['except'=>'show'])->names('admin.menu');
    Route::resource('permission', 'PermissionsController', ['except'=>'show'])->names('admin.permission');

    Route::get('role/{id}/permission', ['uses'=>'RolesController@permission', 'as'=>'admin.role.permission']);
    Route::resource('role', 'RolesController', ['except'=>'show'])->names('admin.role');

    Route::get('user/{id}/role', ['uses'=>'UsersController@role', 'as'=>'admin.user.role']);
    Route::get('user/{id}/permission', ['uses'=>'UsersController@permission', 'as'=>'admin.user.permission']);
    Route::get('user/{id}/menu', ['uses'=>'UsersController@menu', 'as'=>'admin.user.menu']);
    Route::resource('user', 'UsersController')->names('admin.user');

    Route::resource('keywords_type', 'KeywordsTypeController', ['except'=>'show'])->names('admin.keywords_type');

    Route::resource('keywords', 'KeywordsController', ['except'=>'show'])->names('admin.keywords');
});

Route::get('login', ['uses'=>'AuthController@showLoginForm', 'as'=>'admin.login', 'middleware'=>['guest:admin']]);
Route::post('login', ['uses'=>'AuthController@login', 'as'=>'admin.doLogin']);

Route::post('profile', ['uses'=>'AuthController@profile', 'as'=>'admin.profile', 'middleware'=>['auth:admin']]);
Route::get('logout', ['uses'=>'AuthController@logout', 'as'=>'admin.logout', 'middleware'=>['auth:admin']]);
