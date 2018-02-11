<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'inscription', 'namespace' => 'Modules\Inscription\Http\Controllers'], function()
{
    Route::get('/register', 'InscriptionController@index');
    Route::get('pdf/', 'InscriptionController@pdf_generator');
    Route::get('/test', 'InscriptionController@test');
    Route::post('/save-form', 'InscriptionController@saveFormReg');
    Route::post('selected-kit', 'InscriptionController@selectedKit');
    Route::get('/getCountries', 'InscriptionController@getCountries');
    Route::get('/getStates', 'InscriptionController@getStates');
    Route::get('/getSecurityQuestions', 'InscriptionController@getSecurityQuestions');
    Route::get('/getKits', 'InscriptionController@getKits');
    Route::get('/getSponsor', 'InscriptionController@getSponsor');
    Route::get('/getFederalEntities', 'InscriptionController@getFederalEntities');
    Route::get('/getShipCompany', 'InscriptionController@getShipCompany');
    Route::get('/getCounty', 'InscriptionController@getCounty');
});
