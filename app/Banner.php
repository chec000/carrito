<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banner extends Model
{

    protected $table = 'banner';

    protected $primaryKey = 'banner_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'banner_id', 'country_id', 'created_at','updated_at','deleted_at','modified_by','estatus'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

public function up()
{
  // Renombrar la columna name a first_name
  Schema::table('Banner', function(Blueprint $table)
  {
    $table->renameColumn('name','first_name');
  });
}

public function down()
{
  // Volver a renombrar la columna con su antiguo nombre
  Schema::table('Banner', function(Blueprint $table)
  {
    $table->renameColumn('first_name','name');
  });
}
    public function getBannerInfo(){
     
        $lang = self::getLang();
        try {
            $state_id = session()->get('state_id');
            $banner = DB::table('banner')
            ->select( 'banner.country_id', 'bl.banner_id', 'bl.main_image', 'bl.name',
            'bl.language_id')
            ->join('banner_language as bl', 'banner.banner_id', '=', 'bl.banner_id')
            ->where([
              ['bl.language_id', '=', 1],
              ['banner.estatus', '=', 1],
              ['banner.country_id', '=', 1],
            ])
            ->get();
      } catch (Exception $ex) {
          return null;
      }
        return $banner;

    }

    function getLang(){
        $lang_session =session()->get('applocale');

        $lang = DB::table('language')
        ->select( 'language_id','name','short_name')
        ->where([
            ['short_name', 'like', '%'.$lang_session.'%'],
        ])
        ->first();
        session()->put('lang_id',$lang);
        if (session()->get('country')) {
          $country = session()->get('country');  
        }else{
          $country = "USA";
        }
        
        $country_id = DB::table('country')
        ->select( 'country_id','name','short_name')
        ->where([
            ['short_name', '=', $country],
        ])
        ->first();
        
        session()->put('country_id',$country_id);

        return $lang;
    }
}
