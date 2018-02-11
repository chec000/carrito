<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'checkout', 'namespace' => 'Modules\Checkout\Http\Controllers'], function()
{
    Route::get('/successProcess',array(
        'as'=>'successProcess',
        'uses' =>'CheckoutController@successProcess'
    ));
    Route::get('/rejectedCharge',array(
        'as'=>'rejectedCharge',
        'uses' =>'CheckoutController@rejectedCharge'
    ));
    Route::get('/yourOrders',array(
        'as'=>'yourOrders',
        'uses' =>'CheckoutController@yourOrders'
    ));
    Route::get('/checkout',array(
        'as'=>'checkout',
        'uses' =>'CheckoutController@index'
    ));
/*** Urls checkout ABC Direcciones***/
    Route::get('/getListAddressDist/{pais}', 'AbcAddressController@getListAddressDist');
    Route::get('/disabledAddress/{distId}/{folio}', 'AbcAddressController@disabledAddressDist');
    Route::get('/getShippComp/{pais}/{estado}/{ciudad}', 'AbcAddressController@getshippCompany');
    Route::get('/getStateZip/{zipCode}', 'AbcAddressController@getStateZip');
    Route::get('/getCatCitysZip/{zipCode}/{state}', 'AbcAddressController@getCatCitysZip');
    Route::get('/getCatCountysZip/{zipCode}/{state}/{city}', 'AbcAddressController@getCatCountysZip');
    Route::post('/addAddress', 'AbcAddressController@addAddressDist');
    Route::post('/updateSessionAddressShipp', 'AbcAddressController@updateSessionAddressShipp');
    Route::get('promotion/{type?}','PromotionsController@PromotionCombo');
    Route::get('promotionsBuild','PromotionsController@getPromotions');
    Route::get('getAddressShipSession','CheckoutController@getAddressShipSession');

    /*** Urls checkout Promotions ***/
    Route::get('/getProductsPromo', 'PromotionsController@getProductsPromo');
    //Register->checkout->paypal
    ;
    Route::get('/getSession', 'CheckoutController@getSession');
    Route::post('/acceptedItems', 'CheckoutController@acceptedItems');
    Route::get('/acceptedItems', 'CheckoutController@acceptedItems');
    Route::get('/updateAddress', 'CheckoutController@updateAddress');
    Route::get('/cancelOrderRejected', 'CheckoutController@cancelOrderRejected');
});
