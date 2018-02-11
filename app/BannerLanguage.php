<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BannerLanguage extends Model
{
    protected $table = 'banner_language';

    protected $primaryKey = 'banner_language_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'banner_language_id', 'banner_id', 'language_id','main_image','name','created_at','updated_at','deleted_at','modified_by','estatus'
    ];

    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }

}
