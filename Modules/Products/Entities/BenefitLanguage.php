<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * 
 */
class BenefitLanguage extends Model {

    protected $fillable = [];
    protected $table = 'benefit_language';
    protected $primary_key = 'banefit_language_id';

    public function benefitLanguage() {
        return $this->hasOne('Modules\Products\Entities\Benefit');
    }

    public function getBenefitByCountry($country,$language_id){
        try{
                 $benefit = DB::table('benefit as b')
                ->join('benefit_language as bl', 'bl.benefit_id', '=', 'b.benefit_id')
                  ->where(([
                      ['b.country_id','=',$country['country_id']],
                     ['bl.language_id','=',$language_id],
                     ['bl.estatus','=',1]                                            
                    ]))
                ->select('b.benefit_id', 'bl.benefit')->get(); 
        } catch (Exception $e){
            return null;
        }                      
          return $benefit;
    }
    public function getBenfitsByProduct($product_id){
        try {
            $language_id = session()->get('language.0.language_id');          
                    $benefits=DB::table('product_benefit as pb')
                ->join('benefit as b', 'b.benefit_id', '=', 'pb.benefit_id')
                ->join('benefit_language as bl','bl.benefit_id','=','b.benefit_id')
                ->join('product as p','p.product_id','=','pb.product_id')
                  ->where([
                      ['pb.product_id','=',$product_id],
                      ['pb.estatus','=',1],
                      ['pl.language','=',$language_id]
                          ])
                ->select('bl.*')->distinct()->get();
        } catch (Exception $ex) {
            return null;
        }

         return $benefits;           
    }
        public function getBenefitName($benefit_id,$language_id) {
        try {
        $benefitName= $this->where(
                [["benefit_id",$benefit_id],
                 ["language_id",$language_id]   
                    ])->select('benefit')->first();
           $benefit=$benefitName->benefit;                    
        } catch (Exception $ex) {
            $benefit="";
        }      
        return $benefit;
    }

}
