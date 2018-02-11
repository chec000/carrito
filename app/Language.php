<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'language';


    protected $primaryKey = 'language_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id', 'name', 'short_name','created_at','updated_at','deleted_at','modified_by','estatus'
    ];




}
