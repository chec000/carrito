<?php

namespace Modules\Support\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\UsersRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('permission:users.index', ['only' => ['index']]);
    }

    public function index()
    {
        $roles = Role::where('status','<>',-1)->get();
        $usuarios = User::where('estatus','<>',-1)->get();
        return view('support::users.index', compact('roles', 'usuarios'));
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
    public function store(Request $request, UsersRequest $usersRequest)
    {
        $usuarios = new User();
        $usuarios->name = $request->name;
        $usuarios->email = $request->email;
        $usuarios->username = $request->username;
        $usuarios->password = bcrypt($request->password);
        $usuarios->country_id = Auth::user()->country_id;
        $usuarios->role_id = $request->role_id;
        $usuarios->modified_by = Auth::user()->id;
        $usuarios->estatus = $request->estatus;
        $usuarios->save();
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $roles = Role::where('status','<>',-1)->where('country_id', Auth::user()->country_id)->get();
        $usuarios = User::where('estatus','<>',-1)->where('country_id', Auth::user()->country_id)
            ->with('rol')->get();

        $datos = [
            'roles' => $roles,
            'usuarios' => $usuarios,
        ];
        return response()->json($datos);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $usuarios = User::find($id);
        return response()->json($usuarios);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, UsersRequest $usersRequest)
    {
        $usuarios = User::find($id);
        $usuarios->name = $request->name;
        $usuarios->email = $request->email;
        $usuarios->username = $request->username;
        if($request->password != null)
        {
            $usuarios->password = bcrypt($request->password);
        }
        $usuarios->role_id = $request->role_id;
        $usuarios->modified_by = Auth::user()->id;
        $usuarios->estatus = $request->estatus;
        $usuarios->save();
        return response()->json($usuarios);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $usuarios = User::find($id);
        $usuarios->estatus = -1;
        $usuarios->save();
        return response()->json([$usuarios]);
    }

    public function on($id)
    {
        $usuarios = User::find($id);
        $usuarios->estatus = 1;
        $usuarios->save();
        return response()->json([$usuarios]);
    }

    public function off($id)
    {
        $usuarios = User::find($id);
        $usuarios->estatus = 0;
        $usuarios->save();
        return response()->json($usuarios);
    }
}
