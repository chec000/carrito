<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'labels';

    protected $primaryKey = 'label_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'created_at', 'updated_at', 'deleted_at', 'modified_by', 'estatus'
    ];

    public function country()
    {
        return $this->hasOne('App\Country', 'country_id','country_id');
    }

}
