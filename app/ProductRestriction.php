<?php
/**
 * Created by PhpStorm.
 * User: alan.magdaleno
 * Date: 08/01/18
 * Time: 15:16
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductRestriction extends Model
{
    protected $table = 'product_state_restriction';

    protected $primaryKey = 'product_state_restriction_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_state_restriction_id', 'product_id','state_id','created_at','updated_at','deleted_at','modified_by','estatus'];


    public function product()
    {
        return $this->hasOne('App\Product', 'product_id','product_id');
    }

    public function state()
    {
        return $this->hasOne('App\State', 'state_id','state_id');
    }

}