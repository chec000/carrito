<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Cron\Entities\ShippingAddress;
use Modules\Orders\Entities\Models\OrderModel;

class Orders extends Model
{
    protected $fillable = [];
    protected $table = 'orders';
    protected $primaryKey = 'order_id';


    public function getOrdersByEoNumber($eoNumber){
        try{
            $ordersSQL = $this->where('eo_number', '=', $eoNumber)
                ->get();
            if(empty($ordersSQL)) {
                return array();
            } else {
                $dataOrdersModel = $this->getOrdersModel($ordersSQL);
                return $dataOrdersModel;
            }
        } catch ( Exception $e) {
            return null;
        }
    }

    public function getOrderWithDetail($order_id){

        $order = $this->getOrderById($order_id);
        $orderDetailEntity = new OrdersDetail();
        $orderDetail = $orderDetailEntity->getOrderDetailByOrderId($order->order_id);
        $order->setOrdersDetail($orderDetail);
        $shippingAddressEntity = new ShippingAddress();
        $shippingAddress = $shippingAddressEntity->getShippingAddressByOrderId($order->order_id);
        $order->setShippingAddress($shippingAddress);

        return $order;
        //print_r($data); exit();
    }

    private function getOrderById($order_id){
        $order = $this->where('order_id', '=', $order_id)
            ->first();
        $orderModel = $this->getOrderModel($order);
        return $orderModel;
    }

    private function getOrdersModel($orders){
        $ordersModel = array();

        foreach ($orders as $order){
            $orderModel = $this->getOrderModel($order);
            array_push($ordersModel, $orderModel);
        }
        return $ordersModel;
    }

    private function getOrderModel($order) {
        $orderModel = new OrderModel();

        $orderModel->setOrderId($order->order_id);
        $orderModel->setCountryId($order->country_id);
        $orderModel->setEoNumber($order->eo_number);
        $orderModel->setOrderNumber($order->order_number);
        $orderModel->setAmount($order->amount);
        $orderModel->setPoints($order->points);
        $orderModel->setTaxAmount($order->tax_amount);
        $orderModel->setDiscount($order->discount);
        $orderModel->setShippingCompany($order->shipping_company);
        $orderModel->setGuideNumber($order->guide_number);
        $orderModel->setCorbizOrderNumber($order->corbiz_order_number);
        $orderModel->setPaymentType($order->payment_type);
        $orderModel->setShopType($order->shop_type);
        $orderModel->setCorbizTransaction($order->corbiz_transaction);
        $orderModel->setWharehouse($order->wharehouse);
        $orderModel->setOrderStatusId($order->order_status_id);
        $orderModel->setManagement($order->management);
        $orderModel->setCreatedAt($order->created_at);
        $orderModel->setUpdatedAt($order->updates_at);

        return $orderModel;
    }


}
