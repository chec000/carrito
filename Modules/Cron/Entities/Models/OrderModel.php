<?php


namespace Modules\Cron\Entities\Models;

/**
 * Description of Orders
 *
 */
class OrderModel {

    /**
     * @return mixed
     */
    public function getOrderProducts()
    {
        return $this->orderProducts;
    }

    /**
     * @param mixed $orderProducts
     */
    public function setOrderProducts($orderProducts)
    {
        $this->orderProducts = $orderProducts;
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
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * @param mixed $country_id
     */
    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;
    }

    /**
     * @return mixed
     */
    public function getCountryShortName()
    {
        return $this->country_short_name;
    }

    /**
     * @param mixed $country_short_name
     */
    public function setCountryShortName($country_short_name)
    {
        $this->country_short_name = $country_short_name;
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
    public function getOrderNumber()
    {
        return $this->order_number;
    }

    /**
     * @param mixed $order_number
     */
    public function setOrderNumber($order_number)
    {
        $this->order_number = $order_number;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return mixed
     */
    public function getTaxAmount()
    {
        return $this->tax_amount;
    }

    /**
     * @param mixed $tax_amount
     */
    public function setTaxAmount($tax_amount)
    {
        $this->tax_amount = $tax_amount;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getShippingCompany()
    {
        return $this->shipping_company;
    }

    /**
     * @param mixed $shipping_company
     */
    public function setShippingCompany($shipping_company)
    {
        $this->shipping_company = $shipping_company;
    }

    /**
     * @return mixed
     */
    public function getGuideNumber()
    {
        return $this->guide_number;
    }

    /**
     * @param mixed $guide_number
     */
    public function setGuideNumber($guide_number)
    {
        $this->guide_number = $guide_number;
    }

    /**
     * @return mixed
     */
    public function getCorbizOrderNumber()
    {
        return $this->corbiz_order_number;
    }

    /**
     * @param mixed $corbiz_order_number
     */
    public function setCorbizOrderNumber($corbiz_order_number)
    {
        $this->corbiz_order_number = $corbiz_order_number;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    /**
     * @param mixed $payment_type
     */
    public function setPaymentType($payment_type)
    {
        $this->payment_type = $payment_type;
    }

    /**
     * @return mixed
     */
    public function getBankTransaction()
    {
        return $this->bank_transaction;
    }

    /**
     * @param mixed $bank_transaction
     */
    public function setBankTransaction($bank_transaction)
    {
        $this->bank_transaction = $bank_transaction;
    }

    /**
     * @return mixed
     */
    public function getShopType()
    {
        return $this->shop_type;
    }

    /**
     * @param mixed $shop_type
     */
    public function setShopType($shop_type)
    {
        $this->shop_type = $shop_type;
    }

    /**
     * @return mixed
     */
    public function getErrorCorbiz()
    {
        return $this->error_corbiz;
    }

    /**
     * @param mixed $error_corbiz
     */
    public function setErrorCorbiz($error_corbiz)
    {
        $this->error_corbiz = $error_corbiz;
    }

    /**
     * @return mixed
     */
    public function getCorbizTransaction()
    {
        return $this->corbiz_transaction;
    }

    /**
     * @param mixed $corbiz_transaction
     */
    public function setCorbizTransaction($corbiz_transaction)
    {
        $this->corbiz_transaction = $corbiz_transaction;
    }

    /**
     * @return mixed
     */
    public function getWharehouse()
    {
        return $this->wharehouse;
    }

    /**
     * @param mixed $wharehouse
     */
    public function setWharehouse($wharehouse)
    {
        $this->wharehouse = $wharehouse;
    }

    /**
     * @return mixed
     */
    public function getManagement()
    {
        return $this->management;
    }

    /**
     * @param mixed $management
     */
    public function setManagement($management)
    {
        $this->management = $management;
    }

    /**
     * @return mixed
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * @param mixed $attempts
     */
    public function setAttempts($attempts)
    {
        $this->attempts = $attempts;
    }

    /**
     * @return mixed
     */
    public function getLastModifier()
    {
        return $this->last_modifier;
    }

    /**
     * @param mixed $last_modifier
     */
    public function setLastModifier($last_modifier)
    {
        $this->last_modifier = $last_modifier;
    }

    /**
     * @return mixed
     */
    public function getChangePeriod()
    {
        return $this->change_period;
    }

    /**
     * @param mixed $change_period
     */
    public function setChangePeriod($change_period)
    {
        $this->change_period = $change_period;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getOrderStatusId()
    {
        return $this->order_status_id;
    }

    /**
     * @param mixed $order_status_id
     */
    public function setOrderStatusId($order_status_id)
    {
        $this->order_status_id = $order_status_id;
    }


    /**
     * @return mixed
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param mixed $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }


    /**
     * @return mixed
     */
    public function getOrdersDetail()
    {
        return $this->ordersDetail;
    }

    /**
     * @param mixed $ordersDetail
     */
    public function setOrdersDetail($ordersDetail)
    {
        $this->ordersDetail = $ordersDetail;
    }


}
