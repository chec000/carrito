<?php

namespace Modules\Support\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Country;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\CountryRequest;

class CountriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:countries.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::countries.index');
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
    public function store(Request $request, CountryRequest $countryRequest)
    {
        $country = new Country();
        $country->name = $request->nombre;
        $country->short_name = $request->short_name;
        $country->modified_by = Auth::user()->id;
        $country->estatus = $request->estatus;

        $country->save();



        return response()->json($country);
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


        return response()->json($data);



    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $country = Country::find($id);
        return response()->json($country);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, CountryRequest $countryRequest)
    {
        $country = Country::find($id);

        $country->name = $request->nombre;
        $country->short_name = $request->short_name;
        $country->estatus = $request->estatus;
        $country->modified_by = Auth::user()->id;
        $country->save();




        return response()->json($country);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $country = Country::find($id);
        $country->estatus = -1;
        $country->deleted_at = Carbon::now();
        $country->modified_by = Auth::user()->id;
        $country->save();
        return response()->json([$country]);
    }

    public function on($id)
    {
        $country = Country::find($id);
        $country->estatus = 1;
        $country->modified_by = Auth::user()->id;
        $country->save();
        return response()->json([$country]);
    }

    public function off($id)
    {

        $country = Country::find($id);
        $country->estatus = 0;
        $country->modified_by = Auth::user()->id;
        $country->save();
        return response()->json($country);
    }
}
