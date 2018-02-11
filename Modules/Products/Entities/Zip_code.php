<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Zip_code  extends Model{
       /**     *     * The name of the table that will be saving the data     *     * @var string     */   
    protected $table = 'zip_codes';
    public  function getCityByZip($zip){
        try {
            $city = $this->select('zip', 'city','suburb', 'state')
            ->where('status', '=', 1)
            ->where('zip', 'like',$zip)
            ->distinct()
            ->get();
        } catch (Exception $ex) {
            return null;
        }
        return $city;
    }
    
}