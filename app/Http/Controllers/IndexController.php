<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Products\Entities\Zip_code;
use Modules\Products\Entities\Language;
use Modules\Products\Entities\State;
use App\Utils;
use App\Banner;


class IndexController extends Controller {

    protected $request;

    public function __contruct(Request $request) {
        $this->$request = $request;

    }

    public function saveCountry(Request $request) {
        Session::put('country', $request->country_selected);
        Session::put('state', $request->state_selected);
        if ($request->country_selected==="Estados Unidos" ||$request->country_selected==="United States" || $request->country_selected==="USA") {
            $lenguage = Language::where('short_name', '=', 'ENG')->get();
        }else{
              $lenguage = Language::where('short_name', '=', 'ESP')->get();
        }

          Session::put('language', $lenguage);
          $data = Session::all();
        return $data;
    }

    public function setLanguage($country){
 //     $country="USA";
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
        session()->put('lang_id',session()->get('language.0'));
    }
    
    public function existZip(){
        $zip= session()->get('zip');
        $result=0;
        if ($zip!=null) {
            $result= 1;
        }

         
      return $result;
    }
    private  function language(){        
                if (session()->get('applocale') === null ){
                Session::put('applocale', 'es');
                }
      }

    public function saveZipSelected(Request $request) {
       // Session::put('applocale', "es");
        $utils= new Utils();
        return $utils->setSessionVariables($request);
    }    
    public function redirectHome(){
         return redirect('/');
         if (Session::has('message')) {
         session::forget('message');   
        }
    }

    public function indexHome(){
            $uls= new Utils();
            $uls->setDefaultCountry();
            $uls->setSessionVariables();
        $this->language();  
        $getBanner = new Banner();
        $banner = $getBanner->getBannerInfo();
        return view('home')->with('banner', $banner);
    }
       public function  shopping(){
        
        //
        return view('index');
    }   
}
