<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'backoffice', 'namespace' => 'Modules\BackOffice\Http\Controllers'], function()
{
    Route::get('/', 'BackOfficeController@index');
});
