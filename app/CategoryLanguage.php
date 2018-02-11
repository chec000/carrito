<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryLanguage extends Model
{
    protected $table = 'category_language';

    protected $primaryKey = 'category_language_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_language_id', 'category_id', 'language_id','category','created_at','updated_at','deleted_at','estatus'];

    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'category_id','category_id');
    }

}
