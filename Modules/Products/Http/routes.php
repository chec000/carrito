<?php

Route::group(['middleware' => ['web', 'checksession'], 'prefix' => 'products', 'namespace' => 'Modules\Products\Http\Controllers'], function()
{
      Route::get('/', 'ProductsController@index');
       Route::get('productList/{order?}','ProductsController@getDataProducts');    
       Route::get('productOrder/{order?}','ProductsController@getDataProductsOrder');
       Route::get('benefits/{id}/{order?}','ProductsController@filterProductsByBenefits');
       Route::get('category/{id}/{order?}','ProductsController@filterProductByCategory');
       Route::get('category','ProductsController@filterProductByCategory');
       Route::get('search/{name}','ProductsController@searchProducts');
       Route::get('order/{order}','ProductsController@getDataProducts');
       Route::get('starProducts','ProductsController@getDataProducts');
       Route::get('orderByAsc','ProductsController@getDataProducts');
       Route::get('orderByDes','ProductsController@getDataProducts');
       Route::get('productDetail/{id_product?}/{product_home?}','ProductsController@getProductById');
       Route::get('product','ProductsController@detailProduct');
      Route::get('productsHome','ProductsController@getProductsHome');
      Route::get('categories','ProductsController@getCategories');
      Route::get('productsByCategory','ProductsController@getAllproductsByCategory');
      Route::get("productsCategory/{id}",'ProductsController@getProductsByCategoryId');
      Route::get("getGlobalWharehouse",'ProductsController@getGlobalWharehouse');
      Route::get('productsByCategory','ProductsController@getAllproductsByCategory');
      Route::get('searchAllProducts','ProductsController@allProducts');
      Route::get('searchProducts','ProductsController@searchProductsByParms');
      Route::get('productsBenefit/{id}', 'ProductsController@getProductsByBenefitId');
      Route::get('products-Benefits', 'ProductsController@filterProductsByBenefitsId');
      Route::get('detailProduct/{id}/{product_home?}', 'ProductsController@getProductByIdProduct');

     });
