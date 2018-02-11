<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of ProductStateResctricction
 *
 * @author sergio
 */
class ProductStateResctriction extends Model{
    //put your code here


    /**
     * Schema table name to migrate
     * @var string
     */
    protected $fillable = [];  
       /**     *     * The name of the table that will be saving the data     *     * @var string     */   
    protected $table = 'product_state_restriction';

    /**
     * Run the mig
    /**rations.
     * @table product_state_restriction
     *
     * @return void
     */
}

