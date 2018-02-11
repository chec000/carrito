<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Checkout\Http\Controllers\AbcAddressController;
use DB;
use App\UrlService;
use Modules\Checkout\Http\Controllers;
use Modules\Payment\Entities\Zip_codes;
use Illuminate\Support\Facades\Input;
use Modules\Paypal\Entities\RegisterOrder;
use Session;

class CheckoutController extends Controller
{
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index()
  {
    $kit = session()->get('selected_kit');
    $userId = session()->get('userId');
    if($userId)
      return view('checkout::checkout');

    if ($kit || $userId) {
      $kitType = gettype($kit);
      if($kitType == "object"){
        if(isset($kit->sku))
          return view('checkout::checkout');
      }
      else{
        if($kit["sku"])
          return view('checkout::checkout');
      }
    }
    return redirect('/inscription/register');
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return view('checkout::create');
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
    return view('checkout::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function edit()
  {
    return view('checkout::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function destroy()
  {
  }

  public function getSession(){
    $id = session()->get('userId');

    if ($id) {
      $this->getAddressUserSession();

      $form = array();
      $form['country'] = session()->get('country');
      $form['name'] = session()->get('userName');
        $form['state'] = session()->get('state');
      if(!emptyArray(session()->get('adressShippDist'))) {
          $form['address'] = session()->get('adressShippDist')['direccion'];
          $form['district'] = session()->get('adressShippDist')['condado'];
          $form['zip_code'] = session()->get('adressShippDist')['cp'];
          $form['federal_entities'] = session()->get('adressShippDist')['ciudad'];
          $form['ship_company'] =session()->get('adressShippDist')['comp_env'];
      }
      $form['new_user'] = false;
      $form['rand_sponsor'] = false;
      if(session()->has("selected_kit"))
        $form['selected_kit'] = session()->get("selected_kit");
      else
        $form['selected_kit'] = (object) [];

      session()->put('formReg',$form);
    }
    if(!session()->has("selected_kit"))
      session()->put('selected_kit',(object) []);
    $data = session()->all();
    return $data;
  }

    public function acceptedItems(Request $request) {
      $productsSession = self::separateProducts($request["sessionProductsCart"]);
      //return $productsSession['service'];
      $user = session()->get('formReg')['new_user'];
      $wharehouse = CheckoutController::getWharehouse();

      if(!session()->get('adressShippDist') ) {
          //die($user);
          $address = new  AbcAddressController;
          $address->getListAddressDist(session()->get('country'));
      }
      //$address->getListAddressDist( session()->get('country'));
      if ($user) {
        $shoptype = "INSCRIPCION";
        $kitDigital = true;
        $data_items = array(
          "metodo" => "aceptedItems",
          "params" => array(
            "dataEo" => array(
              "eo" => null,
              "name" => session()->get('formReg')['name']." ".session()->get('formReg')['last_name'],
              "address" => session()->get('formReg')['address'],
              "suburb" => session()->get('formReg')['federal_entities'],
              "county" => session()->get('formReg')['county'],
              "zipCode" => session()->get('formReg')['zip_code'],
              "city" => session()->get('formReg')['federal_entities'],
              "state" => session()->get('formReg')['state'],
              "country" => session()->get('formReg')['country'],
              "alternateAddress" => "0",
            ),
            "products" => $productsSession['service'],
            "productsPromo" => $productsSession['promotions'],
            "validPromo"=> true,
            "kitDigital"=> $kitDigital,
            "wharehouse"=> $wharehouse['data']['clvAlmacen'],
            "shopType"=> $shoptype,
            "shippingCompany" => session()->get('formReg')['ship_company'],
            "extraData"=>"Generico"
          )
        );
      }else{
        $shoptype = "VENTA";
        $kitDigital = false;
        $data_items = array(
          "metodo" => "aceptedItems",
          "params" => array(
            "dataEo" => array(
              "eo" => session()->get('userId'),
              "name" => session()->get('adressShippDist')['nombre'],
              "address" => session()->get('adressShippDist')['direccion'],
              "suburb" => session()->get('adressShippDist')['colonia'],
              "county" => session()->get('adressShippDist')['condado'],
              "zipCode" => session()->get('adressShippDist')['cp'],
              "city" => session()->get('adressShippDist')['ciudad'],
              "state" => session()->get('adressShippDist')['estado'],
              "country" => session()->get('country'),
              "alternateAddress" => "0",
            ),
            "products" => $productsSession['service'],
            "productsPromo" => $productsSession['promotions'],
            "validPromo"=> true,
            "kitDigital"=> $kitDigital,
            "wharehouse"=> $wharehouse['data']['clvAlmacen'],
            "shopType"=> $shoptype,
            "shippingCompany" => session()->get('adressShippDist')['comp_env'],
            "extraData"=>"?"
          )
        );
      }
    //die(var_dump(json_encode($productsSession)));
    //die(var_dump(json_encode($data_items)));
    $response_items = UrlService::webService($data_items);
    //die(var_dump(json_encode($response_items)));
    if($response_items != null){
      $response = array();
      $response["productsAccepted"] = $response_items["data"]["products"];
      $response["promotions"] = $response_items["data"]["promotions"];
      $response['total_points'] = $response_items["data"]["points"];
      $response["productsCart"] = [];
      $response["quantityProductsCart"] = session()->get('quantityProductsCart');
      $response["subTotalProductsCart"] = $response_items["data"]["subtotal"];
      $response["productsOut"] = [];
      $response["combos_del"] = [];
      $response["combos_acc"] = [];
      $response["totalProductsCart"] =0;
      $response["recalculatedCart"] = $request["sessionProductsCart"];
      //die(var_dump($response['productsAccepted']));
      foreach ($productsSession['all'] as $product2) {
        $out = true;
        $package_id = null;
        $product_price = 0;
        foreach ($response["productsAccepted"] as $key => $product) {
          if($product["sku"] == $product2["sku"]){
            $product_acc = $product;
            $out = false;
          }
          if($product["quantity"] == $product2["quantity"] && $product["sku"] == $product2["sku"] && isset($product["package_id"]))
            $package_id = $product["package_id"];
        }
        if($out){
          array_push($response["productsOut"], $product2);
          $response["quantityProductsCart"]--;
        }
        elseif($package_id == null){
          array_push($response["productsCart"], $product_acc);
        }
      }
    }else{
      return null;
    }

    foreach ($productsSession['combos'] as $key => $combo) {
      $out = true;
      $productChecked = array();
      foreach ($combo as $key1 => $product) {
        $productChecked = $product;
        foreach ($response["productsOut"] as $key2 => $productOut) {
          if($product["sku"] == $productOut["sku"] && $out) {
            $out = false;
            if(!in_array($product["package_id"], $response["combos_del"]))
              array_push($response["combos_del"], $product["package_id"]);
          }
        }
      }
      if($out){
        if(!in_array($productChecked["package_id"], $response["combos_acc"])){
          $item = [];
          $response["combos_acc"][$productChecked["package_id"]] = [];
          $item["package_id"] = $productChecked["package_id"];
          array_push($response["combos_acc"][$productChecked["package_id"]], $item);
          $productChecked["price"] = self::searchInArrayOfObjects($productChecked["sku"], $response["productsAccepted"])[0]["price"];
          array_push($response["productsCart"], $productChecked);
        }
      }
    }

    //die(var_dump(json_encode($response["recalculatedCart"])));
    //die(var_dump(json_encode($response)));
    foreach ($response["recalculatedCart"] as $key => $sessionProduct) {
      foreach ($response["productsOut"] as $productOut) {
        if(!isset($sessionProduct["package_id"])){
          if($sessionProduct["sku"] == $productOut["sku"])
            unset($response["recalculatedCart"][$key]);
        }
      }
      foreach ($response["productsCart"] as $productAccepted) {
        if(!isset($sessionProduct["package_id"])){
          if($sessionProduct["sku"] == $productAccepted["sku"]){
            $response["recalculatedCart"][$key]["price"] = $productAccepted["price"];
            $response["recalculatedCart"][$key]["priceQuantity"] = $productAccepted["price"] * $productAccepted["quantity"];
          }
        }
      }
      foreach ($response["combos_del"] as $comboOut) {
        if(isset($sessionProduct["package_id"])){
          if($sessionProduct["package_id"] == $comboOut)
            unset($response["recalculatedCart"][$key]);
        }
      }
      foreach ($response["combos_acc"] as $comboAccepted){
        if(isset($sessionProduct["package_id"])){
          if($sessionProduct["package_id"] == $comboAccepted[0]["package_id"]){
            $response["recalculatedCart"][$key]["priceQuantity"] = 0;
            $response["recalculatedCart"][$key]["price"] = 0;
            foreach($sessionProduct["products"] as $key2 => $productCombo){
              $discountPrice = self::searchInArrayOfObjects($sessionProduct["products"][$key2]["sku"], $response["productsCart"])[0]["price"];
              $response["recalculatedCart"][$key]["products"][$key2]["priceQuantity"] = $discountPrice * $sessionProduct["quantity"];
              $response["recalculatedCart"][$key]["products"][$key2]["price"] = $discountPrice;
              $response["recalculatedCart"][$key]["priceQuantity"] += $discountPrice * $sessionProduct["quantity"];
              $response["recalculatedCart"][$key]["price"] += $response["recalculatedCart"][$key]["products"][$key2]["priceQuantity"] / $sessionProduct["quantity"];
            }
          }
        }
      }
    }
    //die(var_dump(json_encode($response_items)));
    //$response["subTotalProductsCart"] += session()->get('selected_kit')["price"];
    $country = self::getCountry();
    $ws_acceptedItems = array('points' => $response_items["data"]["points"],'discount' => $response_items["data"]["discount"],'country'=>$country );
    session()->put("ws_acceptedItems",$ws_acceptedItems);
    session()->put("management",$response_items["data"]["management"]);
    session()->put("taxes",$response_items["data"]["taxes"]);
    session()->put("points",$response['total_points']);
    session()->put("ListPromotions",$response_items["data"]["promotions"]);
    session()->put('sessionProductsCart', $response["recalculatedCart"]);
    session()->put('quantityProductsCart', $response["quantityProductsCart"]);
    session()->put('wharehouse', $wharehouse['data']['clvAlmacen']);
    $response['totalProductsCart'] =  $response['subTotalProductsCart'] + $response_items["data"]["taxes"] + $response_items["data"]["management"];
    session()->put('totalProductsCart', $response["totalProductsCart"]);
    session()->put('subTotalProductsCart', $response["subTotalProductsCart"]);
    return $response;
  }
  public function getCountry(){
    $country = DB::table('country')
            ->select('country_id', 'name')
            ->where('estatus', '=', 1)
            ->where('short_name', '=', session()->get('formReg')['country'])
            ->first();
        return $country->country_id;
  }
  public static function separateProducts($products){
    //die(var_dump($products));
    $prods = [];
    $prods['service']=[];
    $prods['combos']=[];
    $prods['all']=[];
    $prods['promotions']=[];
    foreach ($products as $key => $value ) {
      if(!isset($value["promoKey"])){
        if (isset($value["isCombo"])) {
          if(!in_array($value["package_id"], $prods["combos"]))
            $prods["combos"][$value["package_id"]] = [];
          foreach ($value['products'] as $key => $value2) {
            if(!self::productRestricted((array) $value2)){
              $temp = array(
                "sku" => $value2['sku'],
                "price" => $value2['price'],
                "quantity" => $value["quantity"],
                "description" =>$value['description']
              );
              array_push($prods['service'], $temp);
              $temp['package_id'] = $value["package_id"];
              array_push($prods['combos'][$value["package_id"]], $temp);
              array_push($prods['all'], $temp);
            }
          }
        }else {
          if(!self::productRestricted($value)){
            $temp = array(
              "sku" => $value["sku"],
              "price" => $value["price"],
              "quantity" => $value["quantity"],
              "description"=>$value["description"]
            );
            array_push($prods['service'], $temp);
            array_push($prods['all'], $temp);
          }
        }
      }
      else{
        $temp = array(
          "sku" => $value["sku"],
          "price" => $value["price"],
          "quantity" => $value["quantity"],
          "description"=>$value["description"]
        );
        array_push($prods['promotions'], $temp);
        array_push($prods['all'], $temp);
      }
    }
    return $prods;
  }
  public static function separateProducts2($products){
    //die(var_dump($products));
    $prods = [];
    $prods['service']=[];
    $prods['combos']=[];
    $prods['all']=[];
    foreach ($products as $key => $value ) {
      if (isset($value["isCombo"])) {
        if(!in_array($value["package_id"], $prods["combos"]))
          $prods["combos"][$value["package_id"]] = [];
        foreach ($value['products'] as $key => $value2) {
          if(!self::productRestricted((array) $value2)){
            $temp = array(
              "sku" => $value2['sku'],
              "price" => $value2['price'],
              "quantity" => $value["quantity"]
            );
            array_push($prods['service'], $temp);
            $temp['package_id'] = $value["package_id"];
            array_push($prods['combos'][$value["package_id"]], $temp);
            array_push($prods['all'], $temp);
          }
        }
      }else {
        if(!self::productRestricted($value)){
          $temp = array(
            "sku" => $value["sku"],
            "price" => $value["price"],
            "quantity" => $value["quantity"]
          );
          array_push($prods['service'], $temp);
          array_push($prods['all'], $temp);
        }
      }
    }
    return $prods;
  }
  public static function getWharehouse(){
    $parms = array(
      "metodo" =>"buscaAlmacen",
      "params" => array(
        "clvPais" => session()->get('country'),
        "clvCiudad" => session()->get('zip.city'),
        "clvEstado" => session()->get('zip.state')
      )
    );
    $result = UrlService::webService($parms);
    return $result;
  }

  public function getAddressUserSession(){
    $address = new AbcAddressController;
    $address->getListAddressDist(session()->get('country'));
    if(session()->get('adressShippDist') == null || (!session()->get('adressShippDist'))){
      /*if(isset($addressDist['result']['data'][0])){
        session()->put('adressShippDist',$addressDist['result']['data'][0]);
      } else {*/
        session()->put('adressShippDist',array());
    }
  }

  public function getAddressShipSession(){
      if(session()->get('adressShippDist') != null || (session()->get('adressShippDist'))) {
          $data = session()->get('adressShippDist');
      } else {
          $data = '';
      }

      return $data;
  }

  public function updateAddress(){
    $address =Input::get('addressShp');
    $request = json_decode($address);
    $form = array();
    $form['country'] = session()->get('country');
    $form['name'] = session()->get('userName');
    $form['state'] = session()->get('state');
    $form['new_user'] = false;
    $form['address'] = $request->direccion;
    $form['district'] = $request->condado;
    $form['zip_code'] = $request->cp;
    $form['federal_entities'] = $request->ciudad;
    $form['ship_company'] =$request->comp_env;
    session()->put('formReg',$form);
    return json_encode($request->direccion);
  }

  public static function productRestricted($product){
    if(!isset($product["promoKey"])){
      $restricted = DB::table('product_state_restriction')
      ->select('*')
      ->where([
        ['product_id', '=', $product["product_id"]],
        ['state_id', '=', session()->get('state_id')]
      ])
      ->get();
      if(count($restricted) > 0)
        return true;
    }
    return false;
  }

  public function searchInArrayOfObjects($searchedValue, $arr){
    $obj = array_filter(
      $arr, function ($e) use (&$searchedValue) {
        return $e["sku"] == $searchedValue;
      }
    );
    return array_values($obj);
  }

  public function successProcess(){
    Session::forget('sessionProductsCart');
    Session::forget('quantityProductsCart');
    Session::forget('subTotalProductsCart');
    Session::forget('totalProductsCart');
    Session::forget('ListPromotionsBuild');
    Session::put('selected_kit', (object) array());
    session()->flash('pdf','get pdf');
    return view('checkout::successProcess');
  }

  public function rejectedCharge(){
    return view('checkout::rejectedCharge');
  }

  public function yourOrders(){
    return view('checkout::yourOrders');
  }
  public function cancelOrderRejected(){
    $regOrder = new RegisterOrder();
    $bank = "Payment cancelled";
    $order_status = 6;
    $corbiz_error = "";
    $order = $regOrder->updateOrder($bank,$order_status,$corbiz_error);
    return json_encode($order);
  }
}
