<?php

namespace Modules\Cron\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Cron\Entities\Models\ShippingAddressModel;
use Exception;
use Modules\Inscription\Entities\SecurityQuestion;

class ShippingAddress extends Model
{
    protected $fillable = [];
    protected $table = 'shipping_address';
    protected $primary_key = 'shipping_address_id';

    public function getShippingAddressByOrderId($orderId) {
        try {
            $resultQuery = $this->where('order_id', '=', $orderId)->first();

            if(empty($resultQuery)) {
                return array();
            } else {
                $resultModel = $this->getShippingAddressModel($resultQuery);
                return $resultModel;
            }

        } catch (Exception $ex) {
            return null;
        }

    }

    public function updateDataResultByOrderId($order_id, $dataArray){
        try{
            $this->where('order_id', $order_id)
                ->update($dataArray);
        }catch(Exception $ex){

        }

    }

    private function getShippingAddressModel($shippingAddress) {
        $shippingAddressModel = new ShippingAddressModel();

        $shippingAddressModel->setShippingAddressId($shippingAddress->shipping_address_id);
        $shippingAddressModel->setSponsor($shippingAddress->sponsor);
        $shippingAddressModel->setSponsorName($shippingAddress->sponsor_name);
        $shippingAddressModel->setSponsorEmail($shippingAddress->sponsor_email);
        $shippingAddressModel->setEoNumber($shippingAddress->eo_number);
        $shippingAddressModel->setEoName($shippingAddress->eo_name);
        $shippingAddressModel->setOrderId($shippingAddress->order_id);
        $shippingAddressModel->setType($shippingAddress->type);
        $shippingAddressModel->setFolio($shippingAddress->folio);
        $shippingAddressModel->setAddress($shippingAddress->address);
        $shippingAddressModel->setNumber($shippingAddress->number);
        $shippingAddressModel->setComplement($shippingAddress->complement);
        $shippingAddressModel->setSuburb($shippingAddress->suburb);
        $shippingAddressModel->setZipCode($shippingAddress->zip_code);
        $shippingAddressModel->setCity($shippingAddress->city);
        $shippingAddressModel->setCityName($shippingAddress->city_name);
        $shippingAddressModel->setState($shippingAddress->state);
        $shippingAddressModel->setCounty($shippingAddress->county);
        $shippingAddressModel->setCountryKey($shippingAddress->country_key);
        $shippingAddressModel->setEmail($shippingAddress->email);
        $shippingAddressModel->setTelephone($shippingAddress->telephone);
        $shippingAddressModel->setCellNumber($shippingAddress->cell_number);
        $shippingAddressModel->setGender($shippingAddress->gender);
        $shippingAddressModel->setSecurityQuestionId($shippingAddress->security_question_id);
        $shippingAddressModel->setAnswer($shippingAddress->answer);
        $shippingAddressModel->setKitType($shippingAddress->kit_type);
        $shippingAddressModel->setDocumentKey($shippingAddress->document_key);
        $shippingAddressModel->setDocumentNumber($shippingAddress->document_number);
        $shippingAddressModel->setPassword($shippingAddress->password);
        $shippingAddressModel->setBirthdate($shippingAddress->birthdate);
        $shippingAddressModel->setLanguageShortName($shippingAddress->language_short_name);

        $securityQuestionEntity = new SecurityQuestion();
        $securityQuestion= $securityQuestionEntity->getSegurityQuestionById($shippingAddress->security_question_id);
        $shippingAddressModel->setSecurityQuestion($securityQuestion['question']);

        return $shippingAddressModel;
    }
}
