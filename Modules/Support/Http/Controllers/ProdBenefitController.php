<?php

namespace Modules\Support\Http\Controllers;

use App\Benefit;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\BenefitLanguage;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\ProdBenefitRequest;

class ProdBenefitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:benefits.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::prodbenefit.index');
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
    public function store(Request $request, ProdBenefitRequest $prodBenefitRequest)
    {
        $benefit = new Benefit();

        $benefit->country_id = Auth::user()->country_id;
        $benefit->modified_by = Auth::user()->id;
        $benefit->estatus = $request->estatus;

        $benefit->save();

        $benefitProduct = new BenefitLanguage();
        $benefitProduct->benefit_id = $benefit->id;
        $benefitProduct->language_id = $request->language_id;
        $benefitProduct->benefit = $request->benefit;
        $benefitProduct->modified_by = Auth::user()->id;
        $benefitProduct->estatus = $request->estatus;
        $benefitProduct->save();

        return response()->json($benefitProduct);
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

        $data['benefit'] = BenefitLanguage::select('*','benefit_language.estatus')
            ->join('benefit', 'benefit_language.benefit_id', '=', 'benefit.benefit_id')
            ->where('benefit_language.estatus','!=', -1)
            ->where('benefit.country_id', Auth::user()->country_id)
            ->with('language')->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $benefit = BenefitLanguage::find($id);
        return response()->json($benefit);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, ProdBenefitRequest $prodBenefitRequest)
    {
        $benefitProduct = BenefitLanguage::find($id);
        $benefitProduct->language_id = $request->language_id;
        $benefitProduct->benefit = $request->benefit;
        $benefitProduct->modified_by = Auth::user()->id;
        $benefitProduct->estatus = $request->estatus;
        $benefitProduct->save();
        return response()->json($benefitProduct);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $benefit = BenefitLanguage::find($id);
        $benefit->estatus = -1;
        $benefit->save();
        return response()->json([$benefit]);
    }

    public function on($id)
    {
        $benefit = BenefitLanguage::find($id);
        $benefit->estatus = 1;
        $benefit->save();
        return response()->json([$benefit]);
    }

    public function off($id)
    {
        $benefit = BenefitLanguage::find($id);
        $benefit->estatus = 0;
        $benefit->save();
        return response()->json($benefit);
    }
}
