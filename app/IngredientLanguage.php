<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngredientLanguage extends Model
{
    protected $table = 'ingredient_language';

    protected $primaryKey = 'ingredient_language_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ingredient_language_id', 'ingredient_id', 'language_id','ingredient','created_at','updated_at','deleted_at','modified_by','estatus'
    ];

    public function ingredient()
    {
        return $this->hasOne('App\Ingredient', 'ingredient_id','ingredient_id');
    }

    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }

}
