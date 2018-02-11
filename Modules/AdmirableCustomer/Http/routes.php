<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'admirablecustomer', 'namespace' => 'Modules\AdmirableCustomer\Http\Controllers'], function()
{
    Route::get('/', 'AdmirableCustomerController@index');
});
