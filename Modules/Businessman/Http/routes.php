<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'businessman', 'namespace' => 'Modules\Businessman\Http\Controllers'], function()
{
    Route::get('/', 'BusinessmanController@index');
});
