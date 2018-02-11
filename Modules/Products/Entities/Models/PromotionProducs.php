<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities\Models;

use Modules\Products\Entities\Models\ProductModel;

/**
 * Description of Promotion
 *
 * @author sergio
 */
class PromotionProducs extends ProductModel {

    function getTotal() {
        return $this->total;
    }

    function setTotal($total) {
        $this->total = $total;
    }

            function getIsPromotion(){
        return $this->isPromotion;
    }
    function setIspromotion($is_promotion){
        $this->isPromotion=$is_promotion;
    }
    function getPromoKey(){
        return $this->promoKey;
    }
    function setPromoKey($promoKey){
        $this->promoKey=$promoKey;
    }
    function getType() {
        return $this->type;
    }
   
    function setType($type) {
        $this->type = $type;
    }

    function getMax_cuantity() {
        return $this->max_quantity;
    }

    function setMax_cuantity($max_cuantity) {
        $this->max_quantity = $max_cuantity;
    }

    function setRequired($required) {
        $this->required = $required;
    }

    function getRequired() {
        return $this->required;
    }

}
