<?php

    namespace Modules\Cron\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Cron\Entities\OrderDetail;
    use Modules\Cron\Entities\ShippingAddress;
    use Modules\Cron\Entities\Orders;
    use App\Http\Controllers\MailController;
    use App\UrlService;
    use Modules\Inscription\Http\Controllers\InscriptionController;

    class CronController extends Controller {
    public function testFunction(){
        $orderDetailEntity = new OrderDetail();
        $result = $orderDetailEntity->getOrdersDetailByOrderId(4);
        return $result;
    }

    public function getOrdersSuccess(){
        $orders = new Orders();
        $ordersList = $orders->getOrdersByStatusSuccess();
        var_dump($ordersList);
        $this->evalCorbizTransaction($ordersList);
    }

    private function evalCorbizTransaction($ordersList){
        foreach ($ordersList as $order) {
            //validate to have a corbiz_transaction;
            if($order->getCorbizTransaction() == null || $order->getCorbizTransaction() == '' || $order->getCorbizTransaction() == 0) {
                $generateTransaction = $this->getDataToGenerateTransaction($order);

                $orders = new Orders();
                if($generateTransaction['exito']){
                    $arrayUpdateOrders = [
                        'corbiz_order_number' =>$generateTransaction['orden'],
                    ];

                    var_dump('Data corbiz_transaction to Update table shipping_address at order_id '.$order->getOrderId().':');
                    var_dump($arrayUpdateOrders);
                    $orders->updateOrders($order->getOrderId(), $arrayUpdateOrders);

                    $order->setCorbizTransaction($generateTransaction['transaccion']);
                    $this->wsCloseTransaction($order);
                } else {
                    $arrayUpdateOrders = [
                        'error_corbiz' => isset($generateTransaction['data']['error']) ? $generateTransaction['data']['error'] : "No error catch",
                        'order_status_id' =>11,
                    ];
                    var_dump('Data error corbiz_transaction to Update table shipping_address at order_id '.$order->getOrderId().':');
                    var_dump($arrayUpdateOrders);
                    $orders->updateOrders($order->getOrderId(), $arrayUpdateOrders);
                }
            } else {
                $this->wsCloseTransaction($order);
            }
        }

    }

    private function wsCloseTransaction ($order){
            //validate to have a corbiz_transaction;
            $data = array(
                "metodo" => "cierraTransaccionWeb",
                "params" => array(
                    "pais" => $order->getCountryShortName(),
                    "accion" => $order->getShopType(),
                    "transaccion" => str_pad($order->getCorbizTransaction(), 20, "0", STR_PAD_LEFT),
                    "products" => $order->getOrderProducts()
                )
            );
            var_dump('Data to WS cierraTransaccionWeb:');
            var_dump($data);

            $result = UrlService::webService($data);
            var_dump('Result WS cierraTransaccionWeb:');
            var_dump($result);
            $this->evalResutWsCloseTansaction($result,$order);
    }


    private function evalResutWsCloseTansaction($result,$order){
        $orders = new Orders();
        if($result['exito']){
            $arrayData = [
                'order_id' => $order->getOrderId(),
                'order_status_id' =>10,
            ];

            $cron = array(
                    'user' => array(
                        'email' => $order->shippingAddress->email, 
                        'name' => $order->shippingAddress->eo_name
                        ), 
                    'sponsor' => array(
                        'email' => $order->shippingAddress->sponsor_email,
                        'name' => $order->shippingAddress->sponsor_name
                        )
                    );

            if($order->getShopType() == 'INSCRIPCION'){
                //Generar PDF de inscripcion
                $inscriptionController = new InscriptionController();

                $params['formReg']['name'] = $order->shippingAddress->eo_name;
                $params['formReg']['last_name'] = " ";
                $params['formReg']['address'] = $order->shippingAddress->address;
                $params['formReg']['federal_entities'] =$order->shippingAddress->city_name;
                $params['formReg']['state'] = $order->shippingAddress->state;
                $params['formReg']['zip_code'] = $order->shippingAddress->zip_code;
                $params['formReg']['birthdate'] =$order->shippingAddress->birthdate;
                $params['formReg']['email'] = $order->shippingAddress->email;
                $params['formReg']['phone_number'] =$order->shippingAddress->cell_number;

                $inscriptionController->cron_pdf_generator($params, "PDF", $order->shippingAddress->language_short_name, $result["data"]['usuario']);

                $arrayDataUpdateSA =[
                    'eo_number'=> $result["data"]['usuario'],
                    'password' => $result["data"]['contrasena']
                ];

                var_dump('Data to Update table shipping_address at order_id '.$order->getOrderId().':');
                var_dump($arrayDataUpdateSA);
                $shippingAddress = new ShippingAddress();
                $shippingAddress->updateDataResultByOrderId($order->getOrderId(), $arrayDataUpdateSA);
                MailController::send("sponsor", "New eo", "new_eo", array("eo_number" => $order->shippingAddress->eo_number, "cron" => $cron));
                MailController::send("user", "Welcome", "welcome", array("eo_number" => $order->shippingAddress->eo_number, "eo_password" => $order->shippingAddress->password, "eo_question" => $order->shippingAddress->security_question, "cron" => $cron));
            }
            // Here is function to send mail
            MailController::send("user", "Orden", "orden", array("orden" => $order->order_number, "cron" => $cron));

        } else {
            $arrayData = [
                //'order_id' => $order->getOrderId(),
                'order_status_id' =>11,
                'attempts' => $order->getAttempts() + 1,
                'error_corbiz' => isset($result['data']['error']) ? $result['data']['error'] : "No error catch",
            ];
        }
        //function to update table order db
        var_dump('Data to Update table orders at order_id '.$order->getOrderId().':');
        var_dump($arrayData);
        $orders->updateOrders($order->getOrderId(), $arrayData);
    }

    private function getDataToGenerateTransaction($order) {
        //get order data products detail
        $orderDetail = new OrderDetail();
        $order->setOrdersDetail($orderDetail->getOrdersDetailByOrderId($order->getOrderId(), true));

        $result = $this->wsGenerateTransaction($order);

        return $result;

    }

    private function wsGenerateTransaction($order){
        $data = array(
            "metodo" =>"generaTransaccionWeb",
            "pais" =>session()->get('formReg')['country'],
            "accion" =>$order->getShopType(),
            "distId" =>$order->getEoNumber(),
            "total" =>$order->getAmount(),
            "impuesto" =>$order->getTaxAmount(),
            "tipoPagoId" =>1,
            "direccionEnvio"=> array(
                "destinatario" =>$order->shippingAddress->eo_name,
                "direccion" =>$order->shippingAddress->address,
                "colonia" =>$order->shippingAddress->suburb,
                "codPostal" =>$order->shippingAddress->zip_code,
                "condado" =>$order->shippingAddress->county,
                "complemento" =>"",
                "ciudad" =>$order->shippingAddress->city,
                "estado" =>$order->shippingAddress->state,
                "compEnvio" =>$order->getShippingCompany(),
                "direccionAlterna_id" =>"",
                ),
            "productos" =>$order->getOrdersDetail(),
            "cambiaPeriodo" =>"",
            "datoExtra" =>""
        );
        var_dump('Data to WS generaTransaccionWeb:');
        var_dump($data);
        $result = UrlService::webService($data);
        var_dump('Result WS generaTransaccionWeb:');
        var_dump($result);
        return $result;
    }
}
