<?php
/**
 * Created by PhpStorm.
 * User: alan.magdaleno
 * Date: 08/01/18
 * Time: 15:16
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
    protected $table = 'product_ingredient';

    protected $primaryKey = 'product_ingredient_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_ingredient_id', 'product_id','ingredient_id','created_at','updated_at','deleted_at','modified_by','estatus'];


}