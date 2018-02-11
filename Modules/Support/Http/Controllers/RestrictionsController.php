<?php

namespace Modules\Support\Http\Controllers;

use App\IngredientLanguage;
use App\Ingredient;
use App\ProductLanguage;
use App\ProductRestriction;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\IngredientRequest;
use Modules\Support\Http\Requests\RestrictionRequest;

class RestrictionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::restrictions.index');
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
    public function store(Request $request, RestrictionRequest $restrictionRequest)
    {

        $action = ProductRestriction::updateOrCreate(
            ['product_id' => $request->product_id,'state_id' => $request->state_id],
            ['modified_by' => Auth::user()->id,'estatus' => $request->estatus]
        );

        return response()->json($action);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['product'] = ProductLanguage::select('*','product_language.estatus')
            ->join('product', 'product.product_id', '=', 'product_language.product_id')
            ->where('product_language.estatus', '!=', -1)
            ->where('product.country_id', Auth::user()->country_id)->get();

        $data['state'] = State::where('country_id', Auth::user()->country_id)
            ->where('estatus', '!=' , -1)->get();

        $data['restrictions'] = ProductRestriction::select('*','product_state_restriction.estatus')
            ->join('product', 'product.product_id', '=', 'product_state_restriction.product_id')
            ->where('product_state_restriction.estatus','!=', -1)
            ->where('product.country_id', Auth::user()->country_id)
            ->with('product')
            ->with('state')
            ->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $action = ProductRestriction::find($id);
        $action->deleted_at = date("Y-m-d H:i:s");
        $action->modified_by = Auth::user()->id;
        $action->estatus = -1;
        $action->save();

        return response()->json($action);
    }

    public function on($id)
    {
        $action = ProductRestriction::find($id);
        $action->estatus = 1;
        $action->modified_by = Auth::user()->id;
        $action->save();

        return response()->json($action);
    }

    public function off($id)
    {
        $action = ProductRestriction::find($id);
        $action->estatus = 0;
        $action->modified_by = Auth::user()->id;
        $action->save();

        return response()->json($action);
    }
}
