<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Checkout\Entities;

use Modules\Products\Entities\Models\PromotionProducs;
use Modules\Products\Entities\Models\PromotionProductCombo;

/**
 * Description of Promotions
 *
 * @author sergio
 */
class Promotions {

    /**
     * Name:buidPromotionCombo
     * Params:$promotionaA
     * Description:Construlle la lista de promociones que contienen paquetes 
     * Return: $promotionModel
     */
    public function buidPromotionCombo($promotionA) {
        $promotionsModel = array();
        $listPromotion = array();
        if (count($promotionA) > 0) {         
            foreach ($promotionA as $p) {              
                array_push($promotionsModel, $this->getCombos($p));
            }
        $listPromotion["required"] = $promotionA[0]['required'];
        } else {
            return null;
        }
        $listPromotion["items"] = $promotionsModel;
     $listPromotion["name"] = $promotionA[0]['name'];
     $listPromotion["type"] = $promotionA[0]['type'];
        return $listPromotion;
    }

    /**
     * Name:getCombos
     * Params:$promocion
     * Descriptión:Obtiene las promociones de tipo combo, donde existen paquetes de productos    
     * Return: $promotionCombo
     */
    private function getCombos($p) { 
        $promotionCombo = new PromotionProductCombo();
        $promotionCombo->setName($p['name']);
        $promotionCombo->setMax_cuantity($p['maxQuantity']);
        $promotionCombo->setRequired($p['required']);
        $promotionCombo->setQuantity(1);
        $promotionCombo->setType($p['type']);
        $products = array();
        $price_package = 0;
        $points_package = 0;
        foreach ($p['products'] as $product) {  
            $price_package = $price_package + ($product['price'] * $product['quantity']);
            $points_package = $points_package + $product['points'];            
            array_push($products, $this->getProducts($product));
        }
        $promotionCombo->setPrice($price_package);
        $promotionCombo->setPoints($points_package);
        $promotionCombo->setIsCombo(true);
        $promotionCombo->setProducts($products);
        $promotionCombo->setTotal($price_package);
        return $promotionCombo;
    }

    /**
     * Name:getProducts
     * Params:$product
     * Descriptión:Parsea el product que recibe a un producto que se encuentra en una promoción   
     * Return: $productModel
     */
    private function getProducts($product) {
        $productModel = new PromotionProducs();
        $productModel->setPromoKey($product['promoKey']);
        $productModel->setSku($product['sku']);
        $productModel->setPoints($product['points']);
        $productModel->setDescripction($product['description']);
        $productModel->setName($product['description']);
        $productModel->setPrice($product['price']);
        $productModel->setQuantity($product['quantity']);
        $productModel->setMax_cuantity($product['quantity']);
        $productModel->setTotal($product['price']);
        $productModel->setIspromotion(true);
        return $productModel;
    }
   /**
     * Name:buidPromotionHibrid
     * Params:$promotionB
     * Description:Construlle la lista de las promociones tipo B
     * Return: $promotionModel
     */
    public function buidPromotionHibrid($promotionB) {
         $promotionsModel = array();

    if (count($promotionB)>0) {
        $grouped = array_group_by($promotionB[0]['products'], "line");
        if (count($grouped) > 0) {
            $promotionsModel["required"] = $promotionB[0]['required'];
            $promotionsModel["type"] = "B";
            $promotionsModel["name"] = $promotionB[0]['name'];
           $promotionsModel['maxQuantity'] = $promotionB[0]['maxQuantity'];
           $items=array(); 
           foreach ($grouped as $p) {
               $points=0;
               $price=0;
               $products = array();
                foreach ($p as $product) {
                    $points=$points+$product['points'];
                    $price=($product['price'] * $product['quantity']);                    
                    array_push($products,(array)$this->getProducts($product));
                }        

                array_push($items, $this->getPromotionHibridModel($price, $points, $promotionB,$products));

                $promotionsModel['items'] = $items;
            }
            $promotionsModel['items']=$items;
           } else {
            return null;
        }
    }else{
        return null;
    }

        return $promotionsModel;
    }
    private function getPromotionHibridModel($price,$points,$promotionB,$products){                        
                  $promotionObj = new PromotionProductCombo();                  
                  $promotionObj->setIsCombo(true);
                  $promotionObj->setPrice($price);
                  $promotionObj->setPoints($points);
                  $promotionObj->setTotal($price);
                  $promotionObj->setQuantity(1);    
                  $promotionObj->setMax_cuantity($promotionB[0]['maxQuantity']);
                  $promotionObj->setProducts($products);
                  $promotionObj->setType($promotionB[0]['type']);
                  $promotionObj->setName($promotionB[0]['name']);
                  $promotionObj->setRequired($promotionB[0]['required']);
                  return $promotionObj;
}

    public function buidPromotionProduct($promotion) {
        $promotionsModel = array();
        $listPromotion = array();
        if (count($promotion) > 0) {
            foreach ($promotion[0]['products'] as $product) {
                array_push($promotionsModel, $this->getProducts($product));
            }
            $listPromotion["required"] = $promotion[0]['required'];
        } else {
            return null;
        }
        $listPromotion["items"] = $promotionsModel;
        $listPromotion["name"] = $promotion[0]['name'];
        $listPromotion["type"] = "C";
        return $listPromotion;
    }
    
}
