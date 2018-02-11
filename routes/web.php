<?php
 Route::get('select_country','IndexController@shopping');

  Route::post('saveCountry', 'IndexController@saveCountry');
  Route::post('saveZipSelected ','IndexController@saveZipSelected');
  Route::get('existZip ','IndexController@existZip');
  Route::get('/w', function () {
    return view('welcome');
  });

  Route::get('/menu', function () {
    return view('menu');
  });

  Route::get('send', 'MailController@send');

  Route::get('/home',array(
    'as'=>'home',
    'uses' =>'IndexController@redirectHome'
  ));
  Route::get('/',array(
    'as'=>'',
    'uses' =>'IndexController@indexHome'
  ));
