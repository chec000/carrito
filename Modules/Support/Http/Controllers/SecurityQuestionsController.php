<?php

namespace Modules\Support\Http\Controllers;


use App\SecurityQuestion;
use App\Language;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\SecurityQuestionLanguage;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\SecurityQuestionRequest;

class SecurityQuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:questions.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::securityquestions.index');
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
    public function store(Request $request, SecurityQuestionRequest $securityquestionRequest)
    {
        $securityquestion = new SecurityQuestion();
        $securityquestion->country_id = Auth::user()->country_id;
        $securityquestion->question = $request->securityquestions;
        $securityquestion->modified_by = Auth::user()->id;
        $securityquestion->estatus = $request->estatus;
        $securityquestion->save();


        $securityquestionLanguage = new SecurityQuestionLanguage();
        $securityquestionLanguage->security_question_id = $securityquestion->security_question_id;
        $securityquestionLanguage->language_id = $request->language_id;
        $securityquestionLanguage->question = $request->securityquestions;
        $securityquestionLanguage->modified_by = Auth::user()->id;
        $securityquestionLanguage->estatus = $request->estatus;
        $securityquestionLanguage->save();




        return response()->json($securityquestionLanguage);
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


        $data['securityquestions'] = SecurityQuestionLanguage::select('*','security_question_language.estatus')
            ->join('security_question', 'security_question_language.security_question_id', '=', 'security_question.security_question_id')
            ->where('security_question_language.estatus','!=', -1)
            ->where('security_question.country_id', Auth::user()->country_id)
            ->with('language')->get();






        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        /* $securityquestion = SecurityQuestionLanguage::where('security_question_language_id','=', $id)
                                    ->with('security_question')->get(); */

        $securityquestion['securityquestions_language'] = SecurityQuestionLanguage::find($id);
        $securityquestion['securityquestions']          = SecurityQuestion::where('security_question_id',$securityquestion['securityquestions_language']->security_question_id)->first();
        return response()->json($securityquestion);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, SecurityQuestionRequest $securityquestionRequest)
    {


        $securityquestionLanguage = SecurityQuestionLanguage::find($id);
        //$securityquestionLanguage->security_question_id = $securityquestion->security_question_id;
        $securityquestionLanguage->language_id = $request->language_id;
        $securityquestionLanguage->question = $request->securityquestions;
        $securityquestionLanguage->modified_by = Auth::user()->id;
        $securityquestionLanguage->estatus = $request->estatus;
        $securityquestionLanguage->save();

        return response()->json($securityquestionLanguage);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {

        $securityquestionLanguage = SecurityQuestionLanguage::find($id);
        $securityquestionLanguage->estatus = -1;
        $securityquestionLanguage->deleted_at = Carbon::now();
        $securityquestionLanguage->save();
        return response()->json([$securityquestionLanguage]);
    }

    public function on($id)
    {
        $securityquestionLanguage = SecurityQuestionLanguage::find($id);
        $securityquestionLanguage->estatus = 1;
        $securityquestionLanguage->save();
        return response()->json([$securityquestionLanguage]);
    }

    public function off($id)
    {
        $securityquestionLanguage = SecurityQuestionLanguage::find($id);
        $securityquestionLanguage->estatus = 0;
        $securityquestionLanguage->save();
        return response()->json($securityquestionLanguage);
    }
}
