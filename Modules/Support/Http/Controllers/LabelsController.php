<?php

namespace Modules\Support\Http\Controllers;

use App\Label;
use App\LabelLanguage;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\LabelsRequest;

class LabelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:labels.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::labels.index');
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
    public function store(Request $request, LabelsRequest $labelsRequest)
    {
        $label = new label();//
        $label->country_id = Auth::user()->country_id;
        $label->modified_by = Auth::user()->id;
        $label->estatus = $request->estatus;//
        $label->save();

        $labelLanguage = new LabelLanguage();
        $labelLanguage->label_id = $label->label_id;
        $labelLanguage->language_id = $request->language_id;
        $labelLanguage->name = $request->name;
        $labelLanguage->modified_by = Auth::user()->id;
        $labelLanguage->estatus = $request->estatus;
        $labelLanguage->save();

        return response()->json($labelLanguage);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data['select'] = Language::where('estatus','!=', -1)->get();

        $data['label'] = LabelLanguage::select('*','labels_language.estatus')
            ->join('labels', 'labels_language.label_id', '=', 'labels.label_id')
            ->where('labels_language.estatus','!=', -1)
            ->where('labels.country_id', Auth::user()->country_id)
            ->with('language')->get();

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $label = LabelLanguage::find($id);
        return response()->json($label);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, LabelsRequest $labelsRequest)
    {
        $label = LabelLanguage::find($id);
        $label->name = $request->name;
        $label->language_id = $request->language_id;
        $label->modified_by = Auth::user()->id;
        $label->estatus = $request->estatus;
        $label->save();
        return response()->json($label);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $labelLanguage = LabelLanguage::find($id);
        $labelLanguage->deleted_at = date("Y-m-d H:i:s");
        $labelLanguage->modified_by = Auth::user()->id;
        $labelLanguage->estatus = -1;
        $labelLanguage->save();

        $label = Label::find($labelLanguage->label_id);
        $label->deleted_at = date("Y-m-d H:i:s");
        $label->modified_by = Auth::user()->id;
        $label->estatus = -1;
        $label->save();
        return response()->json([$labelLanguage]);
    }

    public function on($id)
    {
        $label = LabelLanguage::find($id);
        $label->estatus = 1;
        $label->modified_by = Auth::user()->id;
        $label->save();
        return response()->json([$label]);
    }

    public function off($id)
    {
        $label = LabelLanguage::find($id);
        $label->estatus = 0;
        $label->modified_by = Auth::user()->id;
        $label->save();
        return response()->json($label);
    }
}
