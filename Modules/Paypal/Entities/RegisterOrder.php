<?php
namespace Modules\Paypal\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Response;
class registerOrder extends Model{
  
  protected $fillable = [];
  protected $table = 'orders';

  public function regOrder($prods,$user,$accion){
    $order = new registerOrder();
    $order->country_id = session()->get('ws_acceptedItems')['country'];
    $order->eo_number = $user['eo_number'];
    $order->order_number = session()->get('orderNumber');
    $order->amount = session()->get('totalProductsCart');
    $order->points = session()->get('ws_acceptedItems')['points'];
    $order->tax_amount = session()->get('taxes');
    $order->discount = session()->get('ws_acceptedItems')['discount']; 
    if (session()->get('formReg')['new_user']) {
      $order->shipping_company = session()->get('formReg')['ship_company'];  
    }else{
      $order->shipping_company = session()->get('adressShippDist')['comp_env'];
    }
    $order->guide_number = 0;
    $order->corbiz_order_number = 0;
    $order->payment_type = 1;
    $order->bank_transaction = null; //paypal respuesta
    $order->shop_type = $accion;
    $order->error_corbiz = null;
    $order->corbiz_transaction = session()->get('corbiz_transaction');
    $order->wharehouse = session()->get('wharehouse');
    $order->management = session()->get('management');
    $order->attempts = 1;
    $order->order_status_id = 1; // tabla order_status
    $order->change_period = false;
    $order->last_modifier = 1; 
    $order->save();
    return Response::json(array('success' => true, 'last_insert_id' => $order->id), 200);
  }

  public function updateOrder($corbiz_orden,$bank,$order_status,$corbiz_error=""){
    $order = new registerOrder();
    $order->where('corbiz_transaction', session()->get('corbiz_transaction'))->update(array('bank_transaction' => $bank,'order_status_id' => $order_status,'error_corbiz'=>$corbiz_error,'corbiz_order_number'=>$corbiz_orden));
    return true;
  }
  public function updateUserInfo($user_info){
    $order = new registerOrder();
    $order->where('corbiz_transaction', session()->get('corbiz_transaction'))
    ->update(array('error_corbiz' => $user_info));
    return true;
  }
  
  public function updateUser($user,$id){
    $order = new registerOrder();
    $order->where('order_id', $id->original['last_insert_id'])
      ->update(array('eo_number' => $user['usuario']
      ));
    return true;
  }

}
