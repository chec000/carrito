<?php
/**
 * Created by PhpStorm.
 * User: joseosuna
 * Date: 23/11/16
 * Time: 4:55 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Tabla asociada con el modelo
     *
     * @var string
     */

    public $connection ='mysql';

    public $table = 'category';

    protected $primaryKey = 'category_id';

    protected $fillable = ['category_id','country_id','is_main_category','created_at','updated_at','deleted_at','modified_by','estatus','list_order'];




    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }
}
