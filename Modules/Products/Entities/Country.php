<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of Country
 *
 * @author sergio
 */

class Country extends Model
{
    /**
     * Schema table name to migrate
     * @var string
     */
   

        public $set_schema_table = 'country';

    /**
     * Run the migrations.
     * @table country
     *
     * @return void
     */
      protected $table = 'country';
   
   public function getAllCountries(){
      
       try {
       $countries = $this->select('name', 'short_name','country_id')
            ->where('estatus', '=', 1)
            ->get();    
       } catch (Exception $ex) {
       return null;    
       } 
       return $countries;
        }

     public function getShorNameCountryById($id){
      try {
       $short_name=$this->select('short_name')
      ->where('country_id',$id)->first();
          //print_r($short_name->short_name); exit();
      } catch (Exception $e) {
        return null;
      }
      return $short_name;
    }
   
}