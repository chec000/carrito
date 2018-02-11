<?php namespace Modules\Languages\Http\Controllers;

//use Pingpong\Modules\Routing\Controller;
use App\Http\Controllers\IndexController;
use App\Http\Requests;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controller;
use App\Banner;

class LanguageController extends Controller {


    public function switchLang($lang)
    {
      $banner = new Banner();
      $banner->getLang();
      
        $indexController  = new IndexController();

        if (array_key_exists($lang, Config::get('app.languages'))) {
            Session::put('applocale', $lang);
            App::setLocale($lang);
            session()->put('existLanguage',1);
            $indexController->setLanguage($lang);
        }
      return Redirect::back();
    }
   public function getLan(){
       if (session()->get('existLanguage')){
     return   session()->get('existLanguage');
       }else{
           return 0;
       }
   }

}