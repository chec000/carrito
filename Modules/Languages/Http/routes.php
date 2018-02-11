<?php

Route::group(['middleware' => ['web'], 'prefix' => 'languages', 'namespace' => 'Modules\Languages\Http\Controllers'], function()
{
    Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);
   Route::get('getLan', 'LanguageController@getLan');
});
