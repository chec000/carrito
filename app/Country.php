<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';

    protected $primaryKey = 'country_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'short_name', 'estatus','created_at','updated_at','deleted_at','modified_by','estatus'
    ];

//    public function language()
//    {
//        return $this->hasOne('App\Language', 'language_id','language_id');
//    }

}
