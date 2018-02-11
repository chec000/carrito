<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{

    protected $table = 'testimony';

    protected $primaryKey = 'testimony_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'testimony_id', 'usuario_id', 'country_id', 'language_id', 'product_id', 'name', 'photo', 'testimony', 'created_at','updated_at','deleted_at','modified_by','estatus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }

    public function product()
    {
        return $this->hasOne('App\Product', 'product_id','product_id');
    }


    public function productLanguage()
    {
        return $this->hasOne('App\ProductLanguage', 'product_id','product_id');
    }
}
