<?php

namespace Modules\Orders\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Orders\Entities\Orders;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('orders::index');
    }

    public function getDataOrdersByEoNumber(){
        $ordersEntity = new Orders();
        $data = $ordersEntity->getOrdersByEoNumber(session()->get('userId'));
        //print_r($data); exit();

        return view('orders::yourOrder')->with('dataOrders',$data);
        //return $data;
    }

    public function getDataOrderWithDetail($order_id){
        //print_r($order_id);
        $ordersEntity = new Orders();
        $dataOrder = $ordersEntity->getOrderWithDetail($order_id);
        //print_r($data); exit();

        return view('orders::yourOrderDetail',compact('dataOrder'));
    }

}
