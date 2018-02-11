<?php

namespace Modules\Support\Http\Controllers;


use App\Category;
use App\Language;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\CategoryLanguage;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:categories.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::categories.index');
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
    public function store(Request $request, CategoryRequest $categoryRequest)
    {
        $category = new Category();

        $category->country_id = Auth::user()->country_id;
        $category->modified_by = Auth::user()->id;
        $category->is_main_category = $request->is_main_category;
        $category->estatus = $request->estatus;
        $category->list_order = !empty($request->list_order) ? $request->list_order : 0;

        $category->save();


        $categoryLanguage = new CategoryLanguage();
        $categoryLanguage->category_id = $category->category_id;
        $categoryLanguage->language_id = $request->language_id;
        $categoryLanguage->category = $request->category;
        $categoryLanguage->estatus = $request->estatus;
        $categoryLanguage->save();

        return response()->json($categoryLanguage);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['language'] = Language::where('estatus','!=', -1)->get();


        $data['category'] = CategoryLanguage::select('*','category_language.estatus')
            ->join('category', 'category_language.category_id', '=', 'category.category_id')
            ->where('category_language.estatus','!=', -1)
            ->where('category.country_id', Auth::user()->country_id)
            ->with('language')->get();




        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        /* $category = CategoryLanguage::where('category_language_id','=', $id)
                                    ->with('category')->get(); */

        $category['category_language'] = CategoryLanguage::find($id);
        $category['category']          = Category::where('category_id',$category['category_language']->category_id)->first();
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, CategoryRequest $categoryRequest)
    {

        $categoryLanguage = CategoryLanguage::find($id);
        $categoryLanguage->language_id = $request->language_id;
        $categoryLanguage->category = $request->category;
        $categoryLanguage->estatus = $request->estatus;
        $categoryLanguage->save();

        $category = Category::find($categoryLanguage->category_id);
        $category->is_main_category = $request->is_main_category;
        $category->list_order = $request->list_order;
        $category->save();
        return response()->json($categoryLanguage);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {

        $categoryLanguage = CategoryLanguage::find($id);
        $categoryLanguage->estatus = -1;
        $categoryLanguage->deleted_at = Carbon::now();
        $categoryLanguage->save();
        return response()->json([$categoryLanguage]);
    }

    public function on($id)
    {
        $categoryLanguage = CategoryLanguage::find($id);
        $categoryLanguage->estatus = 1;
        $categoryLanguage->save();
        return response()->json([$categoryLanguage]);
    }

    public function off($id)
    {
        $categoryLanguage = CategoryLanguage::find($id);
        $categoryLanguage->estatus = 0;
        $categoryLanguage->save();
        return response()->json($categoryLanguage);
    }
}
