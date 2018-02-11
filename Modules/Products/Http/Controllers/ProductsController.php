<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Products\Entities\Country;
use Modules\Products\Entities\BenefitLanguage;
use Modules\Products\Entities\CategoryLanguage;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductCategory;
use Modules\Products\Entities\Wharehouse;

class ProductsController extends Controller {

    protected $request;

    public function __contruct(Request $request) {
        $this->$request = $request;
    }

    public function index() {      
        return view('products::index');
    }

    public function detailProduct() {
        return view('products::detailProducts');
    }

    private $order_column = "pl.name";
    private $type_order = "asc";

    /**
     * @Name:filterProductByCategory
      @Description:Obtiene los productos por categoria, pasando el id categoria
      @params: $id ,$orderBy
      @return: $producs
     */
    public function filterProductByCategory($id, $orderBy = 0) {
        $this->getParametersOrder($orderBy);
         if ($id==0) {
            $id= session()->get("category_id");
        }
        $country_id = $this->getCountry();
        $productsWharehouse = new Wharehouse;
        $params = array(
            "table_name" => 'product_category',
            "column_name" => 'category_id',
            "order_column" => $this->order_column,
            "id_table" => $id,
            "type_order" => $this->type_order,
            "country_id" => $country_id['country_id'],
            "state_id" => session()->get('state_id'),
            "language_id" => session()->get('lang_id')->language_id,
            "whare_house_id" => session()->get('wh_id')
        );
        
        $category=new CategoryLanguage();
        $url="products/productsCategory".'/'.$id;
        $urlSelected=$category->getCategoryName($id,session()->get('lang_id')->language_id);
        $products = $productsWharehouse->getProductsByParamas($params);
           session()->put('url-name',$urlSelected);
          session()->put('url-breadcrumb',$url);
        return compact('products','urlSelected','url');
    }

    /**
     * @Name:getProductById
      @Description: Obtiene el producto por su id_product
      @params: $id _product:""
      @return: $produc
     */
    public function getProductById($id_product=0, $product_home = false) {
            $urlSelected=   session()->get('url-name');
             $url= session()->get('url-breadcrumb');
             if ($url===""||$url===null) {
                 $url="products";
             }
        if ($id_product==0) {
            $id_product= session()->get('product_selected');
            $listBenefits = $this->getBenefits();
          $listCategories = $this->getCategories();
           $urlSelected= $this->getProductNameByIdLanguage(session()->get('lang_id')->language_id);
        }
        
        $product = Product::where("estatus","=",1)->find($id_product);
        if ($product!==null) {
        $pbObj = new Product();
         $product_language = $pbObj->productLanguage($id_product);
         $product_benefits = $pbObj->getDateProduct($id_product);
        $product_selected=$product_language[0]['name'];

        $productCategoryEntity = new ProductCategory();
        $product_category = $productCategoryEntity->getCategoryProductByIdProduct($id_product);
        $notShowTblNutri = array(4,10);
        $product_category['showTableNutri'] = in_array($product_category['category_id'], $notShowTblNutri) ? false : true;
        $redirect_home = $product_home != false ? true : false;


        }
        
      return compact('product', 'product_language', 'product_benefits','urlSelected','product_selected','url','listBenefits','listCategories','product_category', '$redirect_home');
    }
   public function getProductByIdProduct($idProduct){
       session()->forget('product_selected');
       session()->put('product_selected',$idProduct);  
   // return $this->filterProductsByBenefitsId();
         return view('products::index');
   }
    /**
     * @Name:getWhareHouse
      @Description: Obtiene el almacen de la base de datos
      @params: $id _product
      @return: $produc
     */
    private function getProductsWhareHouse($params) {
       $productsWharehouse = new Wharehouse;
        return $productsWharehouse->getProductsByWharehouse($params);
    }
    public function getAllProducts($name){
         $country_id = $this->getCountry();
              $params = array(
            "name"=>$name,
            "country_id" => $country_id['country_id'],
            "state_id" => $this->getState(session()->get('zip.0.state')),
            "language_id" => session()->get('lang_id')->language_id,
            "whare_house_id" => $this->getWhareHouse(UrlService::webService($this->getGlobalWharehouse()))
        );
        $productsWharehouse = new Wharehouse;
        return $productsWharehouse->getAllProducts($params);
    }

    /**
     * @Name:getProductById
      @Description: Obtiene todos los produtos,beneficios, categorias que existen
      @params: $id _product
      @return: $produc
     */
    public function getDataProducts($order = 0) {
        $this->getParametersOrder($order);
        $country_id = $this->getCountry();
        $params = array(
            "order_column" => $this->order_column,
            "type_order" => $this->type_order,
            "country_id" => $country_id['country_id'],
            "state_id" => session()->get('state_id'),
            "language_id" => session()->get('lang_id')->language_id,
            "whare_house_id" => session()->get('wh_id')
        );
        $benefits = $this->getBenefits();
        $categories = $this->getCategories();
        $products = $this->getProductsWhareHouse($params);
   
//        $productsWharehouse = new Wharehouse;
//        if(session()->get('typeLastSearch') == 'params')        {
//            $products = $productsWharehouse->getProductsByParamas($params, true);
//        } elseif (session()->get('typeLastSearch') == 'name') {
//            $products = $productsWharehouse->getProductsByName($params, true);
//        }

        $urlSelected= $this->getProductNameByIdLanguage(session()->get('applocale'));
        $url="/products";
        session()->put('url-breadcrumb',$url);
        session()->put('url-name',$urlSelected);
        return compact('categories', 'benefits', 'products','urlSelected','url');
    }

      public function getDataProductsOrder($order = 0) {
        $this->getParametersOrder($order);
        $country_id = $this->getCountry();
        $params = array(
            "order_column" => $this->order_column,
            "type_order" => $this->type_order,
            "country_id" => $country_id['country_id'],
            "state_id" => session()->get('state_id'),
            "language_id" => session()->get('lang_id')->language_id,
            "whare_house_id" => session()->get('wh_id')
        );
        $benefits = $this->getBenefits();
        $categories = $this->getCategories();
//        $products = $this->getProductsWhareHouse($params);
   
        $productsWharehouse = new Wharehouse;
        if(session()->get('typeLastSearch') == 'params')        {
            $products = $productsWharehouse->getProductsByParamas($params, true);
        } elseif (session()->get('typeLastSearch') == 'name') {
            $products = $productsWharehouse->getProductsByName($params, true);
        }

        $urlSelected= $this->getProductNameByIdLanguage(session()->get('applocale'));
        $url="/products";
        session()->put('url-breadcrumb',$url);
        session()->put('url-name',$urlSelected);
        return compact('categories', 'benefits', 'products','urlSelected','url');
    }
    public function getCategories() {
        $country_id = $this->getCountry();
        $categoryObject = new CategoryLanguage();
        return $categoryObject->getCategoryByCountry($country_id,session()->get('lang_id')->language_id);
    }


    private function getBenefits() {
        $country_id = $this->getCountry();
        $benefitObject = new BenefitLanguage();
        return $benefitObject->getBenefitByCountry($country_id,session()->get('lang_id')->language_id);
    }
   private function  getProductNameByIdLanguage($id){
       $products="";
       $id= session()->get('applocale');
       switch ($id){
           case "es":
               $products= "Productos";
               break;
           case "en":
               $products="Products";
                 break;
           case "por":
               $products="Produtos";
             break;
               case "rus":
               $products="Produkte";
             break;
                   case "ita":
               $products="produrre";
             break;
         default :
                $products= "Productos";
                break;
       }
   return $products;
   }

   public function products() {
        return view('products::index');
    }


    public function searchProductsByParms() {
        $queryParams = request()->query();
        $queryParams['name'];
        session()->forget('name');
        session()->put('name', $queryParams['name']);
        return view('products::index');
    }

    public function allProducts() {
        $country_id = $this->getCountry();
        $params = array(
            "name" => session()->get('name'),
            "country_id" => $country_id['country_id'],
            "state_id" => session()->get('state_id'),
            "language_id" => session()->get('lang_id')->language_id,
            "whare_house_id" => session()->get('wh_id'),
              "order_column" => $this->order_column,
            "type_order" => $this->type_order,
        );
        $productsWharehouse = new Wharehouse;
      $products = $productsWharehouse->getAllProducts($params);
     
        $url="products";
        $urlSelected= $this->getProductNameByIdLanguage(session()->get('lang_id')->language_id);
        session()->put('url-breadcrumb',$url);
        session()->put('url-name',$urlSelected);
        $benefits = $this->getBenefits();
        $categories = $this->getCategories();
 
        return compact('categories', 'benefits', 'products','urlSelected','url');
    }

    public function getProductsByCategoryId($id) {
        session()->forget('category_id');
        session()->put('category_id', $id);
        return view('products::index');
    }
public function getProductsByBenefitId($id) {
        session()->forget('benefit_id');
        session()->put('benefit_id', $id);
   // return $this->filterProductsByBenefitsId();
         return view('products::index');
    }

    public function getAllproductsByCategory() {
        $id = session()->get('category_id');
        $productsWharehouse = new Wharehouse;
        $country_id = $this->getCountry();
        $params = array(
            "table_name" => 'product_category',
            "column_name" => 'category_id',
            "order_column" => $this->order_column,
            "id_table" => $id,
            "type_order" => $this->type_order,
            "country_id" => $country_id['country_id'],
            "state_id" => session()->get('state_id'),
            "language_id" => session()->get('lang_id')->language_id,
            "whare_house_id" => session()->get('wh_id')
        );
        $products = $productsWharehouse->getProductsByParamas($params);
        $benefits = $this->getBenefits();
        $categories = $this->getCategories();
         $category= new CategoryLanguage();
         $urlSelected=$category->getCategoryName($id,session()->get('lang_id')->language_id);
         $url="products/productsCategory".'/'.$id;
          session()->put('url-name',$urlSelected);
          session()->put('url-breadcrumb',$url);
        return compact('categories', 'benefits', 'products','urlSelected','url');
    }

    /* 1.- Puntos más altos productsBenefits
     * 2.-Puntos estrella
     * 3.-menor a mayor
     * 4mayor a menor
     */

    private function getParametersOrder($order) {
        switch ($order) {
            case 1:
                $this->order_column = "p.price";
                $this->type_order = "desc";
                break;
            case 2:
                $this->order_column = "p.points";
                $this->type_order = "desc";
                break;
            case 3:
                $this->order_column = "pl.name";
                $this->type_order = "asc";
                break;
            case 4:
                $this->order_column = "pl.name";
                $this->type_order = "desc";
                break;
            default :
        }
    }

    /**
     * @Name:filterProductsByBenefits
      @Description: Obtiene los productos relacionados con su beneficio
      @params: $id _product
      @return: $produc
     */
    public function filterProductsByBenefits($id, $orderBy = 0) {
        $this->getParametersOrder($orderBy);
        $productsWharehouse = new Wharehouse;       
        $country_id = $this->getCountry();
        $params = array(
            "table_name" => 'product_benefit',
            "column_name" => 'benefit_id',
            "order_column" => $this->order_column,
            "id_table" => $id,
            "type_order" => $this->type_order,
            "country_id" => $country_id['country_id'],
            "state_id" => session()->get('state_id'),
            "language_id" =>session()->get('lang_id')->language_id,
            "whare_house_id" => session()->get('wh_id')
        );
        $benefit= new BenefitLanguage();
        $urlSelected=$benefit->getBenefitName($id,session()->get('lang_id')->language_id);
        $products = $productsWharehouse->getProductsByParamas($params);
           $url="products/productsBenefit".'/'.$id;
           session()->put('url-breadcrumb',$url);
           session()->put('url-name',$urlSelected);
           return compact('products','urlSelected','url');
    }
    public function filterProductsByBenefitsId() {
        $id= session()->get('benefit_id');
        $this->getParametersOrder(3);
        $productsWharehouse = new Wharehouse;
        $country_id = $this->getCountry();
        $params = array(
            "table_name" => 'product_benefit',
            "column_name" => 'benefit_id',
            "order_column" => $this->order_column,
            "id_table" => $id,
            "type_order" => $this->type_order,
            "country_id" => $country_id['country_id'],
            "state_id" => session()->get('state_id'),
            "language_id" => session()->get('lang_id')->language_id,
            "whare_house_id" => session()->get('wh_id')
        );
         $benefits = $this->getBenefits();
        $categories = $this->getCategories();
        $benefit= new BenefitLanguage();
        $urlSelected=$benefit->getBenefitName($id,session()->get('lang_id')->language_id);
        $products = $productsWharehouse->getProductsByParamas($params);
       $url="products/productsBenefit".'/'.$id;
       session()->put('url-breadcrumb',$url);
     //  $type="benefit";
      // session()->forget('benefit_id');
        session()->put('url-name',$urlSelected);
        return compact('products','benefits','categories','urlSelected','url','benefit');
    }
    /**
     * Nombre:
     */
    private function getCountry() {
        $country_id = Country::select('country_id')->where('short_name', session()->get('country'))
                ->orWhere('name', session()->get('country'))
                ->first();
        return $country_id;
    }

    /**
     * @Name:searchProducts
      @Description: Obtiene los productos buscados
      @params: $request(nombre del producto)
      @return: $produc
     */
    public function searchProducts($request) {
           $country_id = $this->getCountry();
        $this->getParametersOrder(3);
        $productsWharehouse = new Wharehouse;
        $params = array(
            "table_name" => 'product_category',
            "column_name" => 'category_id',
            "request" => $request,
            "country_id" => $country_id['country_id'],
            "state_id" =>session()->get('state_id'),
            "language_id" => session()->get('lang_id')->language_id,
            "whare_house_id" => session()->get('wh_id'),
            "order_column" => $this->order_column,
            "type_order" => $this->type_order,
        );
       $url="products";
        $urlSelected= $this->getProductNameByIdLanguage(session()->get('lang_id')->language_id); 
        session()->put('url-name',$urlSelected);
       session()->put('url-breadcrumb',$url);
        $products = $productsWharehouse->getProductsByName($params);
        return compact('products','url','urlSelected');
    }

    public function getProductsHome() {
        $whereHouse = new Wharehouse();
        $whare_house_id = session()->get('wh_id');
        $language_id = session()->get('lang_id')->language_id;
        $state_id = session()->get('state_id');
        $products = array(
          'categories' => array(
            'newReleases' => $whereHouse->getMainCategory($whare_house_id, $language_id, $state_id, 1),
            'starProducts' => $whereHouse->getMainCategory($whare_house_id, $language_id, $state_id, 2),
            'seasonProducts' => $whereHouse->getMainCategory($whare_house_id, $language_id, $state_id, 3),
          ),
          'titles' => array()
        );
        return $products;
    }

}
