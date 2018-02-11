<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of ProductBenefit
 *
 * @author sergio
 */
class ProductBenefit extends Model{
   
    protected $fillable = [];  
    protected $primaryKey = "benefit_id";
       /**     *     * The name of the table that will be saving the data     *     * @var string     */   
    protected $table = 'product_benefit';
    public function products() {
        return $this->hasMany('Modules\Products\Entities\Product','product_id');
    }
}
