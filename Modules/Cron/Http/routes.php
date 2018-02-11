<?php

Route::group(['middleware' => 'web', 'prefix' => 'cron', 'namespace' => 'Modules\Cron\Http\Controllers'], function()
{
    Route::get('/', 'CronController@index');
    Route::get('/getOrderSuccess', 'CronController@getOrdersSuccess');
    Route::get('/testFunction', 'CronController@testFunction');
});
