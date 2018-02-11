<?php

namespace Modules\Support\Http\Controllers;
use App\Permission;
use App\PermissionRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Role;
use App\Language;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\RolesRequest;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:roles.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::roles.index');
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
    public function store(Request $request, RolesRequest $RoleRequest)
    {
        $role = new Role();
        $role->alias = $request->alias;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->status = $request->estatus;
        $role->country_id = Auth::user()->country_id;
        $role->language_id = $request->language_id;
        $role->modified_by = Auth::user()->id;
        $role->save();

        if($request->has('permissions')){
            foreach ($request->permissions as $permission)
            {
                $permissionRole = new PermissionRole();
                $permissionRole->permission_id = $permission;
                $permissionRole->role_id =  $role->id;
                $permissionRole->save();
            }
        }

        return response()->json($role);
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

        $data['role'] = Role::select('roles.*','language.short_name')->join('language','roles.language_id','=','language.language_id')
            ->where('roles.status','!=', -1)
            ->where('roles.country_id', Auth::user()->country_id)
            ->with('language')->get();

        $permissions = Permission::where('status', 1) ->where('permissions.country_id', Auth::user()->country_id)->orderBy('alias')->get();
        $permission = [];
        foreach ($permissions as $perm){
            if($perm->alias != null) {
                $group = strtolower($perm->alias);
                $checkAlias = strpos($group, '.');
                if ($checkAlias !== false)
                    $group = substr($group, 0, $checkAlias);
                $permission[ucfirst($group)][] = array('id' => $perm->id, 'title' => $perm->title, 'alias' => $perm->alias);
            }
        }
        $data['permission'] = $permission;

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $role['role'] = Role::find($id);

        $permissions= PermissionRole::select('permission_id')->where('role_id', $role['role'] ->id)->get();
        foreach ($permissions as $perm)
            $role['permissions'][] = $perm->permission_id;

        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, RolesRequest $RoleRequest)
    {
        $role = Role::find($id);
        $role->alias = $request->alias;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->status = $request->estatus;
        $role->country_id = Auth::user()->country_id;
        $role->language_id = $request->language_id;
        $role->modified_by = Auth::user()->id;
        $role->save();

        $deletePermissions = PermissionRole::where('role_id', $role->id)->delete();

        if($request->has('permissions')){
            foreach ($request->permissions as $permission)
            {
                $permissionRole = new PermissionRole();
                $permissionRole->permission_id = $permission;
                $permissionRole->role_id = $role->id;
                $permissionRole->save();
            }
        }

        return response()->json($role);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->status = -1;
        $role->modified_by = Auth::user()->id;
        $role->save();
        return response()->json([$role]);
    }

    public function on($id)
    {
        $role = Role::find($id);
        $role->status = 1;
        $role->modified_by = Auth::user()->id;
        $role->save();
        return response()->json([$role]);
    }

    public function off($id)
    {

        $role = Role::find($id);
        $role->status = 0;
        $role->modified_by = Auth::user()->id;
        $role->save();
        return response()->json($role);
    }
}
