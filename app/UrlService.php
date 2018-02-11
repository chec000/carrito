<?php

namespace App;

use Ixudra\Curl\Facades\Curl;

 class UrlService {
 public static function webService($params) {   
        $response = Curl::to('http://10.6.20.102:9090/rest/process/method')
                ->withData($params)
                ->asJson(true)
                ->post();
      return $response;
     
    }
}
