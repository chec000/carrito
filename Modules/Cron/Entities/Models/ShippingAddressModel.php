<?php


namespace Modules\Cron\Entities\Models;

/**
 * Description of OrdersDetail
 *
 */
class ShippingAddressModel {
/*
    private $shipping_address_id;
    private $sponsor;
    private $sponsor_name;
    private $sponsor_email;
    private $eo_number;
    private $eo_name;
    private $order_id;
    private $type;
    private $folio;
    private $address;
    private $number;
    private $complement;
    private $suburb;
    private $zip_code;
    private $city;
    private $city_name;
    private $state;
    private $county;
    private $country_key;
    private $email;
    private $telephone;
    private $cell_number;
    private $gender;
    private $security_question_id;
    private $answer;
    private $kit_type;
    private $document_key;
    private $document_number;
    private $creation_date;
    private $updated_date;
    private $password;
    private $security_question;
    private $birthdate;
    private $language_short_name;
*/

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getLanguageShortName()
    {
        return $this->language_short_name;
    }

    /**
     * @param mixed $language_short_name
     */
    public function setLanguageShortName($language_short_name)
    {
        $this->language_short_name = $language_short_name;
    }
    /**
     * @return mixed
     */
    public function getSecurityQuestion()
    {
        return $this->security_question;
    }

    /**
     * @param mixed $security_question
     */
    public function setSecurityQuestion($security_question)
    {
        $this->security_question = $security_question;
    }
    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * @return mixed
     */
    public function getShippingAddressId()
    {
        return $this->shipping_address_id;
    }

    /**
     * @param mixed $shipping_address_id
     */
    public function setShippingAddressId($shipping_address_id)
    {
        $this->shipping_address_id = $shipping_address_id;
    }

    /**
     * @return mixed
     */
    public function getSponsor()
    {
        return $this->sponsor;
    }

    /**
     * @param mixed $sponsor
     */
    public function setSponsor($sponsor)
    {
        $this->sponsor = $sponsor;
    }

    /**
     * @return mixed
     */
    public function getSponsorName()
    {
        return $this->sponsor_name;
    }

    /**
     * @param mixed $sponsor_name
     */
    public function setSponsorName($sponsor_name)
    {
        $this->sponsor_name = $sponsor_name;
    }

    /**
     * @return mixed
     */
    public function getSponsorEmail()
    {
        return $this->sponsor_email;
    }

    /**
     * @param mixed $sponsor_email
     */
    public function setSponsorEmail($sponsor_email)
    {
        $this->sponsor_email = $sponsor_email;
    }

    /**
     * @return mixed
     */
    public function getEoNumber()
    {
        return $this->eo_number;
    }

    /**
     * @param mixed $eo_number
     */
    public function setEoNumber($eo_number)
    {
        $this->eo_number = $eo_number;
    }

    /**
     * @return mixed
     */
    public function getEoName()
    {
        return $this->eo_name;
    }

    /**
     * @param mixed $eo_name
     */
    public function setEoName($eo_name)
    {
        $this->eo_name = $eo_name;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * @param mixed $folio
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * @param mixed $complement
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
    }

    /**
     * @return mixed
     */
    public function getSuburb()
    {
        return $this->suburb;
    }

    /**
     * @param mixed $suburb
     */
    public function setSuburb($suburb)
    {
        $this->suburb = $suburb;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * @param mixed $zip_code
     */
    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCityName()
    {
        return $this->city_name;
    }

    /**
     * @param mixed $city_name
     */
    public function setCityName($city_name)
    {
        $this->city_name = $city_name;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @param mixed $county
     */
    public function setCounty($county)
    {
        $this->county = $county;
    }

    /**
     * @return mixed
     */
    public function getCountryKey()
    {
        return $this->country_key;
    }

    /**
     * @param mixed $country_key
     */
    public function setCountryKey($country_key)
    {
        $this->country_key = $country_key;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getCellNumber()
    {
        return $this->cell_number;
    }

    /**
     * @param mixed $cell_number
     */
    public function setCellNumber($cell_number)
    {
        $this->cell_number = $cell_number;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getSecurityQuestionId()
    {
        return $this->security_question_id;
    }

    /**
     * @param mixed $security_question_id
     */
    public function setSecurityQuestionId($security_question_id)
    {
        $this->security_question_id = $security_question_id;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return mixed
     */
    public function getKitType()
    {
        return $this->kit_type;
    }

    /**
     * @param mixed $kit_type
     */
    public function setKitType($kit_type)
    {
        $this->kit_type = $kit_type;
    }

    /**
     * @return mixed
     */
    public function getDocumentKey()
    {
        return $this->document_key;
    }

    /**
     * @param mixed $document_key
     */
    public function setDocumentKey($document_key)
    {
        $this->document_key = $document_key;
    }

    /**
     * @return mixed
     */
    public function getDocumentNumber()
    {
        return $this->document_number;
    }

    /**
     * @param mixed $document_number
     */
    public function setDocumentNumber($document_number)
    {
        $this->document_number = $document_number;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @param mixed $creation_date
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
    }

    /**
     * @return mixed
     */
    public function getUpdatedDate()
    {
        return $this->updated_date;
    }

    /**
     * @param mixed $updated_date
     */
    public function setUpdatedDate($updated_date)
    {
        $this->updated_date = $updated_date;
    }

}
