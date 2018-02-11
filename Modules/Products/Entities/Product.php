<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\ProductPackage;
use Modules\Products\Entities\Models\ProductModel;
use Illuminate\Support\Facades\DB;
use Modules\Products\Entities\Models\Package;
use Exception;

/**
 * Description of EFProduct
 *
 * @author sergio
 */
class Product extends Model {

    /**     * Columns required to save row     *     * @var array     */
    protected $fillable = [];

    /**     *     * The name of the table that will be saving the data     *     * @var string     */
    protected $table = 'product';
    protected $primaryKey = "product_id";

    public function category() {
        return $this->belongsToMany('Modules\Products\Entities\ProductCategory');
    }

    public function benefit() {
        return $this->belongsToMany('Modules\Products\Entities\ProductBenefit');
    }

    public function getDateProduct($product_id) {
        
        $information_product = array(
            "benefits" => $this->getBenfitsByProduct($product_id),
            "ingredients" => $this->getIngredientsbyProduct($product_id),
            "labels" => $this->labelsByProduct($product_id),
          "packages" => $this->buidPackage($this->getPackageByProduct($product_id)),
            "product_description" => $this->productLanguage($product_id),
            "users_testimonies" => $this->getProductTestimony($product_id),
            "products_related" => $this->getProductModel($this->getProductsRelated($product_id))
        );
        return $information_product;
    }
private function getProductModel($products) {
      $productsModel= array();
      foreach ($products as $product){   
          $productModel = new ProductModel();
         $productModel->setProduct_id($product->product_id);
        $productModel->setSku($product->sku);
        $productModel->setPoints($product->points);
        $productModel->setDescripction($product->description);
        $productModel->setName($product->name);
        $productModel->setPrice($product->price);
        $productModel->setIs_kit($product->is_kit);
       $productModel->setConsuption_tips($product->consupsion_tips);
        $productModel->setNutritional_table($product->nutritional_table);
        $productModel->setVideo_url($product->video_url);
            array_push($productsModel,$productModel);
      }        
      return $productsModel;
    }
    
    private function buidPackage($packages) {
        $combos = array();
        $packages_number = 0;
        foreach ($packages as $value) {
            $package = new Package();
            $price = 0;$points = 0; $list_products = array();
            foreach ($value as $p) {
                $price += $p->price;
                $points += $p->points;
                $product = array(
                    "product" => $p->name,
                    "product_id" => $p->product_id,
                     "price"=>$p->price,
                     "points"=>$p->points,
                    "package_id"=>$p->package_id,
                    "quantity"=>$p->quantity,
                    "sku"=>$p->sku,
                     "description"=>$p->description,
                     "isCombo"=>true);
                array_push($list_products, $product);
            }
            $packages_number = $packages_number + 1;
            $package->setNumber_package($packages_number);
            $package->setProducts($list_products);
            $package->setPoints($points);
            $package->setPrice($price);
            $package->setImage($value[0]->image_package);
            $package->setPackage_id($value[0]->package_id);
            $package->setName($value[0]->package_name);
            $package->setDescription($value[0]->p_description);
            $package->setPackage_id($value[0]->package_id);
            $package->setQuantity($value[0]->quantity);
            $package->setIsCombo(true);
            array_push($combos,$package);
        }
        return $combos;
    }
    
    private function labelsByProduct($product_id) {
                         $language_id =session()->get('lang_id')->language_id;  
        try {
                    $labels = DB::table('product_labels as pl')
                        ->join('labels_language as ll', 'll.label_id', '=', 'pl.label_id')
                        ->join('product as p', 'p.product_id', '=', 'pl.product_id')
                        ->where([['p.product_id', '=', $product_id],
                             ['ll.estatus','=',1],   
                              ['ll.language_id','=',$language_id], 
                              ['p.estatus', '=', 1],
                            ]
                            )
                        ->select('ll.name')->get();
        } catch (Exception $ex) {
            return null;
        }

        return $labels;
    }

    private function getBenfitsByProduct($product_id) {    
        try{
                $language_id =session()->get('lang_id')->language_id;  
                    $benefits = DB::table('product as p')
                        ->join("product_language as pl",'pl.product_id','p.product_id')
                        ->where([['p.product_id', '=', $product_id],
                             ['pl.language_id', '=', $language_id],
                            ['p.estatus', '=', 1],
                             ['pl.estatus', '=', 1],

                            ])
                        ->select('pl.bennefit')->distinct()->get();            
        }catch(Exception $e){            
            return null;
        }
        return $benefits;
    }

    private function getIngredientsbyProduct($product_id) {  
        try{
                $language_id =session()->get('lang_id')->language_id;       
                    $ingredients = DB::table('product_ingredient as pi')
                        ->join('ingredient as i', 'i.ingredient_id', '=', 'pi.ingredient_id')
                        ->join('product as p', 'p.product_id', '=', 'pi.product_id')
                        ->join('ingredient_language as il', 'il.ingredient_id', '=', 'i.ingredient_id')
                        ->where([['p.product_id', '=', $product_id],
                                ['il.language_id', '=', $language_id],
                                 ['p.estatus', '=', 1],
                                ])
                        ->select('il.ingredient')->distinct()->get();
        }catch(Exception $ex){
            return null;           
        }     
        return $ingredients;
    }

    private function getPackageByProduct($product_id) {
        try {
            $package_id = ProductPackage::where(
                    'product_id', '=', $product_id)->select('package_id')->get();
            $list_packages = array();
            foreach ($package_id as $value) {
                $package = DB::table('product_package as pp')
                                ->join('package_language as pl', 'pl.package_id', '=', 'pp.package_id')
                                ->join('package as p', 'p.package_id', '=', 'pp.package_id')
                                ->join('product_language as prl', 'prl.product_id', '=', 'pp.product_id')
                                ->join('product as pro', 'pro.product_id', '=', 'pp.product_id')
                                ->where([['pp.package_id', '=', $value->package_id],
                                        ['pl.language_id','=',session()->get('lang_id')->language_id],
                                        ['prl.language_id','=',session()->get('lang_id')->language_id],
                                       ['pl.estatus', '=', 1],
                                       ['prl.estatus', '=', 1],
                                      ['pro.estatus', '=', 1],
                                        ])
                                ->select('p.*', 'pro.product_id as id', 'pp.*', 'pl.*', 'pl.name as package_name',
                                        'pl.description as p_description', 'prl.name', 'pro.*')
                        ->distinct()->get();
                array_push($list_packages, $package);
            }
        } catch (Exception $e) {          
            $e->getMessage();
            $list_packages = null;           
        }
        return $list_packages;
    }
    
    private function getProductTestimony($product_id) {
        try{
              $language_id =session()->get('lang_id')->language_id;                   
                    $user_testimony = DB::table('testimony as ut')
                        ->join('product as p', 'p.product_id', '=', 'ut.product_id')
                        ->join('country as c', 'c.country_id', '=', 'ut.country_id')
                        ->where([['p.product_id', '=', $product_id],
                                ['ut.language_id', '=', $language_id],
                                ['p.estatus', '=', 1],
                                ])
                        ->where('c.country_id', '=', session()->get('language.0.language_id'))
                        ->select('ut.name','ut.last_name','ut.photo','ut.testimony', 'c.name as country')->get();
        } catch (Exception $ex){
            return null;
        }

        return $user_testimony;
    }

    private function getProductsRelated($product_id) {
        try{
              $language_id =session()->get('lang_id')->language_id;         
                   $products_related = DB::table('product as p')
                        ->join('product_language as pl', 'pl.product_id', '=', 'p.product_id')
                        ->join("products_related as pr", 'pr.product_id_related', '=', 'p.product_id')
                        ->where(
                                [['pr.product_id', '=', $product_id],
                                 ['pl.language_id', '=', $language_id],
                                 ['pl.estatus', '=', 1],
                                 ['pr.estatus', '=', 1],
                                 ['p.estatus', '=', 1],
                                ])
                        ->select('p.*', 'pl.*')->get(); 
        } catch (Exception $e){
            return null;            
        }
        return $products_related;
    }

    public function productLanguage($product_id) {
        return ProductLanguage::where([['product_id', '=', $product_id],
             ['language_id', '=', session()->get('lang_id')->language_id]])->get();
    }  
    public function getKits(){
      try {
            $state_id = session()->get('state_id');
            $kits = DB::table('product')
          ->join('product_language as pl', 'product.product_id', '=', 'pl.product_id')
          ->select( 'product.product_id', 'product.price', 'product.sku', 'product.points',
            'pl.name', 'pl.description', 'pl.short_description', 'pl.language_id', 'pl.nutritional_table')
            ->where([
              ['pl.language_id', '=', session()->get('lang_id')->language_id],
              ['product.estatus', '=', 1],
              ['product.is_kit', '=', 1],
              ['product.estatus', '=', 1],
            ])
            ->whereNotIn('product.product_id', ProductStateResctriction::where("state_id", "=", $state_id)->select('product_id'))->get(); 
      } catch (Exception $ex) {
          return null;
      }
        return $kits;
    }
}
