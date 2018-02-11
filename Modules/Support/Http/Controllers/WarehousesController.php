<?php

namespace Modules\Support\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Warehouse;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\WarehousesRequest;

class WarehousesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:almacen.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::warehouses.index');
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
    public function store(Request $request, WarehousesRequest $warehousesRequest)
    {
        $warehouse = new Warehouse();
        $warehouse->country_id = Auth::user()->country_id;
        $warehouse->name = $request->nombre;
        $warehouse->sap_code = !empty($request->sap_code) ? $request->sap_code : 0;
        $warehouse->modified_by = Auth::user()->id;
        $warehouse->estatus = $request->estatus;

        $warehouse->save();



        return response()->json($warehouse);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            /* $warehouse = Warehouse::select('*','Warehouse.short_name')->join('Warehouse','permissions.Warehouse_id','=','Warehouse.Warehouse_id')
            ->where('permissions.status','!=',-1)->get(); */

        $data['warehouse'] = Warehouse::where('estatus','!=', -1)
                                        ->where('country_id','=',Auth::user()->country_id)
                                        ->get();


        return response()->json($data);



    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $warehouse = Warehouse::find($id);
        return response()->json($warehouse);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, WarehousesRequest $warehousesRequest)
    {
        $warehouse = Warehouse::find($id);

        $warehouse->country_id = Auth::user()->country_id;
        $warehouse->name = $request->nombre;
        $warehouse->sap_code = !empty($request->sap_code) ? $request->sap_code : 0;
        $warehouse->modified_by = Auth::user()->id;
        $warehouse->estatus = $request->estatus;
        $warehouse->save();




        return response()->json($warehouse);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::find($id);
        $warehouse->estatus = -1;
        $warehouse->deleted_at = Carbon::now();
        $warehouse->modified_by = Auth::user()->id;
        $warehouse->save();
        return response()->json([$warehouse]);
    }

    public function on($id)
    {
        $warehouse = Warehouse::find($id);
        $warehouse->estatus = 1;
        $warehouse->modified_by = Auth::user()->id;
        $warehouse->save();
        return response()->json([$warehouse]);
    }

    public function off($id)
    {

        $warehouse = Warehouse::find($id);
        $warehouse->estatus = 0;
        $warehouse->modified_by = Auth::user()->id;
        $warehouse->save();
        return response()->json($warehouse);
    }
}
