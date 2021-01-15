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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user/', "UserController@index");
Route::post('/user/register_old', "UserController@register_old");

Route::post('/user/register', "UserController@register");
Route::post('/user/register_ok', "UserController@register_ok");
Route::post('/user/login', "UserController@login");
Route::post('/user/info', "UserController@info");
Route::post('/user/password', "UserController@password");
Route::post('/user/info_get', "UserController@info_get");

Route::post('/card/', "CardController@index");
Route::post('/card/card_add', "CardController@card_add");
Route::post('/card/card_get', "CardController@card_get");

Route::post('/category/', "CategoryController@index");
Route::get('/category/categories_get', "CategoryController@categories_get");






