<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PromotionCombo
 *
 * @author sergio
 */

namespace Modules\Products\Entities\Models;

use Modules\Products\Entities\Models\Package;

class PromotionProductCombo extends Package {
    function getTotal() {
        return $this->total;
    }
    function setTotal($total) {
        $this->total = $total;
    }
    function getProduct() {
        return $this->product;
    }

    function setProduct($product) {
        $this->product = $product;
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
