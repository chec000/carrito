<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of ProductPackage
 *
 * @author sergio
 */
class ProductPackage extends Model{
    protected $table = 'product_package';
 protected $primaryKey = "product_package_id";
}
