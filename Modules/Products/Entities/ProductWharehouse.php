<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductWharehouse extends Model
{
    /**
     * Schema table name to migrate
     * @var string
     */
    protected $fillable = [];
       /**     *     * The name of the table that will be saving the data     *     * @var string     */
    protected $table = 'product_wharehouse';

    function validateProduct($id){
      $product = $this->select('*')
      ->where([
        ['product_id', '=', $id],
        ['wharehouse_id', '=', session()->get('wh_id')]
      ])
      ->get()
      ->first();
      return $product;
    }

}
