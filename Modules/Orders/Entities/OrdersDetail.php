<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Entities\Models\OrderDetailModel;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\Models\ProductModel;


class OrdersDetail extends Model
{
    protected $fillable = [];
    protected $table = 'order_detail';
    protected $primaryKey = 'order_detail_id';

    public function getOrderDetailByOrderId($orderId){
        try{
            $ordersSQL = $this->where('order_id', '=', $orderId)
                ->get();
            if(empty($ordersSQL)) {
                return array();
            } else {
                $dataOrdersModel = $this->getOrderDetailModel($ordersSQL);
                return $dataOrdersModel;
            }
        } catch ( Exception $e) {
            return null;
        }
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

            //Get data of Product by product_id
            $productEntity = $product = Product::find($orderDetail->product_id);
            $orderDetailModel->setDataProduct($this->getProductModel($productEntity));

            array_push($arrayResult, $orderDetailModel);
        }
        return $arrayResult;
    }



    private function getProductModel($productEntity){
        $productModel = new ProductModel();

        $productModel->setProduct_id($productEntity['product_id']);
        $productModel->setSku($productEntity['sku']);
        $productModel->setPrice($productEntity['price']);
        $productModel->setPoints($productEntity['points']);
        $productModel->setProduct_id($productEntity['product_id']);

        return $productModel;
    }
}
