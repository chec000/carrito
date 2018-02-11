<?php
namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * Description of EFProduct
 *
 * @author sergio
 */
class Cart extends Model{
  /**     * Columns required to save row     *     * @var array     */
  protected $fillable = [];
  /**     *     * The name of the table that will be saving the data     *     * @var string     */
  protected $table = 'cart';

  public function getProducts($userId, $languge){
    $cart = array();
    $cart["sessionProductsCart"] = DB::table('cart as c')
      ->join('product as p', 'c.product_id', '=', 'p.product_id')
      ->join('product_language as pl', 'p.product_id', '=', 'pl.product_id')
      ->select('c.product_id', 'c.quantity',
               'p.price', 'p.points', 'p.sku', 'p.is_kit',
               'pl.name', 'pl.description', 'pl.short_description',
               DB::raw('c.quantity * p.price as priceQuantity'))
      ->where([
        ['c.dist_id', '=', $userId],
        ['pl.language_id', '=', 1]
      ])
      ->get();
    $cart["sessionCombosCart"] = DB::table('cart as c')
      ->join('package as p', 'c.package_id', '=', 'p.package_id')
      ->join('package_language as pl', 'p.package_id', '=', 'pl.package_id')
      ->select('c.package_id', 'c.quantity',
               'p.price', 'p.points',
               'pl.name', 'pl.description',
               DB::raw('c.quantity * p.price as priceQuantity'),
               DB::raw('"true" as isCombo'))
      ->where([
        ['c.dist_id', '=', $userId],
        ['pl.language_id', '=', 1]
      ])
      ->get();
    $cart["sessionCombosCart"] = $this->getProductsCombos($cart["sessionCombosCart"]);
    $cart["sessionProductsCart"] = $this->mergeArrayProtected($cart["sessionProductsCart"], $cart["sessionCombosCart"]);
    $cart["subTotalProductsCart"] = DB::table('cart as c')
      ->join('product as p', 'c.product_id', '=', 'p.product_id')
      ->select(DB::raw('sum(c.quantity * p.price) as total'))
      ->where('c.dist_id', '=', $userId)
      ->groupBy('c.dist_id')
      ->get();
    $cart["subTotalCombosCart"] = DB::table('cart as c')
      ->join('package as p', 'c.package_id', '=', 'p.package_id')
      ->select(DB::raw('sum(c.quantity * p.price) as total'))
      ->where('c.dist_id', '=', $userId)
      ->groupBy('c.dist_id')
      ->get();
    $cart["quantityProductsCart"] = count($cart["sessionProductsCart"]);
    $cart["subTotalProductsCart"] = (count($cart["subTotalProductsCart"]) > 0) ? intval($cart["subTotalProductsCart"][0]->total) : 0;
    $cart["subTotalCombosCart"] = (count($cart["subTotalCombosCart"]) > 0) ? intval($cart["subTotalCombosCart"][0]->total) : 0;

    $cart["subTotalProductsCart"] = $cart["subTotalProductsCart"] + $cart["subTotalCombosCart"];
    return $cart;
  }

  public function insertProducts($userId, $products){
    foreach ($products as $product){
      $cart = new Cart;
      $cart->dist_id = $userId;
      //die(var_dump(gettype($product)));
      if(gettype($product) == "object"){
        if((!isset($product->isPromotion) && isset($product->is_kit)) || isset($product->isCombo)){
          if(isset($product->isCombo))
            $cart->package_id = $product->package_id;
          else
            $cart->product_id = $product->product_id;

          $cart->quantity = $product->quantity;
          $cart->save();
        }
      }
      else{
        if((!isset($product["isPromotion"]) && isset($product["is_kit"])) || isset($product["isCombo"])){
          if(isset($product["isCombo"]))
            $cart->package_id = $product["package_id"];
          else
            $cart->product_id = $product["product_id"];

          $cart->quantity = $product["quantity"];
          $cart->save();
        }
      }
    }
  }

  public function mergeArrayProtected($arr1, $arr2){
    $allItems = array();
    foreach($arr1 as $item){
      array_push($allItems, $item);
    }
    foreach($arr2 as $item){
      array_push($allItems, $item);
    }
    return $allItems;
  }

  public function getProductsCombos($combos){
    foreach ($combos as $key => $combo){
      $products = DB::table('product as p')
        ->join('product_package  as pp', 'p.product_id', '=', 'pp.product_id')
        ->select('p.product_id', 'p.sku', 'p.price', 'p.points', 'p.is_kit')
        ->where('pp.package_id', '=', $combo->package_id)
        ->get();
      $combos[$key]->products = $products;
    }
  return $combos;
  }

  public function removeProductsCart($id){
    $res=Cart::where('dist_id',$id)->delete();
  }
}
