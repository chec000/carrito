<?php
namespace Modules\Orders\Entities\Models;

class OrderDetailModel
{

    /**
     * @return mixed
     */
    public function getOrderDetailId()
    {
        return $this->order_detail_id;
    }

    /**
     * @param mixed $order_detail_id
     */
    public function setOrderDetailId($order_detail_id)
    {
        $this->order_detail_id = $order_detail_id;
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
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getFinalPrice()
    {
        return $this->final_price;
    }

    /**
     * @param mixed $final_price
     */
    public function setFinalPrice($final_price)
    {
        $this->final_price = $final_price;
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
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getisPromo()
    {
        return $this->is_promo;
    }

    /**
     * @param mixed $is_promo
     */
    public function setIsPromo($is_promo)
    {
        $this->is_promo = $is_promo;
    }

    /**
     * @return mixed
     */
    public function getPromoType()
    {
        return $this->promo_type;
    }

    /**
     * @param mixed $promo_type
     */
    public function setPromoType($promo_type)
    {
        $this->promo_type = $promo_type;
    }

    /**
     * @return mixed
     */
    public function getPromoCode()
    {
        return $this->promo_code;
    }

    /**
     * @param mixed $promo_code
     */
    public function setPromoCode($promo_code)
    {
        $this->promo_code = $promo_code;
    }

    /**
     * @return mixed
     */
    public function getPromoProductName()
    {
        return $this->promo_product_name;
    }

    /**
     * @param mixed $promo_product_name
     */
    public function setPromoProductName($promo_product_name)
    {
        $this->promo_product_name = $promo_product_name;
    }

    /**
     * @return mixed
     */
    public function getDataProduct()
    {
        return $this->dataProduct;
    }

    /**
     * @param mixed $dataProduct
     */
    public function setDataProduct($dataProduct)
    {
        $this->dataProduct = $dataProduct;
    }

}