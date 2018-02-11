<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\Product;
/**
 * Description of ProductCategory
 *
 * @author sergio
 */

class ProductCategory extends Model
{

    protected $fillable = [];  
       /**     *     * The name of the table that will be saving the data     *     * @var string     */   
    protected $table = 'product_category';

    public function products() {
        return $this->belongsToMany('Modules\Products\Entities\Product');
    }

    public function getCategoryProductByIdProduct($idProduct){
        try {
            $idCategory = $this->select('category_id')
                ->where('product_id',$idProduct)->first();
            //print_r($short_name->short_name); exit();
        } catch (Exception $e) {
            return null;
        }
        return $idCategory;
    }

}

