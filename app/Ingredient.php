<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'ingredient';

    protected $primaryKey = 'ingredient_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ingredient_id', 'country_id','created_at', 'updated_at', 'deleted_at', 'modified_by', 'estatus'
    ];

    public function country()
    {
        return $this->hasOne('App\Country', 'country_id','country_id');
    }

}
