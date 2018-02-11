<?php
/**
 * Created by PhpStorm.
 * User: alan.magdaleno
 * Date: 08/01/18
 * Time: 15:16
 */

namespace App;


use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'country_id','sku','price','points','is_kit','created_at',
        'updated_at','deleted_at','modified_by','estatus'];



    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }


    public function productlanguage()
    {
        return $this->hasOne( 'App\ProductLanguage', 'product_id','product_id');
    }



}