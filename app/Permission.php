<?php
/**
 * Created by PhpStorm.
 * User: joseosuna
 * Date: 23/11/16
 * Time: 4:55 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * Tabla asociada con el modelo
     *
     * @var string
     */

    public $connection ='mysql';

    public $table = 'permissions';

    protected $primaryKey = 'id';

    protected $fillable = ['title', 'alias', 'description','status','country_id','language_id','created_at','updated_at','deleted_at','modified_by'];

    /*
     * relationships
     */
    public function roles(){
        return $this->belongsToMany('Modules\Support\Entities\Role', 'permission_role', 'permission_id', 'role_id');
    }


    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }
}
