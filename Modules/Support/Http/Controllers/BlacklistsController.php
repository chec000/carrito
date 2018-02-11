<?php

namespace Modules\Support\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Blacklist;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\BlacklistsRequest;

class BlacklistsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:blacklists.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::blacklists.index');
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
    public function store(Request $request, BlacklistsRequest $blacklistsRequest)
    {
        $blacklist = new Blacklist();
        $blacklist->eonumber = $request->eonumber;
        $blacklist->reason = !empty($request->reason) ? $request->reason : '';
        $blacklist->country_id = Auth::user()->country_id;
        $blacklist->modified_by = Auth::user()->id;
        $blacklist->estatus = $request->estatus;

        $blacklist->save();




        return response()->json($blacklist);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            /* $blacklist = Blacklist::select('*','Blacklist.short_name')->join('Blacklist','permissions.Blacklist_id','=','Blacklist.Blacklist_id')
            ->where('permissions.status','!=',-1)->get(); */

        $data['blacklist'] = Blacklist::where('estatus','!=', -1)
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
        $blacklist = Blacklist::find($id);
        return response()->json($blacklist);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, BlacklistsRequest $blacklistsRequest)
    {
        $blacklist = Blacklist::find($id);

        $blacklist->eonumber = $request->eonumber;
        $blacklist->reason = !empty($request->reason) ? $request->reason : '';
        $blacklist->country_id = Auth::user()->country_id;
        $blacklist->modified_by = Auth::user()->id;
        $blacklist->estatus = $request->estatus;
        $blacklist->save();




        return response()->json($blacklist);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $blacklist = Blacklist::find($id);
        $blacklist->estatus = -1;
        $blacklist->deleted_at = Carbon::now();
        $blacklist->modified_by = Auth::user()->id;
        $blacklist->save();
        return response()->json([$blacklist]);
    }

    public function on($id)
    {
        $blacklist = Blacklist::find($id);
        $blacklist->estatus = 1;
        $blacklist->modified_by = Auth::user()->id;
        $blacklist->save();
        return response()->json([$blacklist]);
    }

    public function off($id)
    {

        $blacklist = Blacklist::find($id);
        $blacklist->estatus = 0;
        $blacklist->modified_by = Auth::user()->id;
        $blacklist->save();
        return response()->json($blacklist);
    }
}
