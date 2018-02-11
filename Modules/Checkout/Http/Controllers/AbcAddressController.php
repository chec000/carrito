<?php

namespace Modules\Checkout\Http\Controllers;

use App\UrlService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Checkout\Entities\Zip_codes;
use Illuminate\Support\Facades\Session;
use App\Utils;

class AbcAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('checkout::index');
    }

    /* get address distributor*/
    public function  getListAddressDist($pais) {
        /* datos de prueba */
        /*1.- "distId" => "000515VCJ","pais" => "MEX" */
        /*2.- "distId" => "001392045brl","pais" => "USA"*/

        $address = array(
            "metodo" =>"consultaDireccion",
            "params" => array(
                "distId" => session()->get('userId'),
                "pais" => $pais
            )
        );
        $result = UrlService::webService($address);

        $existZIPSelected = $this->validateZIPSelected($result);

        $result["existZIPSelected"] = $existZIPSelected;
        $result["zipSelected"] = Session::get('zip')->zip;

        //return $result["zipSelected"];
        //print_r($result); exit();

        return compact('result');
    }

    private function validateZIPSelected($data){
        $zipSelected['existsZip'] = false;
        $zipSelected['folio_selected'] = false;
        $zipSelected['addressSelected'] = false;
        if(!empty($data['data'])) {
            $zipSelected['zip'] = session()->get('zip');
            foreach ($data['data'] as $address) {
                if($zipSelected['zip']->zip == $address['cp']){
                    $this->sessionAddAddressAndZipSelected($address);
                    $zipSelected['existsZip'] = true;
                    $zipSelected['folio_selected'] = $address['folio'];
                    $zipSelected['addressSelected'] = $address;
                    return $zipSelected;
                }
            }
            //linea para modificar automatiamente el zipcode de checkout por el primero en la lista de direcciones de WS
            //$this->sessionAddAddressAndZipSelected($data['data'][0]);
        }
        return $zipSelected;
    }

    private function sessionAddAddressAndZipSelected($data){
        if (!isset(session()->adressShippDist)) {
            session()->put('adressShippDist', $data);
            $utils = new Utils();
            $request = (object)[
                "zip_selected" => session()->get('adressShippDist')['cp']
            ];
            $utils->setSessionVariables($request);
        }
    }

    /*** Function to get a state use ZIP code ***/
    public function getStateZip($zipCode = '01002' ){
        $zipStates = new Zip_codes;
        $state = $zipStates->getStatesByZipcode($zipCode);
        return  $state;

    }
    /*** Function to get a city use ZIP code ***/
    public function getCatCitysZip($zipCode, $state){

        $zipCitys = new Zip_codes;
        /*** Dato de prueba ***/
        /*zipCode '00303'*/
        /*state 'VA'*/
        $citys = $zipCitys->getCitysByZipcode($zipCode, $state);

        return compact('citys');

    }
    /*** Function to get a county use ZIP code ***/
    public function getCatCountysZip($zipCode, $state , $city ){

        $zipCountys = new Zip_codes;
        /*** Dato de prueba ***/
        /*zipCode '00303'*/
        /*state 'VA'*/
        /*county "HAMPSHIRE"*/
        $countys = $zipCountys->getCountysByZipcode($zipCode, $state, $city);

        return compact('countys');

    }

    //get shipp company
    public function  getshippCompany($pais, $estado, $ciudad) {
        /* Datos de prueba */
        /*1.- "pais"=> "MEX","estado"=>"JAL","ciudad"=>"GUADALAJ"*/
        /*2.- "pais"=>"USA","estado"=>"CA","ciudad"=>"BEVERLY"*/
        $data = array(
            "metodo" =>"companiasEnvio",
            "params" => array(
                "pais"=>$pais,
                "estado"=>$estado,
                "ciudad"=>$ciudad
            )
        );
        $shippsCompany = UrlService::webService($data);
        $arrShippsCompany = array();

        if($shippsCompany['exito'] == 1){
            $arrayIni =explode('|', substr($shippsCompany['data']['comp_env'],1));
            foreach ($arrayIni as $index => $asc){
                $arrayConst = explode(',', $asc);
                $asc = $arrayConst;
                $arrShippsCompany[$index]['value'] = $arrayConst[0];
                $arrShippsCompany[$index]['text'] = $arrayConst[1];
            }
        }
        return compact('arrShippsCompany');
    }

    public function disabledAddressDist($distId, $folio){
        $data = array(
            "metodo" =>"inactivaDireccion",
            "params" => array(
                "distId"=>$distId,
                "pais"=>session()->get("country"),
                "folio"=>$folio
            )
        );
        $result = UrlService::webService($data);

        $result = $this->evalResult($result,'inactivaDireccion');

        return json_encode($result);
        //session()->all();
        //return compact("result");
    }

    /*** Function Add new Address ***/
    public function addAddressDist(Request $request){
        ini_set('memory_limit', '512M');

      
        //print_r($request->addressForm);
        $data = array(
            "metodo" =>"acDireccion",
            "params" => array(
                "tipo"=> isset($request->addressForm["tipo"]) ? $request->addressForm["tipo"] : "",
                "distId"=> isset($request->addressForm["dist_id"]) ? $request->addressForm["dist_id"] : "",
                "folio"=> isset($request->addressForm["folio"]) ? $request->addressForm["folio"] : "",
                "etiqueta"=> isset($request->addressForm["etiqueta"]) ? $request->addressForm["etiqueta"] :"",
                "nombre"=> isset($request->addressForm["nombre"]) ? $request->addressForm["nombre"] : "",
                "direccion"=> isset($request->addressForm["direccion"]) ? $request->addressForm["direccion"] : "",
                "numero"=> isset($request->addressForm["numero"]) ? $request->addressForm["numero"] : 0,
                "complemento"=> isset($request->addressForm["complemento"]) ? $request->addressForm["complemento"] : "Complemento referencia",
                "colonia"=> isset($request->addressForm["colonia"]) ? $request->addressForm["colonia"] : "Colonia referencia",
                "cp"=> isset($request->addressForm["cp"]) ? $request->addressForm["cp"] : 0,
                "ciudad"=> isset($request->addressForm["ciudad"]) ? $request->addressForm["ciudad"] : "",
                "estado"=> isset($request->addressForm["estado"]) ? $request->addressForm["estado"] : "",
                "condado"=> isset($request->addressForm["condado"]) ? $request->addressForm["condado"] : "",
                "pais"=> session()->get('country'),
                "correo"=> isset($request->addressForm["correo"]) ? $request->addressForm["correo"] :"",
                "companiaEnvio"=> isset($request->addressForm["comp_env"]) ? $request->addressForm["comp_env"] : "",
                "telefono"=> isset($request->addressForm["telefono"]) ? $request->addressForm["telefono"] : 0
            )
        );

        $result = UrlService::webService($data);
        $result = $this->evalResult($result, 'acDireccion');
        //print_r($result); exit();
        return json_encode($result);
    }

    public function updateSessionAddressShipp(Request $request){
        ini_set('memory_limit', '512M');

        $oldAddress = session()->get('adressShippDist');
        session()->forget('adressShippDist');
        session()->put('adressShippDist',$request->addressShp);

        if(session()->has('adressShippDist')) {
            $result['exito'] = 1;
        } else {
            $result['exito'] = 0;
            $result['message'] = 'FAILED_UPDATE';
            session()->put('adressShippDist',$oldAddress);
        }
        $result = $this->evalResult($result,'update_data');
        return json_encode($result);
    }

    private function evalResult($result, $service){

        $result['messageTitle'] =  trans('messages.message');
        if($result['exito'] == 1){
            $result['userMessage'] = trans('messages.'.$service.'.EXITO');
            $result['typeMessage'] = 'info';
        }else {
            //messages.acDireccion.EXITO
            $result['userMessage'] = trans('messages.'.$service.'.'.$result['message']);
            $result['typeMessage'] = 'warning';
        }

        return $result;
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('checkout::create');
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
        return view('checkout::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('checkout::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
