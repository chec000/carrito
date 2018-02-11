<?php
/**
 * Created by PhpStorm.
 * User: alan.magdaleno
 * Date: 08/01/18
 * Time: 15:15
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class PackageLanguage extends Model
{
    protected $table = 'package_language';

    protected $primaryKey = 'package_language_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'package_language_id', 'package_id', 'language_id','name','image_package','description','video_url','created_at','updated_at','deleted_at','modified_by','estatus'];

    public function language()
    {
        return $this->hasOne('App\Language', 'language_id','language_id');
    }


    public function productpackage(){
        return $this->hasMany('App\ProductPackage','package_id','package_id');
    }


}