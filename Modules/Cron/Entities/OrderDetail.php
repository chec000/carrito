<?php

namespace Modules\Cron\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Cron\Entities\Models\OrderDetailModel;
use Exception;

class OrderDetail extends Model
{
    protected $fillable = [];
    protected $table = 'order_detail';
    protected $primary_key = 'order_detail_id';

    public function getOrdersDetailByOrderId($order_id, $booleanWsGenerateTransaction = false) {
        try {
                if($booleanWsGenerateTransaction){
                    $queryResult = $this->where('order_id', '=', $order_id)
                        ->where('active', '=', 1)
                        ->get();
                    if (empty($queryResult)) {
                        return array();
                    } else {
                        $orderResult = $this->getOrderDetailWsGenerateTransaction($queryResult);
                    }
                } else {
                    $queryResult = $this->select('order_detail.product_id','order_detail.quantity', 'order_detail.active','product.sku')
                        ->where('order_id', '=', $order_id)
                        ->leftJoin('product', 'order_detail.product_id', '=', 'product.product_id')
                        ->get();
                    if (empty($queryResult)) {
                        return array();
                    } else {
                        $orderResult = $this->getOrderDetailWsCloseTransaction($queryResult);
                    }
                }

                return $orderResult;
        } catch(Exception $ex) {
            return null;
        }

    }

    public function getOrderDetailWsGenerateTransaction($ordersDetail) {
        $arrayResult = array();
        foreach ($ordersDetail as $orderDetail) {

            $arrayData = array();
            $arrayData['codigo'] = $orderDetail->product_id;
            $arrayData['cantidad'] = $orderDetail->quantity;
            $arrayData['precio'] = $orderDetail->final_price;
            $arrayData['puntos'] = $orderDetail->points;

            array_push($arrayResult, $arrayData);
        }

        return $arrayResult;
    }

    public function getOrderDetailWsCloseTransaction($ordersDetail) {
        $arrayResult = array();
        foreach ($ordersDetail as $orderDetail) {

            $arrayData = array();
            $arrayData['sku'] = $orderDetail->sku;
            $arrayData['quantity'] = $orderDetail->quantity;
            $arrayData['status'] = $orderDetail->active;

            array_push($arrayResult, $arrayData);
        }

        return $arrayResult;
    }

    public function getOrderDetailModel($ordersDetail) {
        $arrayResult = array();
        foreach ($ordersDetail as $orderDetail) {
            $orderDetailModel = new OrderDetailModel();

            $orderDetailModel->setOrderDetailId($orderDetail->order_detail_id);
            $orderDetailModel->setOrderId($orderDetail->order_id);
            $orderDetailModel->setProductId($orderDetail->product_id);
            $orderDetailModel->setFinalPrice($orderDetail->final_price);
            $orderDetailModel->setPoints($orderDetail->points);
            $orderDetailModel->setQuantity($orderDetail->quantity);
            $orderDetailModel->setActive($orderDetail->active);
            $orderDetailModel->setIsPromo($orderDetail->is_promo);
            $orderDetailModel->setPromoType($orderDetail->promo_type);
            $orderDetailModel->setPromoCode($orderDetail->promo_code);
            $orderDetailModel->setPromoProductName($orderDetail->promo_product_name);

            array_push($arrayResult, $orderDetailModel);
        }

        return $arrayResult;
    }
}
