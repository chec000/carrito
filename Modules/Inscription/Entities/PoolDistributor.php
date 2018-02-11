<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Inscription\Entities;
use Illuminate\Database\Eloquent\Model;
use Exception;
use DB;
/**
 * Description of PoolDistributor
 *
 * @author sergio
 */
class PoolDistributor extends Model{
    //put your code here
      protected $table = 'pool_distributors';
   
      
      public  function getPoolDistributors($id){
          try {
          $row =$this ->select('eo_number', 'eo_name','eo_email')
            ->where('eo_number', '=', $id)
            ->limit(1)
            ->first();
              
          } catch (Exception $ex) {
      return null;         
          }   
       return $row;   
      }
      public  function getPoolDistributorNoUsed(){
          try {
               $row = $this ->select('eo_number', 'eo_name','eo_email')
            ->where('used', '=', 0)
            ->limit(1)
            ->first();    
          } catch (Exception $ex) {
              return null;
          }
          return $row;
      }
      public function updateSponsorSelected(){
        if (session()->get('sponsor')) {
         $user = session()->get('sponsor')['eo_number']; 
        } else {
          $user = session()->get('sponsor_rnd')['eo_number'];
        }
        DB::table('pool_distributors')
          ->where('eo_number', $user)
          ->update(['used' => 1]); 
      }
      
      public  function updatePoolDistributor(){
          try {
            DB::table('pool_distributors')
              ->update(['used' => 0]);

          } catch (Exception $ex) {
              dd($ex);
          }
      } 
      
}
