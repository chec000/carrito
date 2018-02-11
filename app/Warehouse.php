<?php
/**
 * Created by PhpStorm.
 * User: joseosuna
 * Date: 23/11/16
 * Time: 4:55 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    /**
     * Tabla asociada con el modelo
     *
     * @var string
     */

    public $connection ='mysql';

    public $table = 'wharehouse';

    protected $primaryKey = 'wharehouse_id';

    protected $fillable = ['country_id','name','sap_code','created_at','updated_at','deleted_at','modified_by','estatus'];




    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }
}
