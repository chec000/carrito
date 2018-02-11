<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'payment', 'namespace' => 'Modules\Payment\Http\Controllers'], function()
{


});
