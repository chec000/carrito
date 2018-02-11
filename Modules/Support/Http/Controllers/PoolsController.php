<?php

namespace Modules\Support\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Pool;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\LoadRequest;
use Modules\Support\Http\Requests\PoolsRequest;
use Illuminate\Support\Facades\Validator;

class PoolsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:pools.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::pools.index');
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
    public function store(Request $request, PoolsRequest $PoolsRequest)
    {
        $pool = new Pool();
        $pool->eo_number = $request->eo_number;
        $pool->eo_name = $request->eo_name;
        $pool->eo_email = $request->eo_email;
        $pool->used = 0;

        $pool->save();



        return response()->json($pool);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data['pool'] = Pool::where('used','!=','-1')->get();


        return response()->json($data);



    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $pool = Pool::find($id);
        return response()->json($pool);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id, PoolsRequest $PoolsRequest)
    {
        $pool = Pool::find($id);

        $pool->eo_number = $request->eo_number;
        $pool->eo_name = $request->eo_name;
        $pool->eo_email = $request->eo_email;
        $pool->used = $request->used;
        $pool->save();




        return response()->json($pool);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $pool = Pool::find($id);
        $pool->used = -1;
        $pool->save();
        return response()->json([$pool]);
    }

    public function on($id)
    {
        $pool = Pool::find($id);
        $pool->used = 0;
        $pool->save();
        return response()->json([$pool]);
    }

    public function off($id)
    {

        $pool = Pool::find($id);
        $pool->used = 1;
        $pool->save();
        return response()->json($pool);
    }


    public function load(Request $request){

             $htmlMessageBad = '<span class="label label-danger">Error</span> '. trans('support.err_uploadcsv');

            //Validation
            $rules = [
                'csvPool' => "required|file",
            ];
            $messages = [

            ];
            if ($request->hasFile('csvPool')) {
                $rules['extension'] = "in:csv";
                $request["extension"] = $request->file('csvPool')->getClientOriginalExtension();
                $messages['extension.in'] = trans('ui.support.err_filecsv');
            }else{
                $htmlMessageBad = '<span class="label label-danger">Error</span> '. trans('support.err_fileneeded');
                return response()->json(['success' => false, 'message' => $htmlMessageBad]);
            }

            //$this->validate($request, $rules, $messages);

            $htmlMessage = '';
            $csvinfo = file_get_contents($request->file('csvPool')->getRealPath());

            $contentCsv = explode(PHP_EOL, $csvinfo);

            $infoFile = array();

            foreach ($contentCsv as $line) {

                if($line != null) {

                    $infoFile[] = str_getcsv($line);


                }
            }
            if( strpos(strtolower($infoFile[0][1]), 'nombre') !== false ||  strpos(strtolower($infoFile[0][1]), 'name') !== false )
                unset($infoFile[0]);



            if (count($infoFile) > 0) {
                Pool::truncate();

                foreach ($infoFile as $line => $info) {
                    $emailEo = trim($info[2]);
                    $nameEo = trim(utf8_encode($info[1]));
                    $eoNumber = trim($info[0]);

                    if ($this->validEmail($emailEo) && $nameEo != '' && $eoNumber != '' && !starts_with($eoNumber, 'C')) {
                        $poolDistr = Pool::create(['eo_number' => $eoNumber, 'eo_email' => $emailEo, 'eo_name' => $nameEo]);
                        $htmlMessage .= '<li><span class="label label-success">Success</span> '. trans('support.success_uploadcsv', array('eocode' => $eoNumber, 'numreg' => $line)).'</li>';
                    }else{
                        $htmlMessage .= '<li><span class="label label-danger">Error</span> '. trans('support.err_uploadcsv', array('numreg' => $line)).'</li>';
                    }
                }
                return response()->json(['success' => true, 'message' => $htmlMessage]);
            }

            return response()->json(['success' => false, 'message' => $htmlMessageBad]);


    }

    private function validEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
