<?php
/**
 * Created by PhpStorm.
 * User: alan.magdaleno
 * Date: 08/01/18
 * Time: 15:16
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_category';

    protected $primaryKey = 'product_category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_category_id', 'product_id','category_id','created_at','updated_at','deleted_at','modified_by','estatus'];


//    public function language()
//    {
//        return $this->hasOne('App\Language', 'language_id','language_id');
//    }



}