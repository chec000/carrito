<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;

class OrdersStatus extends Model
{
    protected $fillable = [];
    protected $table = 'order_status';
    protected $primaryKey = 'order_status_id';

}
