<?php

Route::group(['middleware' => 'web', 'prefix' => 'orders', 'namespace' => 'Modules\Orders\Http\Controllers'], function()
{
    Route::get('/', 'OrdersController@index');
    Route::get('/getDataOrdersByEoNumber', 'OrdersController@getDataOrdersByEoNumber');
    Route::get('/getDataOrderWithDetail/{order_id}','OrdersController@getDataOrderWithDetail');
});
