<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Package
 *
 * @author sergio
 */
namespace Modules\Products\Entities\Models;

class Package {
    function getQuantity() {
        return $this->quantity;
    }
    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }     
function getIsCombo(){
    return $this->isCombo;
}
function setIsCombo($isCombo){
    $this->isCombo=$isCombo;
}

    function getNumber_package() {
        return $this->number_package;
    }

    function setNumber_package($number_package) {
        $this->number_package = $number_package;
    }

        function getImage(){
        return $this->image;        
    }
    function setImage($image){
        $this->image=$image;
    }
    function getPackage_id() {
        return $this->package_id;
    }

    function setPackage_id($package_id) {
        $this->package_id = $package_id;
    }

        
      function getPoints() {
        return $this->points;
    }

    function setPoints($points) {
        $this->points = $points;
    }

    function getDescription() {
        return $this->description;
    }

    function getName() {
        return $this->name;
    }

    function getProducts() {
        return $this->products;
    }

    function getPrice() {
        return $this->price;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setProducts($products) {
        $this->products = $products;
    }

    function setPrice($price) {
        $this->price = $price;
    }
   

}

