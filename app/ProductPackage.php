<?php
/**
 * Created by PhpStorm.
 * User: alan.magdaleno
 * Date: 08/01/18
 * Time: 15:16
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductPackage extends Model
{
    protected $table = 'product_package';

    protected $primaryKey = 'product_package_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_package_id', 'package_id','product_id','quantity','created_at','updated_at','deleted_at','modified_by','estatus'];

    public function packagelanguage()
    {
        return $this->belongsTo('App\PackageLanguage', 'package_id','package_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id','product_id');
    }

    public function productlanguage()
    {
        return $this->belongsTo('App\ProductLanguage', 'product_id','product_id');
    }
}