<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Checkout\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Checkout\Entities\Promotions;


/**
 * Description of PromotionController
 *
 * @author sergio
 */
class PromotionsController extends Controller {

    private $promotionA = array();
    private $promotionB = array();
    private $promotionC = array();

    public function PromotionCombo($type = "") {
        $promotion = new Promotions();   
       $this->truncatePromotions(session()->get("ListPromotions"));
       $listPromotionsResult= array(
         "promotionA"=>$promotion->buidPromotionCombo($this->promotionA),
           "promotionB"=>$promotion->buidPromotionHibrid($this->promotionB),
           "promotionC"=>$promotion->buidPromotionProduct($this->promotionC)
         );
         session()->put("ListPromotionsBuild",$listPromotionsResult);
        return$listPromotionsResult;
    }

    public function getPromotions(){
        if (session()->get('ListPromotionsBuild')) {
            return session()->get('ListPromotionsBuild');
        }else{
            return null;
        }
    }
    public function truncatePromotions($promotions) {
        foreach ($promotions as $p) {
                switch ($p['type']) {
                case "A":
                    array_push($this->promotionA, $p);
                    break;
                case "B":
                    array_push($this->promotionB, $p);
                case "C":
                    array_push($this->promotionC, $p);
            }                
        }
    }


}
