<?php

namespace Modules\Support\Http\Controllers;

use App\ProductBenefit;
use App\ProductCategory;
use App\ProductIngredient;
use App\ProductLabel;
use App\ProductRelated;
use Modules\Support\Http\Requests\ImageRequest;
use Validator;
use App\BenefitLanguage;
use App\CategoryLanguage;
use App\IngredientLanguage;
use App\LabelLanguage;
use App\Language;
use App\Product;
use App\ProductLanguage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\IngredientRequest;
use Modules\Support\Http\Requests\ProductsRequest;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:products.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::products.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('support::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, ProductsRequest $productsRequest)
    {
        $product = Product::updateOrCreate(
            ['country_id' => Auth::user()->country_id,'sku' => $request->sku,],
            ['price' => $request->price,   'points' => $request->points,
             'is_kit' => $request->is_kit, 'modified_by' => Auth::user()->id,
             'estatus' => $request->estatus]
        );

        $productsLanguage = ProductLanguage::updateOrCreate(
            ['product_id' => $product->product_id,'language_id' => $request->language_id,],
            ['name' => $request->name,                           'description' => $request->description,
             'short_description' => $request->short_description, 'consupsion_tips' => $request->consupsion_tips,
             'nutritional_table' => $request->nutritional_table, 'video_url' => $request->video_url,
             'modified_by' => Auth::user()->id,                  'estatus' => $request->estatus]
        );

        return response()->json($product->product_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data['select'] = Language::where('estatus','!=', -1)->get();

        $data['category'] = CategoryLanguage::select('*','category_language.estatus')
            ->join('category', 'category_language.category_id', '=', 'category.category_id')
            ->where('category_language.estatus', 1)
            ->where('category.country_id', Auth::user()->country_id)
            ->groupBy('category_language.category_id')
            ->with('language')->get();

        $data['label'] = LabelLanguage::select('*','labels_language.estatus')
            ->join('labels', 'labels_language.label_id', '=', 'labels.label_id')
            ->where('labels_language.estatus', 1)
            ->where('labels.country_id', Auth::user()->country_id)
            ->groupBy('labels_language.label_id')
            ->with('language')->get();

        $data['ingredient'] = IngredientLanguage::select('*','ingredient_language.estatus')
            ->join('ingredient', 'ingredient_language.ingredient_id', '=', 'ingredient.ingredient_id')
            ->where('ingredient_language.estatus', 1)
            ->where('ingredient.country_id', Auth::user()->country_id)
            ->groupBy('ingredient_language.ingredient_id')
            ->with('language')->get();

        $data['benefit'] = BenefitLanguage::select('*','benefit_language.estatus')
            ->join('benefit', 'benefit_language.benefit_id', '=', 'benefit.benefit_id')
            ->where('benefit_language.estatus', 1)
            ->where('benefit.country_id', Auth::user()->country_id)
            ->groupBy('benefit_language.benefit_id')
            ->with('language')->get();

        $data['products'] = ProductLanguage::select('*')
            ->join('product', 'product_language.product_id', '=', 'product.product_id')
            ->where('product_language.estatus','!=', -1)
            ->where('product.country_id', Auth::user()->country_id)
            ->groupBy('product_language.product_id')
            ->orderBy('product.sku')
            ->with('language')->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {

        $data['products'] = ProductLanguage::select('*','product_language.estatus')
            ->join('product', 'product_language.product_id', '=', 'product.product_id')
            ->where('product_language.product_language_id',$id)
            ->where('product_language.estatus','!=', -1)
            ->where('product.country_id', Auth::user()->country_id)
            ->with('language')->first();

        $data['category']   = ProductCategory::where('product_id', $data['products']->product_id)->where('estatus', 1)->get();
        $data['label']      = ProductLabel::where('product_id', $data['products']->product_id)->where('estatus', 1)->get();
        $data['ingredient'] = ProductIngredient::where('product_id', $data['products']->product_id)->where('estatus', 1)->get();
        $data['benefit']    = ProductBenefit::where('product_id', $data['products']->product_id)->where('estatus', 1)->get();
        $data['related']    = ProductRelated::where('product_id', $data['products']->product_id)->where('estatus', 1)->get();

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, IngredientRequest $ingredientRequest)
    {
        $ingredientLanguage = ProductLanguage::find($id);
        $ingredientLanguage->ingredient = $request->ingredient;
        $ingredientLanguage->language_id = $request->language_id;
        $ingredientLanguage->modified_by = Auth::user()->id;
        $ingredientLanguage->estatus = $request->estatus;
        $ingredientLanguage->save();

        $ingredient = Product::find($ingredientLanguage->ingredient_id);
        $ingredient->modified_by = Auth::user()->id;
        $ingredient->estatus = $request->estatus;
        $ingredient->save();

        return response()->json($ingredientLanguage);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $ProductLanguage = ProductLanguage::find($id);
        $ProductLanguage->deleted_at = date("Y-m-d H:i:s");
        $ProductLanguage->modified_by = Auth::user()->id;
        $ProductLanguage->estatus = -1;
        $ProductLanguage->save();

        $ingredient = Product::find($ProductLanguage->product_id);
        $ingredient->deleted_at = date("Y-m-d H:i:s");
        $ingredient->modified_by = Auth::user()->id;
        $ingredient->estatus = -1;
        $ingredient->save();

        return response()->json($ProductLanguage);
    }

    public function on($id)
    {
        $ProductLanguage = ProductLanguage::find($id);
        $ProductLanguage->estatus = 1;
        $ProductLanguage->modified_by = Auth::user()->id;
        $ProductLanguage->save();

        $product = Product::find($ProductLanguage->product_id);
        $product->modified_by = Auth::user()->id;
        $product->estatus = 1;
        $product->save();
        return response()->json($ProductLanguage);
    }

    public function off($id)
    {
        $ProductLanguage = ProductLanguage::find($id);
        $ProductLanguage->estatus = 0;
        $ProductLanguage->modified_by = Auth::user()->id;
        $ProductLanguage->save();

        $product = Product::find($ProductLanguage->product_id);
        $product->modified_by = Auth::user()->id;
        $product->estatus = 0;
        $product->save();
        return response()->json($ProductLanguage);
    }

    public function uploadImage(Request $request, ImageRequest $imageRequest)
    {
        if ($request->has('file-input')) {
            $bannerName = $request->name . "." . $request->file('file-input')->clientExtension();
            $request->file('file-input')->storeAs("img/img-products", $bannerName);
        }

        return response()->json($request);

    }

    public function actionExtras(Request $request) {

        switch ($request->type) {
            case "category":
                $action =  ProductCategory::updateOrCreate(
                    ['product_id' => $request->product_id_new,'category_id' => $request->category_id],
                    ['modified_by' => Auth::user()->id,'estatus' => $request->estatus]
                );

                break;
            case "label":
                $action =  ProductLabel::updateOrCreate(
                    ['product_id' => $request->product_id_new,'label_id' => $request->label_id],
                    ['estatus' => $request->estatus]
                );
                break;
            case "ingredient":
                $action = ProductIngredient::updateOrCreate(
                    ['product_id' => $request->product_id_new,'ingredient_id' => $request->ingredient_id],
                    ['modified_by' => Auth::user()->id,'estatus' => $request->estatus]
                );
                break;
            case "benefit":
                $action = ProductBenefit::updateOrCreate(
                    ['product_id' => $request->product_id_new,'benefit_id' => $request->benefit_id],
                    ['modified_by' => Auth::user()->id,'estatus' => $request->estatus]
                );
                break;
            case "related":
                $action = ProductRelated::updateOrCreate(
                    ['product_id' => $request->product_id_new,'product_id_related' => $request->product_id],
                    ['modified_by' => Auth::user()->id,'estatus' => $request->estatus]
                );
                break;
        }

        return response()->json($action);


    }

}




















