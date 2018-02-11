<?php

namespace Modules\Checkout\Entities;

use Modules\Products\Entities\Zip_code;
use Exception;
/**
 * Description of Zip_codes
 *
 * @author Marcos
 */
class Zip_codes extends Zip_code
{

    public function getStatesByZipcode($zipCode) {
        try {
           $statesZip = $this->select('state')
            ->where('zip', '=', $zipCode)
            ->where('status', '=', 1)
            ->orderBy('state', 'desc')
            ->groupBy('state')
            ->get()
            ->first();
    
        if(!$statesZip){
            $statesZip->state;
        }
        } catch (Exception $ex) {
        return null;
        }
        return $statesZip->state;
    }

    public function getCitysByZipcode($zipCode, $state) {
        $citysZip = $this->select('city')
            ->where('zip', '=', $zipCode)
            ->where('state', '=', $state)
            ->where('status', '=', 1)
            ->orderBy('city', 'desc')
            ->groupBy('city')
            ->get();

        return $citysZip;
    }

    public function getCountysByZipcode($zipCode, $state, $city) {
        try {
        $countysZip =$this->select('suburb')
            ->where('zip', '=', $zipCode)
            ->where('state', '=', $state)
            ->where('city', '=', $city)
            ->where('status', '=', 1)
            ->orderBy('suburb', 'desc')
            ->groupBy('suburb')
            ->get();
    
        } catch (Exception $ex) {
        return null;    
        }
        
        return $countysZip;
    }

}
