<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{

    protected $table = 'order_status';

    protected $primaryKey = 'order_status_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_status_id', 'status','comment','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];



}
