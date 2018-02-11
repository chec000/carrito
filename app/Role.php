<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Tabla asociada con el modelo
     *
     * @var string
     */

    public $connection ='mysql';

    public $table = 'roles';

    public $primaryKey = 'id';

    protected $fillable = ['name', 'alias', 'description','status','country_id','language_id','modified_by'];

    public $timestamps = false;

    /*
     * relationships
     */
    public function users(){
//        return  $this->belongsToMany('Modules\Support\Entities\UserSupport', 'role_user', 'role_id', 'user_id');
    }

    public function permissions(){
        return $this->belongsToMany('App\Permission', 'permission_role', 'role_id', 'permission_id');
    }


    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }
}
