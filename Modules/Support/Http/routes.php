<?php

Route::group(['middleware' => 'web', 'prefix' => 'support', 'namespace' => 'Modules\Support\Http\Controllers'], function()
{
    Route::get('/', 'SupportController@index');
    Route::get('/login', 'LoginController@index');
    Route::post('/logout', 'LoginController@logout')->name('logout');
    Route::post('/login', 'LoginController@login')->name('login');
//
//    Route::group(['middleware' => 'auth'], function() {

        Route::resource('product-category', 'ProdCategoryController');

        Route::resource('product-benefit', 'ProdBenefitController');
        Route::get('product-benefit/{id}/off', ['as'=>'support.prodbenefit.off','uses'=>'ProdBenefitController@off']);
        Route::get('/product-benefit/{id}/on', ['as'=>'support.prodbenefit.on','uses'=>'ProdBenefitController@on']);

        Route::resource('users', 'UsersController');
        Route::get('/users/{id}/off', ['as'=>'support.users.off','uses'=>'UsersController@off']);
        Route::get('/users/{id}/on', ['as'=>'support.users.on','uses'=>'UsersController@on']);

        Route::resource('states', 'StatesController');
        Route::get('/states/{id}/off', ['as'=>'support.states.off','uses'=>'StatesController@off']);
        Route::get('/states/{id}/on', ['as'=>'support.states.on','uses'=>'StatesController@on']);

        Route::resource('labels', 'LabelsController');
        Route::get('/labels/{id}/off', ['as'=>'support.labels.off','uses'=>'LabelsController@off']);
        Route::get('/labels/{id}/on', ['as'=>'support.labels.on','uses'=>'LabelsController@on']);

        Route::resource('ingredients', 'IngredientsController');
        Route::get('/ingredients/{id}/off', ['as'=>'support.ingredients.off','uses'=>'IngredientsController@off']);
        Route::get('/ingredients/{id}/on', ['as'=>'support.ingredients.on','uses'=>'IngredientsController@on']);

        Route::resource('products', 'ProductsController');
        Route::get('/products/{id}/off', ['as'=>'support.products.off','uses'=>'ProductsController@off']);
        Route::get('/products/{id}/on', ['as'=>'support.products.on','uses'=>'ProductsController@on']);
        Route::post('/products/uploadImage', ['as'=>'support.products.uploadImage','uses'=>'ProductsController@uploadImage']);
        Route::post('/products/actionExtras', ['as'=>'support.products.saveExtras','uses'=>'ProductsController@actionExtras']);
        //Warehouses v Products
        Route::resource('inventories', 'InventoryController');
        Route::get('/inventories/{id}/off', ['as'=>'support.inventories.off','uses'=>'InventoryController@off']);
        Route::get('/inventories/{id}/on', ['as'=>'support.inventories.on','uses'=>'InventoryController@on']);

        Route::resource('restrictions','RestrictionsController');
        Route::get('/restrictions/{id}/off', ['as'=>'support.restrictions.off','uses'=>'RestrictionsController@off']);
        Route::get('/restrictions/{id}/on', ['as'=>'support.restrictions.on','uses'=>'RestrictionsController@on']);


        Route::resource('permissions','PermissionsController');
        Route::get('/permissions/{id}/off', ['as'=>'support.permissions.off','uses'=>'PermissionsController@off']);
        Route::get('/permissions/{id}/on', ['as'=>'support.permissions.on','uses'=>'PermissionsController@on']);

        Route::resource('roles','RolesController');
        Route::get('/roles/{id}/off', ['as'=>'support.roles.off','uses'=>'RolesController@off']);
        Route::get('/roles/{id}/on', ['as'=>'support.roles.on','uses'=>'RolesController@on']);


        Route::resource('languages','LanguagesController');
        Route::get('/languages/{id}/off', ['as'=>'support.languages.off','uses'=>'LanguagesController@off']);
        Route::get('/languages/{id}/on', ['as'=>'support.languages.on','uses'=>'LanguagesController@on']);


        Route::resource('pools','PoolsController');
        Route::get('/pools/{id}/off', ['as'=>'support.languages.off','uses'=>'PoolsController@off']);
        Route::get('/pools/{id}/on', ['as'=>'support.languages.on','uses'=>'PoolsController@on']);
        Route::post('/pools/load', ['as'=>'support.languages.on','uses'=>'PoolsController@load']);

        Route::resource('countries','CountriesController');
        Route::get('/countries/{id}/off', ['as'=>'support.countries.off','uses'=>'CountriesController@off']);
        Route::get('/countries/{id}/on', ['as'=>'support.countries.on','uses'=>'CountriesController@on']);

        Route::resource('warehouses','WarehousesController');
        Route::get('/warehouses/{id}/off', ['as'=>'support.warehouses.off','uses'=>'WarehousesController@off']);
        Route::get('/warehouses/{id}/on', ['as'=>'support.warehouses.on','uses'=>'WarehousesController@on']);

        Route::resource('blacklists','BlacklistsController');
        Route::get('/blacklists/{id}/off', ['as'=>'support.blacklist.off','uses'=>'BlacklistsController@off']);
        Route::get('/blacklists/{id}/on', ['as'=>'support.blacklist.on','uses'=>'BlacklistsController@on']);

        Route::resource('categories','CategoriesController');
        Route::get('/categories/{id}/off', ['as'=>'support.categories.off','uses'=>'CategoriesController@off']);
        Route::get('/categories/{id}/on', ['as'=>'support.categories.on','uses'=>'CategoriesController@on']);


        Route::resource('securityquestions','SecurityQuestionsController');
        Route::get('/securityquestions/{id}/off', ['as'=>'support.securityquestions.off','uses'=>'SecurityQuestionsController@off']);
        Route::get('/securityquestions/{id}/on', ['as'=>'support.securityquestions.on','uses'=>'SecurityQuestionsController@on']);

        Route::resource('packages','PackagesController');
        Route::post('packages/{id}', 'PackagesController@update');
        Route::get('/packages/{id}/off', ['as'=>'support.packages.off','uses'=>'PackagesController@off']);
        Route::get('/packages/{id}/on', ['as'=>'support.packages.on','uses'=>'PackagesController@on']);


        Route::resource('banner', 'BannerController');
        Route::post('banner/{id}', 'BannerController@update');
        Route::get('/banner/{id}/off', ['as'=>'support.languages.off','uses'=>'BannerController@off']);
        Route::get('/banner/{id}/on', ['as'=>'support.languages.on','uses'=>'BannerController@on']);

        Route::resource('testimony', 'TestimonyController');
        Route::post('testimony/{id}', 'TestimonyController@update');
        Route::get('/testimony/{id}/off', ['as'=>'support.languages.off','uses'=>'TestimonyController@off']);
        Route::get('/testimony/{id}/on', ['as'=>'support.languages.on','uses'=>'TestimonyController@on']);


        Route::resource('orders','OrdersController');
        //Route::get('/orders/{id}/off', ['as'=>'support.orders.off','uses'=>'OrdersController@off']);
        Route::get('/orders/{id}/on', ['as'=>'support.orders.on','uses'=>'OrdersController@on']);
        Route::get('/orders/view/update/{id}','OrdersController@updateItem');
        Route::post('/orders/view/enviacostos','OrdersController@enviaCostos');
        Route::post('/orders/view/guardaorden','OrdersController@guardaOrden');
        Route::get('/orders/view/changestatus/{id}','OrdersController@actualizaEstado');
        Route::get('/orders/view/{id}','OrdersController@showOrderIndex');
        Route::get('/orders/view/list/{id}','OrdersController@showOrder');
        Route::post('/orders/view/delete/{id}','OrdersController@deleteItem');
        Route::get('/orders/view/logs/{id}','OrdersController@showOrderLogs');



//    });


 



});