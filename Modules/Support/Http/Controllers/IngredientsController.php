<?php

namespace Modules\Support\Http\Controllers;

use App\IngredientLanguage;
use App\Ingredient;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\IngredientRequest;

class IngredientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ingredients.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::ingredients.index');
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
    public function store(Request $request, IngredientRequest $ingredientRequest)
    {
        $ingredient = new Ingredient();
        $ingredient->country_id = Auth::user()->country_id;
        $ingredient->modified_by = Auth::user()->id;
        $ingredient->estatus = $request->estatus;
        $ingredient->save();

        $ingredientLanguage = new IngredientLanguage();
        $ingredientLanguage->ingredient_id = $ingredient->ingredient_id;
        $ingredientLanguage->language_id = $request->language_id;
        $ingredientLanguage->ingredient = $request->ingredient;
        $ingredientLanguage->modified_by = Auth::user()->id;
        $ingredientLanguage->estatus = $request->estatus;
        $ingredientLanguage->save();

        return response()->json($ingredientLanguage);
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

        $data['ingredient'] = IngredientLanguage::select('*','ingredient_language.estatus')
            ->join('ingredient', 'ingredient_language.ingredient_id', '=', 'ingredient.ingredient_id')
            ->where('ingredient_language.estatus','!=', -1)
            ->where('ingredient.country_id', Auth::user()->country_id)
            ->with('language')->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $label = IngredientLanguage::find($id);
        return response()->json($label);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, IngredientRequest $ingredientRequest)
    {
        $ingredientLanguage = IngredientLanguage::find($id);
        $ingredientLanguage->ingredient = $request->ingredient;
        $ingredientLanguage->language_id = $request->language_id;
        $ingredientLanguage->modified_by = Auth::user()->id;
        $ingredientLanguage->estatus = $request->estatus;
        $ingredientLanguage->save();

        $ingredient = Ingredient::find($ingredientLanguage->ingredient_id);
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
        $ingredientLanguage = IngredientLanguage::find($id);
        $ingredientLanguage->deleted_at = date("Y-m-d H:i:s");
        $ingredientLanguage->modified_by = Auth::user()->id;
        $ingredientLanguage->estatus = -1;
        $ingredientLanguage->save();

        $ingredient = Ingredient::find($ingredientLanguage->ingredient_id);
        $ingredient->deleted_at = date("Y-m-d H:i:s");
        $ingredient->modified_by = Auth::user()->id;
        $ingredient->estatus = -1;
        $ingredient->save();

        return response()->json($ingredientLanguage);
    }

    public function on($id)
    {
        $ingredientLanguage = IngredientLanguage::find($id);
        $ingredientLanguage->estatus = 1;
        $ingredientLanguage->modified_by = Auth::user()->id;
        $ingredientLanguage->save();

        $ingredient = Ingredient::find($ingredientLanguage->ingredient_id);
        $ingredient->modified_by = Auth::user()->id;
        $ingredient->estatus = 1;
        $ingredient->save();
        return response()->json($ingredientLanguage);
    }

    public function off($id)
    {
        $ingredientLanguage = IngredientLanguage::find($id);
        $ingredientLanguage->estatus = 0;
        $ingredientLanguage->modified_by = Auth::user()->id;
        $ingredientLanguage->save();

        $ingredient = Ingredient::find($ingredientLanguage->ingredient_id);
        $ingredient->modified_by = Auth::user()->id;
        $ingredient->estatus = 0;
        $ingredient->save();
        return response()->json($ingredientLanguage);
    }
}
