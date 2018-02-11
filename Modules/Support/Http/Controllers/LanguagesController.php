<?php

namespace Modules\Support\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Language;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\LanguagesRequest;

class LanguagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:languages.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::languages.index');
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
    public function store(Request $request, LanguagesRequest $LanguagesRequest)
    {
        $language = new Language();
        $language->name = $request->nombre;
        $language->short_name = $request->short_name;
        $language->modified_by = Auth::user()->id;
        $language->estatus = $request->estatus;

        $language->save();



        return response()->json($language);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            /* $language = Language::select('*','language.short_name')->join('language','permissions.language_id','=','language.language_id')
            ->where('permissions.status','!=',-1)->get(); */

        $data['language'] = Language::where('estatus','!=', -1)->get();


        return response()->json($data);



    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $language = Language::find($id);
        return response()->json($language);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, LanguagesRequest $LanguagesRequest)
    {
        $language = Language::find($id);

        $language->name = $request->nombre;
        $language->short_name = $request->short_name;
        $language->estatus = $request->estatus;
        $language->modified_by = Auth::user()->id;
        $language->save();




        return response()->json($language);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $language = Language::find($id);
        $language->estatus = -1;
        $language->deleted_at = Carbon::now();
        $language->modified_by = Auth::user()->id;
        $language->save();
        return response()->json([$language]);
    }

    public function on($id)
    {
        $language = Language::find($id);
        $language->estatus = 1;
        $language->modified_by = Auth::user()->id;
        $language->save();
        return response()->json([$language]);
    }

    public function off($id)
    {

        $language = Language::find($id);
        $language->estatus = 0;
        $language->modified_by = Auth::user()->id;
        $language->save();
        return response()->json($language);
    }
}
