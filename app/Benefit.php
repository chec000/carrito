<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{

    protected $table = 'benefit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'benefit_id', 'country_id', 'created_at','updated_at','deleted_at','modified_by','estatus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];



}
