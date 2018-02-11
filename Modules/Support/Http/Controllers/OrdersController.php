<?php

namespace Modules\Support\Http\Controllers;


use App\Order;
use App\OrderDetail;
use App\Language;
use App\Product;
use App\ProductLanguage;
use App\LogOrder;
use App\ShippingAddress;
use App\OrderStatusHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Support\Http\Requests\OrderRequest;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:orders.index', ['only' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('support::order.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('support::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, OrderRequest $orderRequest)
    {
        /* $order = new Order();

        $order->country_id = Auth::user()->country_id;
        $order->modified_by = Auth::user()->id;
        $order->is_main_order = $request->is_main_order;
        $order->estatus = $request->estatus;
        $order->list_order = !empty($request->list_order) ? $request->list_order : 0;

        $order->save();


        $order = new Order();
        $order->order_id = $order->order_id;
        $order->language_id = $request->language_id;
        $order->order = $request->order;
        $order->estatus = $request->estatus;
        $order->save();

        return response()->json($order); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$data['language'] = Language::where('estatus','!=', -1)->get();


        $data['order'] = Order::where('country_id',Auth::user()->country_id)
                                ->with('orderstatus')
                                ->get();




        return response()->json($data);
    }

    public function showOrderIndex($id)
    {
        return view('support::order.detail', compact('id'));
    }
    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function showOrder($id)
    {
        /* $order = Order::where('order_id','=', $id)
                                    ->with('order')->get(); */

       /*  $order['order'] = Order::find($id);
        $order['order'] = Order::where('order_id',$id)
                          ->with('orderstatus')
                          ->with('shippingaddress')
                          ->with('country')
                          ->with('orderdetail')
                          ->first();



        return response()->json($order); */
        //try{
            $tableShippingAddress = 'shipping_address as ship_add';

            $arrSelect = array(
                'orders.*',
                'ship_add.type as ship_type',
                'ship_add.address as ship_address',
                'ship_add.number as ship_number',
                'ship_add.complement as ship_complement',
                'ship_add.suburb as ship_colonia',
                'ship_add.zip_code as ship_zip_code',
                'ship_add.city as ship_city',
                'ship_add.city_name as ship_city_name',
                'ship_add.state as ship_state',
                'ship_add.county as ship_contry',
                'ship_add.country_key as ship_country',
                'ship_add.email as ship_email',
                'ship_add.telephone as ship_telephone',
                'stat.status as estatus',
                'stat.comment as estatus_comm',
                'usrs.name as last_modifier_name'
            );

            $orderDet = Order::findOrFail($id);

            if($orderDet->shop_type == 'INSCRIPCION')
            {

                array_push($arrSelect, 'ship_add.sponsor as ship_sponsor','ship_add.sponsor_name as ship_sponsor_name');

            }

            $orders = Order::select($arrSelect)
                ->where('orders.order_id','=',$id)
                ->leftjoin($tableShippingAddress,'ship_add.order_id','=','orders.order_id')
                //->leftjoin('payment_type as payment','payment.id','=','order.payment_type')
                ->leftjoin('order_status as stat','stat.order_status_id','=','orders.order_status_id')
                ->leftjoin('users as usrs','usrs.id','=','orders.last_modifier')
                ->get()->first()->toArray();


            $order_detail = OrderDetail::select('order_detail.*',
                'prod.name as prod_name',
                'pd.sku as prod_code',
                'pd.is_kit as iskit',
                'prod.short_description as prod_description')
                ->where('order_id','=',$id)
                ->leftjoin('product_language as prod','prod.product_id','=','order_detail.product_id')
                ->leftjoin('product as pd','pd.product_id','=','prod.product_id')
                ->groupBy('order_detail_id')
                ->get()->toArray();





            // return view('support::purchaseorders.view', array('order'=>$order, 'order_detail'=>$order_detail));
            $productos = Product::where('product.estatus',1)
                                          ->where('country_id',Auth::user()->country_id)
                                          ->leftjoin('product_language as pl','pl.product_id','=','product.product_id')
                                          ->get();
            $order = array('order'=>$orders, 'order_detail'=>$order_detail, 'productos'=>$productos);


            return response()->json($order);
        /* }
           catch (\Exception $ex){
                abort('404');
            } */
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */


    public function update(Request $request, $id, OrderRequest $orderRequest)
    {

       /*  $order = Order::find($id);
        $order->language_id = $request->language_id;
        $order->order = $request->order;
        $order->estatus = $request->estatus;
        $order->save();
        return response()->json($order); */
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {

        /* $order = Order::find($id);
        $order->estatus = -1;
        $order->deleted_at = Carbon::now();
        $order->save();
        return response()->json([$order]); */
    }

    public function on($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 4;
        $order->last_modifier = Auth::user()->id;
        $order->save();
        return response()->json([$order]);
    }

    public function off($id)
    {
        /* $order = Order::find($id);
        $order->estatus = ;
        $order->save();
        return response()->json($order); */
    }

    public function deleteItem($id)
    {
        // $this->authorize('delete', Almacenes::class);

        $orden_producto = OrderDetail::find($id);
        $orden_producto->active = -1;
        //$orden_producto->last_updated = Carbon::now();
        $orden_producto->save();
        return response()->json([$id]);
    }

    public function updateItem($id)
    {
        $orden_producto = OrderDetail::find($id);
        $orden_producto->active = 0;
        $orden_producto->save();
        return response()->json([$id]);
    }

    public function enviaCostos(Request $request)
    {
        $pedido = OrderDetail::where('order_id',$request->order['order_id'])->where('active','!=',-1)->get()->toArray();

        $productsWS = $this->convertItemsToFormatWS($pedido,$request->productos_nuevos);

        $shippingAddress = ShippingAddress::where('order_id',$request->order['order_id'])->first();

        $params = $this->getWsArtParams($productsWS,$shippingAddress,$request->order['armazen']);

        $resultItems = $this->wsShopping->consumeService('articulosAceptadosBra', $params);
        $items = '';

        if ($resultItems['status'] && isset($resultItems['result'])) {
            if (!empty($resultItems['result']->pch_xml_arts)) {
                if (stristr($resultItems['result']->pch_xml_arts, 'mensaje_error') !== FALSE) {
                    $resultItems = $respuesta->mensaje_error;
                } else {
                    $items = $this->wsShopping->convertXmlToArray($resultItems['result']->pch_xml_arts);
                }
            }
        }

        return response()->json([ 'datos' => $resultItems, 'item' => $items ]);
    }

    public function guardaOrden(Request $request)
    {
        //Obtener la informacin de la orden actual de la BD

        $order = Order::where('order_id',$request->order['order_id'])->first();

        //Guardar en log como esta la orden y los nuevos valores
        $logId = $this->altaLogOrder($order,$request->order);

        //Actualizar Productos eliminados en estado -2
        $delProd = $this->delProdOrder($request->order['order_id']);

        //Agregar Nuevos produtos del pedido
        $altaProd = $this->altaProdOrder($request->order['order_id'], $request->productos_nuevos, $request->orderProducts);

        //editar la orden con los nuevos valores y cambia status a 4
        $updateOrder = $this->updateOrder($request->order);

        return response()->json([ 'respuesta' => 'Order modificada correctamente' ]);
    }

    private function altaProdOrder($order_id, $altaProductNew, $altaProductOld)
    {
        foreach ($altaProductNew as $apn) {
            $altaProd = new OrderDetail;
            $altaProd->order_id = $order_id;
            $altaProd->product_id = $apn['product_id'];
            $altaProd->final_price = $apn['price'];
            $altaProd->points = $apn['points'];
            $altaProd->quantity = $apn['quantity'];
            $altaProd->active = 1;
            $altaProd->save();
        }
        // foreach ($altaProductOld as $apo) {
        //     if ($apo['active'] != -1) {
        //         $altaProd1 = new Order_detail;
        //         $altaProd1->order_id = $order_id;
        //         $altaProd1->product_id = $apo['product_id'];
        //         $altaProd1->final_price = $apo['final_price'];
        //         $altaProd1->points = $apo['points'];
        //         $altaProd1->quantity = $apo['quantity'];
        //         $altaProd1->active = 1;
        //         $altaProd1->save();
        //     }
        // }

    }

    private function delProdOrder($order_id)
    {
        $datosProd = OrderDetail::where('order_id',$order_id)->get();
        foreach ($datosProd as $daPro) {
            if ($daPro->active == -1) {
                $daPro->active = -2;
                $daPro->save();
                // $daPro->active = -3;
                // $daPro->save();
            }
            // else{
            // $daPro->active = -2;
            // $daPro->save();
            // }
        }
    }

    private function updateOrder($valOrden)
    {
        $updateOrder = Order::find($valOrden['order_id']);
        // $updateOrder->amount = $valOrden['amount'];
        // $updateOrder->points = $valOrden['points'];
        // $updateOrder->tax_amount = $valOrden['tax_amount'];
        $updateOrder->last_modifier = Auth::user()->id;
        $updateOrder->order_status_id = 4;
        $updateOrder->save();
    }

    private function altaLogOrder($valOld, $valNew)
    {

        $logOrder = new LogOrder;
        $logOrder->order_id = $valOld->order_id;
        $logOrder->orden = $valOld->order_number;
        $logOrder->amount = $valOld->amount;
        $logOrder->points = $valOld->points;
        $logOrder->tax_amount = $valOld->tax_amount;
        $logOrder->error_corbiz = $valOld->error_corbiz;
        // $logOrder->last_modifier = $valOld->last_modifier;
        $logOrder->last_modifier = 1;
        $logOrder->amount_new = $valNew['amount'];
        $logOrder->points_new = $valNew['points'];
        $logOrder->tax_amount_new = $valNew['tax_amount'];
        $logOrder->last_modifier_new = Auth::user()->id;
        $logOrder->save();
        return $logOrder;
    }

    public function changeStatus(Request $request)
    {
        $success = false;
        $message = '';
        if($request->ajax())
        {
            try{
                $order = Order::findOrFail($request->input('id'));
                $newStatus = 4;
                $order->update(['order_status_id' => $newStatus]);
                $success = true;
            }catch (\Exception $ex)
            {
                $message = $ex->getMessage();
            }
        }
        return response()->json(['success' => $success, 'message' => $message ]);
    }

    public function showOrderLogs($id){
        try{
            $tableShippingAddress = 'shipping_address as ship_add';
            $arrSelect = array(
                'orders.*',
                'ship_add.type as ship_type',
                'ship_add.address as ship_address',
                'ship_add.number as ship_number',
                'ship_add.complement as ship_complement',
                'ship_add.suburb as ship_colonia',
                'ship_add.zip_code as ship_zip_code',
                'ship_add.city as ship_city',
                'ship_add.city_name as ship_city_name',
                'ship_add.state as ship_state',
                'ship_add.county as ship_contry',
                'ship_add.country_key as ship_country',
                'ship_add.email as ship_email',
                'ship_add.telephone as ship_telephone',
                'stat.status as estatus',
                'stat.comment as estatus_comm'

            );

            $orderDet = Order::findOrFail($id);
            if($orderDet->shop_type == 'INSCRIPCION')
            {
                array_push($arrSelect, 'ship_add.sponsor as ship_sponsor','ship_add.sponsor_name as ship_sponsor_name','ship_add.cpf as ship_cpf');

            }

            $order = Order::select($arrSelect)
                ->where('orders.order_id','=',$id)
                ->leftjoin($tableShippingAddress,'ship_add.order_id','=','orders.order_id')
                ->leftjoin('order_status as stat','stat.order_status_id','=','orders.order_status_id')
                ->get()->first()->toArray();

            $logs_detail = OrderStatusHistory::select('order_status_history.*','stat.status as estatus','usrs.name as last_modifier_name')
                ->where('order_id','=',$id)
                ->leftjoin('order_status as stat','stat.order_status_id','=','order_status_history.status_id')
                ->leftjoin('users as usrs','usrs.id','=','order_status_history.last_modifier')
                ->get()->toArray();
            //dd($logs_detail);
            //dd($order);
            return view('support::order.view_log', array('order'=>$order, 'logs_detail'=>$logs_detail));

        }catch (\Exception $ex)
        {
            dd($ex->getMessage());
            abort(404);
        }
    }
}
