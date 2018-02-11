<?php
namespace Modules\Api\Entities;
use Illuminate\Support\Facades\DB;
use Modules\Products\Entities\Zip_code;
use Exception;
class ZipCode extends Zip_code{

  public function getZip($zip){
      try {
      $zip_codes = $this
      ->select('*')
      ->where('zip', '=', $zip)
      ->get()
      ->first(); 
      } catch (Exception $ex) {
          $zip_codes=false;
      }      
    if($zip_codes){
          return $zip_codes;
    }
    else{
              return null;
    }
  }

  public function getStateId($state){
      try {
      $state_id = DB::table('state')
      ->select('state_id')
      ->where('state_key', '=', $state)
      ->get()
      ->first();        
      } catch (Exception $ex) {
          return array();
      }      
    if($state_id != null){
              return $state_id->state_id;
    }
    else{
         return array();
    }
  }

  public function compareStateId($zip){
      try {
    $state = $this
      ->select('state')
      ->where('zip', '=', $zip)
      ->get()
      ->first();
    $state_id = self::getStateId($state->state);
          $equals=($state_id == session()->get('state_id'));
      } catch (Exception $ex) {
          $equals=false;
      }
    return $equals;
  }

}
