<?php
/**
 * Created by PhpStorm.
 * User: alan_
 * Date: 31/12/2017
 * Time: 13:29
 */

namespace App;

use Illuminate\Database\Eloquent\Model;


class Blacklist extends Model
{
    protected $table = 'blacklist';


    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'eonumber','reason','country_id', 'created_at', 'updated_at', 'deleted_at', 'modified_by', 'estatus'
    ];
}



