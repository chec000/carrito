<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state';

    protected $primaryKey = 'state_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'state', 'estatus'
    ];

    public function country()
    {
        return $this->hasOne('App\Country', 'country_id','country_id');
    }

}
