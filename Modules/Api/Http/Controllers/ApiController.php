<?php

namespace Modules\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Products\Entities\Cart;
use Modules\Products\Entities\ProductWharehouse;
use Modules\Api\Entities\ZipCode;
use Illuminate\Support\Facades\Session;
use App\UrlService;
use App\Utils;

class ApiController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Response
   */

  public function updateUserProductsCart(){
    $cart = new Cart;
    Cart::where('dist_id', session()->get('userId'))->delete();
    if(session()->has('sessionProductsCart'))
      $cart->insertProducts(session()->get('userId'), session()->get('sessionProductsCart'));
  }

  public function setSessionProductsCart($productsCart, $quantityProductsCart, $subTotalProductsCart){
    $sessionVariables = array();
    session()->put('sessionProductsCart', $productsCart);
    session()->put('quantityProductsCart', $quantityProductsCart);
    session()->put('subTotalProductsCart', $subTotalProductsCart);

    if(session()->has('userId'))
      $this->updateUserProductsCart();

    $sessionVariables["sessionProductsCart"] = session()->get('sessionProductsCart');
    $sessionVariables["quantityProductsCart"] = session()->get('quantityProductsCart');
    $sessionVariables["subTotalProductsCart"] = session()->get('subTotalProductsCart');
    return $sessionVariables;
  }

  public function sessionProductsCart(Request $request){
    if(session()->has('sessionProductsCart') && count($request['productsCart']) == 0){
      session()->forget('sessionProductsCart');
      session()->forget('quantityProductsCart');
      session()->forget('subTotalProductsCart');
      $this->updateUserProductsCart();
      return 'null';
    }
    else{
      if(!$request['isPromotion']){
        $products = array();
        $products = $this->deletePromotions($request['productsCart'], $request['quantityProductsCart'], $request['subTotalProductsCart']);
        $sessionVariables = $this->setSessionProductsCart($products['productsCart'], $products['quantityProductsCart'], $products['subTotalProductsCart']);
      }
      else
        $sessionVariables = $this->setSessionProductsCart($request['productsCart'], $request['quantityProductsCart'], $request['subTotalProductsCart']);
    }
    return $sessionVariables;
  }

  public function getSessionProductsCart()
  {
    //return session()->all();
    if(session()->has('sessionProductsCart'))
      self::validateProductsByWharehouse();
    if (session()->has("quantityProductsCart"))
      $sessionVariables["quantityProductsCart"] = session()->get("quantityProductsCart");
    else
      $sessionVariables["quantityProductsCart"] = 0;
    $sessionVariables["sessionProductsCart"] = (session()->has('sessionProductsCart')) ? session()->get('sessionProductsCart') : array();
    $sessionVariables["subTotalProductsCart"] = (session()->has('subTotalProductsCart')) ? session()->get('subTotalProductsCart') : 0;
    return $sessionVariables;
  }

  public function resetSessionProductsCart(){
    $cart = new Cart;
    $userProducts = $cart->getProducts(session()->get('userId'), session()->get('language.0.language_id'));

    if(count($userProducts["sessionProductsCart"]) > 0){
      if(session()->has('sessionProductsCart')){
        $merge = array();
        $merge["merge"] = true;
         $merge["userLoginProducts"] = $userProducts;
        return $merge;
      }
      else
        return $this->setSessionProductsCart($userProducts["sessionProductsCart"], $userProducts["quantityProductsCart"], $userProducts["subTotalProductsCart"]);
    }
    else{
      $this->updateUserProductsCart();
      return $this->getSessionProductsCart();
    }
  }

  public function login(Request $request) {
    $data_login = array(
      "metodo" => "loginEo",
      "params" => array(
        "eo" => $request['user'],
        "password" => $request['password'],
        "pais" => session()->get('country')
      ));
    $response_login = UrlService::webService($data_login);
    if($response_login != null){
      if($response_login["data"] != null){
        if(session()->has('sessionProductsCart'))
          self::removeKit();
        session()->put('userId', $request['user']);
        session()->put('userName', $response_login['data']['nombre']);
        session()->put('userDiscount', $response_login['data']['descuento']);
        session()->forget('sessionPromotionsCart');
        session()->forget('selected_kit');
        $response_login["responseSessionProductsCart"] = $this->resetSessionProductsCart();
      }
      else
        $response_login["error"] = trans('login.errors.'.$response_login["message"]);
    }
    else
      $response_login["error"] = trans('login.errors.service_down');

    return $response_login;
  }

  public function removeKit(){
    $products = session()->get('sessionProductsCart');
    foreach($products as $key => $product){
      if(!isset($product["is_kit"])){
        //die(var_dump($product));
        unset($products[$key]);
        session()->put('sessionProductsCart', $products);
        session()->put('quantityProductsCart', session()->get('quantityProductsCart') - 1);
        session()->put('subTotalProductsCart', session()->get('subTotalProductsCart') - $product["price"]);
      }
    }
    //die(var_dump($products));
    return $products;
  }

  public function getSessionLogin(){
    $sessionVaraibles = array();
    $sessionVariables["userName"] = session()->get('userName');
    $sessionVariables["userDiscount"] = session()->get('userDiscount');
    $sessionVariables["userId"] = session()->get('userId');
    return $sessionVariables;
  }

  public function logout(){

        session()->flush();
            $result = true;
    //return redirect('/');
      return compact('result');
  }

  public function mergeSessionProductsCart(Request $request){
    $userLoginProducts = $request["userLoginProducts"];
    $userSessionProducts = $this->getSessionProductsCart();

    switch ($request["opcion"]) {
    case 1:
      return $this->setSessionProductsCart($userSessionProducts["sessionProductsCart"], $userSessionProducts["quantityProductsCart"], $userSessionProducts["subTotalProductsCart"]);
      break;
    case 2:
      return $this->setSessionProductsCart($userLoginProducts["sessionProductsCart"], $userLoginProducts["quantityProductsCart"], $userLoginProducts["subTotalProductsCart"]);
      break;
    case 3:
      foreach ($userSessionProducts["sessionProductsCart"] as $key1 => $product) {
        $field1 = (isset($product["isCombo"])) ? "package_id" : "product_id";
        foreach ($userLoginProducts["sessionProductsCart"] as $key2 => $product2) {
          $field2 = (isset($product2["isCombo"])) ? "package_id" : "product_id";
          if($field1 == $field2){
            if($product[$field1] == $product2[$field2]){
              $userLoginProducts["sessionProductsCart"][$key2]["quantity"] += $product["quantity"];
              $userLoginProducts["sessionProductsCart"][$key2]["priceQuantity"] += $product["priceQuantity"];
              $userLoginProducts["subTotalProductsCart"] += $product["priceQuantity"];

              unset($userSessionProducts["sessionProductsCart"][$key1]);
            }
          }
        }
      }

      foreach ($userSessionProducts["sessionProductsCart"] as $product) {
        $userLoginProducts["quantityProductsCart"]++;
        $userLoginProducts["subTotalProductsCart"] += $product["priceQuantity"];
        array_push($userLoginProducts["sessionProductsCart"], $product);
      }
      return $this->setSessionProductsCart($userLoginProducts["sessionProductsCart"], $userLoginProducts["quantityProductsCart"], $userLoginProducts["subTotalProductsCart"]);
      break;
    }
  }

  public function deletePromotions($productsCart, $quantityProductsCart, $subTotalProductsCart){
    $products = array();
    foreach ($productsCart as $key => $product) {
      if(isset($product["isPromotion"])){
        $quantityProductsCart--;
        $subTotalProductsCart -= $product["priceQuantity"];
        unset($productsCart[$key]);
      }
    }
    $products['productsCart'] = $productsCart;
    $products['quantityProductsCart'] = $quantityProductsCart;
    $products['subTotalProductsCart'] = $subTotalProductsCart;
    session()->forget('sessionPromotionsCart');
    return $products;
  }

  public function deleteSessionPromotions(Request $request){
    $products = array();
    $products = $this->deletePromotions($request['productsCart'], $request['quantityProductsCart'], $request['subTotalProductsCart']);
    $sessionVariables = $this->setSessionProductsCart($products['productsCart'], $products['quantityProductsCart'], $products['subTotalProductsCart']);
  }

  public function setSessionPromotions(Request $request){
    session()->put('sessionPromotionsCart', $request["promotionsProducts"]);
    return (json_encode($request["promotionsProducts"]));
  }

  public function getSessionPromotions(){
    $defaultObject = (object) [
      "A" => (object) [
        "selected" => false
      ],
      "B" => (object) [
        "selected" => false
      ],
      "C" => (object) [
        "selected" => false
      ],
      "anySelected" => true,
    ];
    $sessionVariables = (session()->has('sessionPromotionsCart')) ? session()->get('sessionPromotionsCart') : $defaultObject;
    return response()->json($sessionVariables);
  }

  public function updateZip(Request $request){
    $zip = self::validateZip($request["zip_selected"]);
    session()->put('zip', $zip);
    $utils= new Utils();
    $utils->setSessionVariables($request);
///$utils-> setLanguage("USA");
    return json_encode($zip);
  }

  public function updateLocation(Request $request){
    $zip = self::validateZip($request["zip_selected"]);
    $utils = new Utils();
    $utils->setSessionVariables($request);
    return json_encode($zip);
  }

  public function validateZip($zip){
    $zipCode = new ZipCode;
    $validate = $zipCode->getZip($zip);
    return $validate;
  }

  public function getSessionVariables() {
    //session()->flush();
    //session()->forget("adressShippDist");
    return Session::all();
  }

  public function zipChanged(Request $request){
    $zipCode = new ZipCode;
    $zip = self::validateZip($request["zip_selected"]);
    if($zip != null){
      $result = array(
        "zip" => session()->get('zip')->zip
      );
      if(!$request["address"])
        $result["message"] = trans('messages.update_data.UPDATE_ZIP');
      else
        $result["message"] = trans('messages.update_data.UPDATE_ADDRESS');

      return $result;
    }
    else
      return null;
  }

  public function validateProductsByWharehouse(){
    $product_wharehouseObj = new ProductWharehouse;
    $productsCart = session()->get('sessionProductsCart');
    $quantityProductsCart = session()->get('quantityProductsCart');
    $subTotalProductsCart = session()->get('subTotalProductsCart');
    foreach ($productsCart as $key => $product) {
      if(gettype($product) != "object"){
        if(!isset($product['is_combo']) && !isset($product['isPromotion'])){
          $count= $product_wharehouseObj->validateProduct($product['product_id'])!==null?
                  $product_wharehouseObj->validateProduct($product['product_id'])->count() : 0;
          if(($count == 0) && isset($product['is_kit'])){
            $quantityProductsCart--;
            $subTotalProductsCart -= $product['priceQuantity'];
            unset($productsCart[$key]);
          }
        }
      } else{
        if(!isset($product->is_combo) && !isset($product->isPromotion)){
          if(($product_wharehouseObj->validateProduct($product->product_id)->count()) == 0 && isset($product->is_kit)){
            $quantityProductsCart--;
            $subTotalProductsCart -= $product->priceQuantity;
            unset($productsCart[$key]);
          }
        }
      }
    }
    session()->put('sessionProductsCart', $productsCart);
    session()->put('quantityProductsCart', $quantityProductsCart);
    session()->put('subTotalProductsCart', $subTotalProductsCart);
  }

  public function getTranslate(Request $request){
      if($request['translate'] != null || $request['translate'] != ''){
          if(!$request['attr']){
              $result = trans($request['translate']);
          } else {
              $result = trans($request['translate'], [$request['name_attr'] => $request['attr']]);
          }

      } else {
          $result = '';
      }
      return $result;
  }

  public function index()
  {
    return view('api::index');
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return view('api::create');
  }

  /**
   * Store a newly created resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
  }

  /**
   * Show the specified resource.
   * @return Response
   */
  public function show()
  {
    return view('api::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function edit()
  {
    return view('api::edit');
  }


}
