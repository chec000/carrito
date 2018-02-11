<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{

    protected $table = 'shipping_address';

    protected $primaryKey = 'shipping_address_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shipping_address_id', 'sponsor','sponsor_name','sponsor_email','eo_number','eo_name','order_id','type','folio','address','number','complement','suburb','zip_code','city','city_name','state','country','country_key','email','telephone','cell_number','gender','security_question_id','answer','kit_type','document_key','document_number','creation_date','updated_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];








}
