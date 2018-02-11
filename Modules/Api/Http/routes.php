<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'api', 'namespace' => 'Modules\Api\Http\Controllers'], function()
{
    Route::get('/', 'ApiController@index');
    Route::post('sessionProductsCart', 'ApiController@sessionProductsCart');
    Route::get('getSessionProductsCart', 'ApiController@getSessionProductsCart');
    Route::post('login', 'ApiController@login');
    Route::get('getSessionLogin', 'ApiController@getSessionLogin');
    Route::get('logout', 'ApiController@logout');
    Route::post('mergeSessionProductsCart', 'ApiController@mergeSessionProductsCart');
    Route::get('getSessionPromotions', 'ApiController@getSessionPromotions');
    Route::post('deleteSessionPromotions', 'ApiController@deleteSessionPromotions');
    Route::post('setSessionPromotions', 'ApiController@setSessionPromotions');
    Route::post('updateZip', 'ApiController@updateZip');
    Route::post('updateLocation', 'ApiController@updateLocation');
    Route::post('zipChanged', 'ApiController@zipChanged');
    Route::post('getSessionVariables', 'ApiController@getSessionVariables');
    Route::post('getTranslate', 'ApiController@getTranslate');
});
