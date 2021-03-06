<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Modules\Products\Entities\Wharehouse;
use Modules\Products\Entities\State;
use Modules\Products\Entities\Zip_code;
use Illuminate\Support\Facades\Session;
use App\Country;
use App\Banner;

/**
 * Description of Utils
 *
 * @author sergio
 */
class Utils {

    public function setSessionVariables() {
        $zip_model = Zip_code::where('zip', '=', "00303")->first();
        $this->setDefaultCountry();        
        $this->getState($zip_model);
        session()->put("country_id",2);
        session()->put('wh_id',4);   
        session()->put('lang_id', 2);
        return session()->all();           
    }

    public  function getState($zip_model){
        $state = State::where('state_key', '=', $zip_model['state'])->select('state_id')->first();     
        session::put('state_id', $state['state_id']);
        
    }
    private function getGlobalWharehouse($state,$city) {
        $data_wheare_house = array(
            "metodo" => "buscaAlmacen",
            "params" => array(
                "clvPais" => session()->get('country'),
                "clvCiudad" => $city,
                "clvEstado" =>$state
        ));
        return $data_wheare_house;
    }
    public function  setDefaultCountry(){
            session()->put('language.0.language_id',1);
                if ( session()->get('country')!='USA') {
                    session()->put('country','USA');

        $country_id = Country::select('country_id')->where('name','Estados Unidos')
                ->orWhere('short_name', 'USA')
                ->first();
                session()->put("country_id",$country_id);
    }             
    }
        private function setLanguage($country){
        $country="es";
            switch ($country){
            case "Estados Unidos":
            case "United States":
            case "USA":
            case "en":
                $lenguage = Language::where('short_name', '=', 'ENG')->get();
                break;
            case "Mexico":
            case "MEX":
            case "es":
                $lenguage = Language::where('short_name', '=', 'ESP')->get();
                break;
            default:
                $lenguage = Language::where('short_name', '=', 'ESP')->get();
                break;
        }
        Session::put('language', $lenguage);
        
        $banner = new Banner();
        $banner->getLang();
    }
    function isAjax(){
  $ajax = false;

            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
            {
              $ajax = "true";
            }else{
              $ajax=  "false";
            }
            return $ajax;
}

}
