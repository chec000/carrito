<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Products\Entities\Models;

/**
 * Description of Products
 *
 * @author sergio
 */
class ProductModel { 
    function getVideo_url() {
        return $this->video_url;
    }

    function setVideo_url($video_url) {
        $this->video_url = $video_url;
    }


    function getIs_kit() {
        return $this->is_kit;
    }

    function setIs_kit($is_kit) {
        $this->is_kit = $is_kit;
    }


    function getProduct_id() {
        return $this->product_id;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    function getSku() {
        return $this->sku;
    }

    function getPrice() {
        return $this->price;
    }

    function getPoints() {
        return $this->points;
    }

    function getName() {
        return $this->name;
    }

    function getDescripction() {
        return $this->description;
    }

    function getShort_description() {
        return $this->short_description;
    }

    function getConsuption_tips() {
        return $this->consuption_tips;
    }

    function getNutritional_table() {
        return $this->nutritional_table;
    }

    function setProduct_id($product_id) {
        $this->product_id = $product_id;
    }

    function setSku($sku) {
        $this->sku = $sku;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setPoints($points) {
        $this->points = $points;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescripction($description) {
        $this->description = $description;
    }

    function setShort_description($short_description) {
        $this->short_description = $short_description;
    }

    function setConsuption_tips($consuption_tips) {
        $this->consuption_tips = $consuption_tips;
    }

    function setNutritional_table($nutritional_table) {
        $this->nutritional_table = $nutritional_table;
    }

}
