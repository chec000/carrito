<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\ProductStateResctriction;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Description of Wherehouse
 *
 * @author sergio
 */
class Wharehouse extends Model {

    protected $fillable = [];
    protected $table = 'wharehouse';

    public function products() {
        return $this->hasMany('Modules\Products\Entities\Product');
    }

    private function getProductsRestriction($state_id) {
        $product_restriction = ProductStateResctriction::where("state_id", "=", $state_id)->select('product_id')->get();
        return $product_restriction;
    }

    public function getProductsByWharehouse($params) {
        try {
            $products = DB::table('product as p')
                    ->join('product_wharehouse as pw', 'pw.product_id', '=', 'p.product_id')
                    ->join('product_language as pl', 'pl.product_id', '=', 'p.product_id')
                    ->join('wharehouse as w','w.wharehouse_id','pw.wharehouse_id')
                    ->select('p.price', 'p.points', 'p.sku', 'p.is_kit', 'p.product_id', 'pl.*')
                    ->where([
                            ['pw.wharehouse_id', '=', $params['whare_house_id']],
                            ['p.country_id', '=', $params['country_id']],
                            ['pl.language_id', '=', $params['language_id']],
                            ['pw.estatus', '=', 1],
                            ['w.estatus', '=', 1],
                           ['pl.estatus', '=', 1],
                           ['p.estatus', '=', 1],
                             ['p.is_kit','=',0],
                            ]
                    )->whereNotIn('pl.product_id', $this->getProductsRestriction($params['state_id']))
                    ->orderBy($params['order_column'], $params['type_order'])
                   ->paginate(12);
        } catch (Exception $ex) {
            return null;
        }
        return $products;
    }

    public function getAllProducts($params) {
        $params['request'] = $params['name'];

        $products = $this->getProductsByName($params);
        if (count($products) > 0) {
            return $products;
        } else if (count($this->getProductsByBenefitName($params)) > 0) {
            return $this->getProductsByBenefitName($params);
        } else if (count($this->getProductsByIngredientName($params)) > 0) {
            return $this->getProductsByIngredientName($params);
        } else {
            return null;
        }
    }

    private function getProductsByBenefitName($params) {
        try {
            $benefit_id = BenefitLanguage::where('benefit', 'like', '%' . $params['name'] . '%')->select('benefit_id')->first();
            $products = DB::table('product as p')
                    ->join('product_wharehouse as pw', 'pw.product_id', '=', 'p.product_id')
                   ->join('wharehouse as w','w.wharehouse_id','pw.wharehouse_id')
                    ->join('product_language as pl', 'pl.product_id', '=', 'p.product_id')
                    ->join('product_benefit as pb', 'pb.product_id', '=', 'p.product_id')
                    ->join('benefit_language as bl', 'bl.benefit_id', '=', 'pb.benefit_id')
                    ->select('p.price', 'p.points', 'p.sku', 'p.is_kit', 'p.product_id', 'pl.*')
                    ->where([
                            ['pw.wharehouse_id', '=', $params['whare_house_id']],
                            ['p.country_id', '=', $params['country_id']],
                            ['pl.language_id', '=', $params['language_id']],
                            ['bl.benefit_id', '=', $benefit_id['benefit_id']],
                            ['pw.estatus', '=', 1],
                           ['w.estatus', '=', 1],
                            ['p.estatus', '=', 1],
                             ['pl.estatus', '=', 1],
                            ['p.is_kit','=',0],
                    ])->whereNotIn('pl.product_id', $this->getProductsRestriction($params['state_id']))
                    ->paginate(12);
        } catch (Exception $ex) {
            return null;
        }
        return $products;
    }

    private function getProductsByIngredientName($params) {
        try {
            $ingredient = Ingredient::where('ingredient', 'like', '%' . $params['name'] . '%')->select('ingredient_id')->first();
            $products = DB::table('product as p')
                    ->join('product_wharehouse as pw', 'pw.product_id', '=', 'p.product_id')
                    ->join('wharehouse as w','w.wharehouse_id','pw.wharehouse_id')
                    ->join('product_language as pl', 'pl.product_id', '=', 'p.product_id')
                    ->join('product_ingredient as pb', 'pb.product_id', '=', 'p.product_id')
                    ->join('ingredient_language as bl', 'bl.ingredient_id', '=', 'pb.ingredient_id')
                    ->select('p.price', 'p.points', 'p.sku', 'p.is_kit', 'p.product_id', 'pl.*')
                    ->where([
                            ['pw.wharehouse_id', '=', $params['whare_house_id']],
                            ['p.country_id', '=', $params['country_id']],
                            ['pl.language_id', '=', $params['language_id']],
                            ['bl.ingredient_id', '=', $ingredient['ingredient_id']],
                            ['pw.estatus', '=', 1],
                             ['pl.estatus', '=', 1],
                            ['p.estatus', '=', 1],
                            ['w.estatus', '=', 1],
                            ['p.is_kit','=',0],
                    ])->whereNotIn('pl.product_id', $this->getProductsRestriction($params['state_id']))
                    ->paginate(12);
        } catch (Exception $ex) {
            return null;
        }
        return $products;
    }

    /**
     * Nombre:getProductsByParams
     * Descripcion:Consulta a tabla product_wharehouse, product,_language
     * Sergio Galindo:: 29/11/17
     * @return array $products
     */
    public function getProductsByParamas($paramsSearch, $searchOrder = false) {
     try {
         if($searchOrder){
             $params = session()->get('paramsLastSearch');
             $params['order_column'] = $paramsSearch['order_column'];
             $params['type_order'] = $paramsSearch['type_order'];
         } else {
             session()->put('paramsLastSearch', $paramsSearch);
             session()->put('typeLastSearch', 'params');
             $params = $paramsSearch;
         }
            $products = DB::table('product as p')
                    ->distinct('p.sku')
                    ->join('product_wharehouse as pw', 'pw.product_id', '=', 'p.product_id')
                     ->join('wharehouse as w','w.wharehouse_id','pw.wharehouse_id')
                    ->join('product_language as pl', 'pl.product_id', '=', 'p.product_id')
                    ->join($params['table_name'], $params['table_name'] . '.product_id', '=', 'p.product_id')
                    ->select('p.*', 'pl.*')
                    ->where([
                            ['pw.wharehouse_id', '=', $params['whare_house_id']],
                            ['p.country_id', '=', $params['country_id']],
                            ['pl.language_id', '=', $params['language_id']],
                            [$params['table_name'] . '.' . $params['column_name'], '=', $params['id_table']],
                            ['pw.estatus', '=', 1],
                             ['p.estatus', '=', 1],
                             ['pl.estatus', '=', 1],
                             ['w.estatus', '=', 1],
                            ['p.is_kit','=',0],
                       [$params['table_name'] . '.estatus',1]
                    ])->whereNotIn('pl.product_id', $this->getProductsRestriction($params['state_id']))
                    ->orderBy($params['order_column'], $params['type_order'])
                    ->paginate(12,['p.sku']);

      } catch (Exception $ex) {
         return null;
    }
        return $products;
    }

    /**
     * Nombre:getProductsByParams
     * Descripcion:Consulta a tabla product_wharehouse, product,_language
     * Sergio Galindo:: 29/11/17
     * @return array $products
     */
    public function getProductsByName($paramsSearch, $searchOrder = false) {
        try {
            if($searchOrder){
                $params = session()->get('paramsLastSearch');
                $params['order_column'] = $paramsSearch['order_column'];
                $params['type_order'] = $paramsSearch['type_order'];
            } else {
                session()->put('paramsLastSearch', $paramsSearch);
                session()->put('typeLastSearch', 'name');
                $params = $paramsSearch;
            }
            $products = DB::table('product as p')
                    ->join('product_wharehouse as pw', 'pw.product_id', '=', 'p.product_id')
                    ->join('wharehouse as w','w.wharehouse_id','pw.wharehouse_id')
                    ->join('product_language as pl', 'pl.product_id', '=', 'p.product_id')
                    ->select('p.*', 'pl.*')
                    ->where([
                            ['pw.wharehouse_id', '=', $params['whare_house_id']],
                            ['p.country_id', '=', $params['country_id']],
                            ['pl.language_id', '=', $params['language_id']],
                            ['pw.estatus', '=', 1],
                            ['p.estatus', '=', 1],
                            ['pl.estatus', '=', 1],
                            ['w.estatus', '=', 1],
                            ['p.is_kit','=',0],
                    ])->where('pl.name', 'like', '%' . $params['request'] . '%')
                    ->whereNotIn('pl.product_id', $this->getProductsRestriction($params['state_id']))
                    ->orderBy($params['order_column'], $params['type_order'])
                    ->paginate(12);
        } catch (Exception $ex) {
            return null;
        }

        return $products;
    }

  public function getMainCategory($whareHouse_id, $language_id, $state_id, $category){
    try {
      $products = DB::table('product')
        ->join('product_wharehouse as pw', 'pw.product_id', '=', 'product.product_id')
        ->join('wharehouse as w','w.wharehouse_id','pw.wharehouse_id')
        ->join('product_language as pl', 'pw.product_id', '=', 'pl.product_id')
        ->join('product_category as pc', 'product.product_id', '=', 'pc.product_id')
        ->join('category as c', 'pc.category_id', '=', 'c.category_id')
        ->join('category_language as cl', 'c.category_id', '=', 'cl.category_id')
        ->select( 'product.country_id', 'product.price', 'product.sku', 'product.points', 'product.is_kit',
          'pw.stock', 'pw.product_id', 'pw.wharehouse_id',
          'pl.name', 'pl.description', 'pl.short_description', 'pl.language_id', 'pl.nutritional_table',
          'cl.category')
          ->where([
            ['pw.wharehouse_id', '=', $whareHouse_id],
            ['pl.language_id', '=', $language_id],
            ['pl.estatus', '=', 1],
            ['product.estatus', '=', 1],
            ['cl.language_id', '=', $language_id],
            ['c.list_order', '=', $category],
            ['w.estatus', '=', 1],
            ["product.estatus",'=',1],
           ["pc.estatus",'=',1],
           ['product.is_kit','=',0],
          ])
          ->whereNotIn('product.product_id', ProductStateResctriction::where("state_id", "=", $state_id)->select('product_id'))->get();
      return $products;
    } catch (Exception $ex) {
      return null;
    }
  }

}
