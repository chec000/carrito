<?php

namespace Modules\Support\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Permission;
use App\Language;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\PermissionsRequest;

class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:permissions.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::permissions.index');
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
    public function store(Request $request, PermissionsRequest $PermissionRequest)
    {
        $permission = new Permission();
        $permission->title = $request->nombre;
        $permission->alias = $request->alias;
        $permission->description = $request->description;
        $permission->status = $request->estatus;
        $permission->country_id = Auth::user()->country_id;
        $permission->language_id = $request->language_id;
        $permission->modified_by = Auth::user()->id;

        $permission->save();



        return response()->json($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            /* $permission = Permission::select('*','language.short_name')->join('language','permissions.language_id','=','language.language_id')
            ->where('permissions.status','!=',-1)->get(); */

        $data['language'] = Language::where('estatus','!=', -1)->get();

        $data['permission'] = Permission::select('*','language.short_name')->join('language','permissions.language_id','=','language.language_id')
            ->where('permissions.status','!=', -1)
            ->where('permissions.country_id', Auth::user()->country_id)
            ->with('language')->get();

        return response()->json($data);



    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, PermissionsRequest $PermissionRequest)
    {
        $permission = Permission::find($id);
        $permission->title = $request->nombre;
        $permission->alias = $request->alias;
        $permission->description = $request->description;
        $permission->status = $request->estatus;
        $permission->country_id = Auth::user()->country_id;
        $permission->language_id = $request->language_id;
        $permission->modified_by = Auth::user()->id;
        $permission->save();




        return response()->json($permission);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->status = -1;
        $permission->deleted_at = Carbon::now();
        $permission->modified_by = Auth::user()->id;
        $permission->save();
        return response()->json([$permission]);
    }

    public function on($id)
    {
        $permission = Permission::find($id);
        $permission->status = 1;
        $permission->modified_by = Auth::user()->id;
        $permission->save();
        return response()->json([$permission]);
    }

    public function off($id)
    {

        $permission = Permission::find($id);
        $permission->status = 0;
        $permission->modified_by = Auth::user()->id;
        $permission->save();
        return response()->json($permission);
    }
}
