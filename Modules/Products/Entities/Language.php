<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of Language
 *
 * @author sergio
 */
class Language extends Model{
    //put your code here

    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'language';
        protected $fillable = [];  
       /**     *     * The name of the table that will be saving the data     *     * @var string     */   
    protected $table = 'language';
}
