<?php
/**
 * Created by PhpStorm.
 * User: alan.magdaleno
 * Date: 08/01/18
 * Time: 15:16
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductRelated extends Model
{
    protected $table = 'products_related';

    protected $primaryKey = 'products_related_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'products_related_id', 'product_id','product_id_related','created_at','updated_at','deleted_at','modified_by','estatus'];


//    public function language()
//    {
//        return $this->hasOne('App\Language', 'language_id','language_id');
//    }



}