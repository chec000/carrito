<?php

namespace Modules\Inscription\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use DB;
use App\UrlService;
use Modules\Products\Entities\ProductStateResctriction;
use Modules\Inscription\Entities\ProductKit;
use Modules\Inscription\Entities\Countries;
use Modules\Inscription\Entities\ZipCode;
use Modules\Checkout\Http\Controllers\AbcAddressController;
use Modules\Inscription\Entities\States;
use Modules\Inscription\Entities\SecurityQuestion;
use Modules\Inscription\Entities\PoolDistributor;
class InscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(){
        $sessionVariables["userName"] = session()->get('userName');
        if ($sessionVariables["userName"]) {
            return redirect('/');
        }else{
            return view('inscription::register');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('inscription::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('inscription::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('inscription::edit');
    }

    public function pdf_generator($save=""){
        if (session()->get('formReg')['new_user']) {
            if (!session()->get('PDF2')) {
                $lang = session()->get('lang_id')->short_name;
                $name = session()->get("user_eo_number");
                $data = session()->all();
                $pdf= pdf_generate($data,$save,$lang,$name);
                session()->put('PDF',$pdf);
            }else{
                return \Redirect::route('yourOrders');
            }
        }elseif (session()->get('userId')) {
            return \Redirect::route('yourOrders');
        }else{
            return \Redirect::route('home');
        }
    }

    public function cron_pdf_generator($params="",$save,$lang,$name){
        if(!empty($params)) {
            $pdf = pdf_generate($params, $save,$lang,$name);
        }

    }

    public function saveFormReg(Request $request){
        $birthdate = $request['regForm']['month']."-".$request['regForm']['day']."-".$request['regForm']['year'];
        $form = array();
        $form['country'] = session()->get('country');
        $form['name'] = $request['regForm']['name'];
        $form['last_name'] = $request['regForm']['last_name'];
        $form['gender'] = $request['regForm']['gender'];
        $form['birthdate'] = $birthdate;
        $form['address'] = $request['regForm']['address'];
        $form['district'] = $request['regForm']['district'];
        $form['zip_code'] = $request['regForm']['zip_code'];
        $form['state'] = $request['regForm']['state'];
        $form['federal_entities'] = $request['regForm']['federal_entities'];
        $form['email'] = $request['regForm']['email'];
        $form['phone_number'] = $request['regForm']['phone_number'];
        $form['security_question'] = $request['regForm']['security_question'];
        $form['payment_condition'] = true;
        $form['terms_conditions'] = true;
        $form['sponsor_val'] = $request['regForm']['sponsor_val'];
        $form['new_user'] = true;
        $form['ship_company'] =$request['regForm']['ship_company'];
        $form['county'] =$request['regForm']['county'];
        $form['answer'] =$request['regForm']['answer'];
        
        session()->put('formReg',$form);
        $data = session()->get('formReg');
        return $data;
    }
    public function selectedKit(Request $request){
        //Session::flush();
        
        session()->put('selected_kit',$request['saveKit']);
        $data = $request->session()->all();
        return $data;
    }

    public function test(){
        Session::flush();
          
    }

    public function getCountries(){   
       $countryObj= new Countries(); 
       $countries=$countryObj->getAllCountries();       
        return $countries;
    }
    public function getStates(){
    $state =Input::get('state');
    $stateObj= new States();
    $states=$stateObj->getStates($state);
        return $states;
    }
    public function getCounty(){
        $zip =Input::get('zip');
        $counties = DB::table('zip_codes')
            ->select('zip', 'state','county','city','suburb')
            ->where('status', '=', 1)
            ->where('zip', '=', $zip)
            ->get();
        return $counties;
    }
    public function getFederalEntities(){
        $zip =Input::get('zip');
        $zipObj= new ZipCode();
        $cit = $zipObj->getCityByZip($zip);        
        return $cit;
    }
    public function getSecurityQuestions(){
        $securityQuestionObj= new SecurityQuestion();
        $questions= $securityQuestionObj->getSegurityQuestion();
        return $questions;
    }
    public function getKits(){
        $productKit = new ProductKit();            
        $kits = $productKit->getProductKits();  
        return $kits;
    }
    public function getWsSponsor($eo_number){
        $parms = array(
            "metodo" =>"distribuidorInfo",
            "params" => array(
                "idDistribuidor" => $eo_number
            )
        );
    $result = UrlService::webService($parms);
    return $result;
    }
    public function getSponsor(Request $request){
        $value =  $request->sponsor;
        if (!is_null($value)) {
            $validate = self::validateSponsor($value);
            if ($validate['exito']){
               $sponsor = self::getWsSponsor($value);
                if ($sponsor['data']['nombre']) {
                    $sponsor2 = array('eo_email'=>$sponsor['data']['email'],'eo_name'=>$sponsor['data']['nombre'],'eo_number'=>$sponsor['data']['idDistribuidor']);
                    session()->put('sponsor',$sponsor2);
                    session()->put('sponsor_selected',true);
                    return response()->json(session()->get('sponsor'));
                } else{
                  return response()->json(null);
                }    
            }else{
                return response()->json(null);
            }                            
        } else{
            $poolDistributor= new PoolDistributor();
            session()->put('sponsor_selected',false);
            if (!session()->get('sponsor_rnd')) {
                $sponsor = $this->sponsorId();
                if (!is_null($sponsor)) {
                    session()->put('sponsor_rnd',$sponsor);
                    $updateSponsor = $poolDistributor->updateSponsorSelected();  
                    return response()->json($sponsor);
                } else{
                    $sponsor = $this->sponsorId();
                    session()->put('sponsor_rnd',$sponsor);
                    $updateSponsor = $poolDistributor->updateSponsorSelected(); 
                    return response()->json($sponsor);
                }   
            } else{
                return response()->json(session()->get('sponsor_rnd'));
            }
        }  
    }
    function validateSponsor($value=""){
        $parms = array(
            "metodo" =>"validaCampo",
            "params" => array(
                "clv_pais" => session()->get('country'),
                "campoValidar"=> "PATROCINADOR",
                "valorValidar"=> $value
            )
        );
    $result = UrlService::webService($parms);
    return $result;
    }
    public function sponsorId($id=""){
    $poolDistributor= new PoolDistributor();
        if (!empty($id)) {
        $row = $poolDistributor->getPoolDistributors($id);    
        return $row; 
        } else{
            $row = $poolDistributor->getPoolDistributorNoUsed();
            if (count($row) >0) {
                return $row;
            } else{
                $poolDistributor->updatePoolDistributor();
                return null;
            }
        }
        return null;
    }
    public function updateSponsor($eo_number=""){
        DB::table('pool_distributors')
        ->where('eo_number', $eo_number)
        ->update(['used' => 1]);
    }
    public function getShipCompany(Request $request){
        $country = $request->country;
        $state= $request->state;
        $city= $request->city;
        $addres = new AbcAddressController;
        $ship_company = $addres->getshippCompany($country,$state,$city);
        return $ship_company;
    }

    function get_random_string($length){
        $valid_chars = 'abcdefghijklmnopqrstuwxyz1234567890';
        $random_string = "";
        $num_valid_chars = strlen($valid_chars);
        for ($i = 0; $i < $length; $i++)    {
            $random_pick = mt_rand(1, $num_valid_chars);
            $random_char = $valid_chars[$random_pick-1];
            $random_string .= $random_char;
        }
        return $random_string;
    }
}
