<?php
/**
 * Created by PhpStorm.
 * User: alan.magdaleno
 * Date: 08/01/18
 * Time: 15:16
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ProductLanguage extends Model
{
    protected $table = 'product_language';

    protected $primaryKey = 'product_language_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_language_id', 'product_id','consupsion_tips','language_id','name','description','short_description','consuption_tips','nutritional_table','video_url','created_at','updated_at','deleted_at','modified_by','estatus'];


    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }

    public function product()
    {
        return $this->hasOne('App\Product', 'product_id','product_id');
    }



}