<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'paypal', 'namespace' => 'Modules\Paypal\Http\Controllers'], function()
{
    Route::get('/', 'PaypalController@index');
    Route::get('/payment',array(
    	'as'=>'payment',
    	'uses' =>'PaypalController@postPayment'
    ));
    Route::get('/payment/status',array(
    	'as'=>'payment.status',
    	'uses' =>'PaypalController@getPaymentStatus'
    ));
    Route::get('/beforePayment',array(
    	'as'=>'beforePayment',
    	'uses' =>'PaypalController@beforePayment'
    ));
    Route::get('/afterPaymet',array(
    	'as'=>'afterPaymet',
    	'uses' =>'PaypalController@afterPaymet'
    ));

});
