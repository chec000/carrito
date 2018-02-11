<?php
namespace Modules\Paypal\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class registerOrderDetails extends Model{
  
  protected $fillable = [];
  protected $table = 'order_detail';

  public function regOrderDetails($prods,$promotion,$id){
    foreach ($prods as $key => $value) {
      $order_details = new registerOrderDetails();
      if (isset($value['product_id'])) {
        $order_details->order_id = $id->original['last_insert_id'];
        $order_details->product_id = $value['product_id'];
        $order_details->final_price = $value['priceQuantity'];
        $order_details->points = $value['points'];
        $order_details->quantity = $value['quantity'];
        $order_details->active = 0;
        $order_details->is_promo =0 ;
        $order_details->promo_type = 0;
        $order_details->promo_code = 0;
        $order_details->promo_product_name = 0;
      }else{
        $order_details->order_id = $id->original['last_insert_id'];
        $order_details->product_id = $value['sku'];
        $order_details->final_price = $value['priceQuantity'];
        $order_details->points = $value['points'];
        $order_details->quantity = $value['quantity'];
        $order_details->active = 0;
        $order_details->is_promo =1 ;
        $order_details->promo_type = $value['typePromotion'];
        $order_details->promo_code = $value['promoKey'];
        $order_details->promo_product_name = $value['name'];
        
      }
      $order_details->save();
    }
    return true;
  }

  public function getId($table="", $eo_number=""){
    $user = DB::table($table)
      ->where('eo_number',$eo_number)
      ->latest()
      ->first();
      return $user;
  }

}
