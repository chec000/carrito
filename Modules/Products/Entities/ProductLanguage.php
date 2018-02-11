<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of ProducLanguage
 *
 * @author sergio
 */
class ProductLanguage extends Model{
    //put your code here

    /**
     * Schema table name to migrate
     * @var string
     */
    protected $fillable = [];  
       /**     *     * The name of the table that will be saving the data     *     * @var string     */   
    protected $table = 'product_language';

public function product()
{
  return $this->belongsTo('Modules\Products\Entities\Product');
}
  
    /**
     * Run the migrations.
     * @table product_language
     *
     * @return void
     */
}
