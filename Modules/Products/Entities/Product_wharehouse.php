<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Product_wharehouse extends Model {

  protected $table = 'product_wharehouse';
  public function validateProduct($id){
    $product = $this->select('*')
      ->where([
        ['product_id', '=', $id],
        ['wharehouse_id', '=', session()->get('wh_id')],
      ])
      ->get()
      ->first();
    return $product;
  }

}
