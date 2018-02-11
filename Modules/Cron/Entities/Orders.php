<?php

namespace Modules\Cron\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;
use Modules\Cron\Entities\Models\OrderModel;
use Modules\Cron\Entities\OrderDetail;
use Modules\Products\Entities\Country;

class Orders extends Model
{
    protected $fillable = [];
    protected $table = 'orders';
    protected $primary_key = 'order_id';

    //

    //Function to get a orders by status success (order_status_id =4)
    public function getOrdersByStatusSuccess(){
        try{
            $ordersSQL = $this->where('order_status_id', '=', 4)
            ->get();
            if(empty($ordersSQL)) {
                return array();
            } else {
                $dataOrdersModel = $this->getOrderModel($ordersSQL);
                return $dataOrdersModel;
            }
        } catch ( Exception $e) {
            return null;
        }
    }

    private function getOrderModel($orders) {

        $ordersModel = array();

        foreach ($orders as $order){
            $orderModel = new OrderModel();

            $orderModel->setOrderId($order->order_id);
            $orderModel->setCountryId($order->country_id);
            $orderModel->setEoNumber($order->eo_number);
            $orderModel->setOrderNumber($order->order_number);
            $orderModel->setAmount($order->amount);
            $orderModel->setPoints($order->points);
            $orderModel->setTaxAmount($order->tax_amount);
            $orderModel->setTaxAmount($order->discount);
            $orderModel->setShippingCompany($order->shipping_company);
            $orderModel->setGuideNumber($order->guide_number);
            $orderModel->setCorbizOrderNumber($order->corbiz_order_number);
            $orderModel->setPaymentType($order->payment_type);
            $orderModel->setShopType($order->shop_type);
            $orderModel->setErrorCorbiz($order->error_corbiz);
            $orderModel->setCorbizTransaction($order->corbiz_transaction);
            $orderModel->setWharehouse($order->wharehouse);
            $orderModel->setAttempts($order->attempts);
            $orderModel->setOrderStatusId($order->order_status_id);

            //get countryShortName
            $country = new Country();
            $countryShortName = $country->getShorNameCountryById($order->country_id);
            $orderModel->setCountryShortName($countryShortName->short_name);
            //get order address ship
            $shippingAddress = new ShippingAddress();
            $orderModel->setShippingAddress($shippingAddress->getShippingAddressByOrderId($order->order_id));
            //get orderDetails
            $orderDetailModel = new OrderDetail();
            $orderModel->setOrderProducts($orderDetailModel->getOrdersDetailByOrderId($order->order_id, false));

            array_push($ordersModel, $orderModel);
        }
        return $ordersModel;
    }

    public function updateOrders($order_id, $arrayData){
        print_r($arrayData);
        try{
            $resultUpdate = $this->where('order_id', $order_id)
                ->update($arrayData);
        } catch (Exception $ex) {
            return null;
        }

    }
}
