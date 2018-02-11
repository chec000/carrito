<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class CategoryLanguage extends Model {
protected $table = 'category_language';

/*Name: getCategoryByCountry
 * Description: obtiene las categorias de los productos por pais y lenguaje
 */
    public function getCategoryByCountry($country,$id_language){
        try {
                   $category = DB::table('category as c')
                ->join('category_language as cl', 'cl.category_id', '=', 'c.category_id')
                  ->where([
                      ['c.country_id','=',$country['country_id']],
                      ['c.is_main_category','=',0],
                      ['cl.language_id','=',$id_language],
                      ['cl.estatus','=',1],
                    ])
                ->select('cl.category','cl.category_id','c.list_order')
                ->orderBy('c.list_order', 'DESC ')->get();
        } catch (Exception $ex) {
            return $null;
        }
          return $category;
    }

    public function getCategoryName($categoy_id,$language_id) {
        try {
        $categoyName= $this->where([
            ["category_id",$categoy_id],
            ["language_id",$language_id]
                ])->select('category')->first();
           $category=$categoyName->category;
        } catch (Exception $ex) {
            $category="";
        }
        return $category;
    }

}
