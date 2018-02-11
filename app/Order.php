<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'country_id','eo_number','order_number','amount','points','tax_amount','discount','shipping_company','guide_number','corbiz_orden_number','payment_type','bank_transaction','shop_type','error_corbiz','corbiz_transaction','wharehouse','managment','attempts','last_modifier','change_period','created_at','updated_at','order_status_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];




    public function orderstatus(){
        return $this->hasOne('App\OrderStatus','order_status_id','order_status_id');
    }

    public function shippingaddress(){
        return $this->hasOne('App\ShippingAddress','order_id','order_id');
    }


    public function orderdetail(){
        return $this->hasMany('App\OrderDetail','order_id','order_id');
    }


    public function country(){
        return $this->hasOne('App\Country','country_id','country_id');
    }


}
