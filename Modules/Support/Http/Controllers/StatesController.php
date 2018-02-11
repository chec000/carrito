<?php

namespace Modules\Support\Http\Controllers;

use App\Benefit;
use App\Country;
use App\Language;
use App\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\BenefitLanguage;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\ProdBenefitRequest;
use Modules\Support\Http\Requests\StatesRequest;

class StatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:states.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::states.index');
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
    public function store(Request $request, StatesRequest $statesRequest)
    {
        $state = new State();
        $state->state = $request->state;
        $state->country_id = $request->country_id;
        //$state->modified_by = Auth::user()->id;
        $state->estatus = $request->estatus;
        $state->save();

        return response()->json($state);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['country'] = Country::where('estatus','!=', -1)->get();

        $data['state'] = State::where('estatus','!=', -1)->with('country')->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $state = State::find($id);
        return response()->json($state);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, StatesRequest $statesRequest)
    {
        $state = State::find($id);
        $state->state = $request->state;
        $state->country_id = $request->country_id;
        $state->estatus = $request->estatus;
        $state->save();
        return response()->json($state);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $state = State::find($id);
        $state->estatus = -1;
        $state->save();
        return response()->json([$state]);
    }

    public function on($id)
    {
        $state = State::find($id);
        $state->estatus = 1;
        $state->save();
        return response()->json([$state]);
    }

    public function off($id)
    {
        $state = State::find($id);
        $state->estatus = 0;
        $state->save();
        return response()->json($state);
    }
}
