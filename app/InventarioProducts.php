<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioProducts extends Model {

    /**
     * Columns required to save row
     *
     * @var array
     */
    protected $fillable = ['product_wharehouse_id','wharehouse_id','product_id','stock','updated_at','deleted_at','modified_by'];

    /**
     *
     * The name of the table that will be saving the data
     *
     * @var string
     */
    public $table = 'product_wharehouse';

    public $connection ='mysql';

    protected $primaryKey = 'product_wharehouse_id';

    public $timestamps = false;


    public function almacenes()
    {
        return $this->belongsTo('App\Warehouse','wharehouse_id','wharehouse_id');
    }


//end validaProduct
}
