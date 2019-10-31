<?php

use Illuminate\Http\Request;


Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
Route::post('refresh', 'Api\AuthController@refresh');

Route::middleware('auth:api')->group(function () {

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::post('logout', 'Api\AuthController@logout');
});

Route::apiResource('products', 'Api\ProductController');

Route::group(['prefix' => 'products'], function (){
    Route::apiResource('{product}/reviews', 'Api\ReviewController');
});