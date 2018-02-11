<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'authentication', 'namespace' => 'Modules\Authentication\Http\Controllers'], function()
{
    Route::get('/', 'AuthenticationController@index');
    Route::get('resetPassword/{token?}', 'AuthenticationController@resetPassword');
    Route::post('validateEo', 'AuthenticationController@validateEo');
    Route::get('getSessionResetPassword', 'AuthenticationController@getSessionResetPassword');
    Route::get('deleteSessionResetPassword', 'AuthenticationController@deleteSessionResetPassword');
    Route::post('setSessionResetPassword', 'AuthenticationController@setSessionResetPassword');
    Route::post('resetPasswordEo', 'AuthenticationController@resetPasswordEo');
    Route::get('sendTokenEmail', 'AuthenticationController@sendTokenEmail');
});
