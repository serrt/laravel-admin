<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'web'], function () {
    Route::get('city', ['uses'=>'Api\WebController@city', 'as' => 'api.web.city']);
    Route::post('upload', ['uses'=>'Api\WebController@upload', 'as' => 'api.web.upload']);
    Route::get('permission', ['uses'=>'Api\WebController@permission', 'as' => 'api.web.permission']);
    Route::get('menu', ['uses'=>'Api\WebController@menu', 'as' => 'api.web.menu']);
    Route::get('role', ['uses'=>'Api\WebController@role', 'as' => 'api.web.role']);
    Route::get('keywords_type', ['uses'=>'Api\WebController@keywordsType', 'as' => 'api.web.keywords_type']);
    Route::get('keywords', ['uses'=>'Api\WebController@keywords', 'as' => 'api.web.keywords']);

    Route::any('unique', ['uses'=>'Api\WebController@unique', 'as' => 'api.web.unique']);
});
