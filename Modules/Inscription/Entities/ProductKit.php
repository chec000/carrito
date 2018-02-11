<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductKit
 *
 * @author sergio
 */
namespace Modules\Inscription\Entities;
use Modules\Products\Entities\Product;

class ProductKit extends Product {
    //put your code here
    
    
    public function getProductKits(){
        return $this->getKits();
    }       
    
    
}
