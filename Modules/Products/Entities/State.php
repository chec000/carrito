<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;
use Exception;
/**
 * Description of State
 *
 * @author sergio
 */
class State extends Model{
    //put your code here

    /**
     * Schema table name to migrate
     * @var string
     */
       /**     *     * The name of the table that will be saving the data     *     * @var string     */   
    protected $table = 'state';
    public  function getStates($state=""){
        try {
               $states = $this ->select('state','state_key', 'state_id')
            ->where('estatus', '=', 1)
            ->where('state_key', '=', $state)
            ->get();
            
        } catch (Exception $ex) {
   return null;         
        }
        return $states;
    }
    /**
     * Run the migrations.
     * @table state
     *
     * @return void
     */
   
}
