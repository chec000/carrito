<?php

namespace Modules\Paypal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Checkout\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use App\UrlService;
use Modules\Inscription\Http\Controllers\InscriptionController;
use Modules\Paypal\Entities\RegisterOrder;
use Modules\Paypal\Entities\RegisterOrderDetails;
use Modules\Paypal\Entities\RegisterOrderShipAddress;
use App\Http\Controllers\MailController;
use Modules\Products\Entities\Cart;

class PaypalController extends Controller
{
    private $_api_context;
    public function __construct(){
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'],$paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function beforePayment(){
        $id_rnd = new InscriptionController;
        $rnd = $id_rnd->get_random_string(8);
        if (session()->get('ws_acceptedItems')['country']){
            session()->put("orderNumber",$rnd);
            $products = new CheckoutController;
            $prods = $products->separateProducts(session()->get('sessionProductsCart'));
            session()->put('prods',$prods['all']);
            $userId = session()->get('userId');
            if (session()->get('sponsor_selected')) {
                $sponsor = session()->get('sponsor');
            } else {
                $sponsor =  session()->get('sponsor_rnd'); 
            }
            $date = date('Y-m-d');
            $products = new CheckoutController;
            $prods = $products->separateProducts2(session()->get('sessionProductsCart'));
            if (!$userId) {
                $birthdate = explode("-",session()->get('formReg')['birthdate']);
                $birthdate2 = $birthdate[2]."-".$birthdate[0]."-".$birthdate[1];
                $data = array(
                    "metodo" =>"generaTransaccionWeb",
                    "params" => array(
                        "pais" =>session()->get('formReg')['country'],
                        "accion" =>"INSCRIPCION",
                        "distId" =>$sponsor['eo_number'],
                        "total" =>session()->get('totalProductsCart'),
                        "manejo" =>session()->get('management'),
                        "impuesto" =>session()->get('taxes'),
                        "tipoPagoId" =>3,
                        "direccionEnvio"=> array(
                            "destinatario" =>session()->get('formReg')['name']." ".session()->get('formReg')['last_name'],
                            "direccion" =>session()->get('formReg')['address'],
                            "colonia" =>session()->get('formReg')['county'],
                            "codPostal" =>session()->get('formReg')['zip_code'],
                            "condado" =>session()->get('formReg')['county'],
                            "complemento" =>"",
                            "ciudad" =>session()->get('formReg')['federal_entities'],
                            "estado" =>session()->get('formReg')['state'],
                            "compEnvio" =>session()->get('formReg')['ship_company'],
                            "direccionAlterna_id" =>0
                        ),
                        "registro" => array(
                            "patrocinador"=>$sponsor['eo_number'],
                            "apellidoP"=>session()->get('formReg')['last_name'],
                            "apellidoM"=>"",
                            "nombre"=>session()->get('formReg')['name'],
                            "sexo"=>session()->get('formReg')['gender'],
                            "fechaAlta"=>$date,
                            "fechaNac"=>$birthdate2,
                            "telefono"=>session()->get('formReg')['phone_number'],
                            "celular"=>"",
                            "email"=>session()->get('formReg')['email'],
                            "preguntaId"=>session()->get('formReg')['security_question'],
                            "respuesta"=>session()->get('formReg')['answer'],
                            "cedis"=>"TELENEV",
                            "almacen"=>"TELENEV",
                            "tipoKit"=>"DIGITAL2",
                            "documentos" => array(
                                "claveDoc" =>"",
                                "numDoc" =>"",
                                "fechaDoc" =>"",
                                "fechaExp" => ""
                            )
                        ),
                        "productos" =>$prods['all'],
                        "cambiaPeriodo" =>"",
                        "datoExtra" =>"Generico"
                    )
                );
            }else {
                $data = array(
                    "metodo" =>"generaTransaccionWeb",
                    "params" => array(
                        "pais" =>session()->get('formReg')['country'],
                        "accion" =>"VENTA",
                        "distId" =>session()->get('userId'),
                        "total" =>session()->get('totalProductsCart'),
                        "manejo" =>session()->get('management'),
                        "impuesto" =>session()->get('taxes'),
                        "tipoPagoId" =>1,
                        "direccionEnvio"=> array(
                            "destinatario" =>session()->get('adressShippDist')['nombre'],
                            "direccion" =>session()->get('adressShippDist')['direccion'],
                            "colonia" =>session()->get('adressShippDist')['condado'],
                            "codPostal" =>session()->get('adressShippDist')['cp'],
                            "condado" =>session()->get('adressShippDist')['condado'],
                            "complemento" =>false,
                            "ciudad" =>session()->get('adressShippDist')['ciudad'],
                            "estado" =>session()->get('adressShippDist')['estado'],
                            "compEnvio" =>session()->get('adressShippDist')['comp_env'],
                            "direccionAlterna_id" =>session()->get('adressShippDist')['folio']
                        ),
                        "productos" =>$prods['all'],
                        "cambiaPeriodo" =>false,
                        "datoExtra" =>"?"
                    )
                );
            }
            $result = UrlService::webService($data);
           // die(var_dump($result));
            if ($result['data']['transaccion']) {
                session()->put("corbiz_transaction",$result['data']['transaccion']);
                //session()->put("generaTransaccionWeb",$result['data']);
                $user = session()->get('formReg');
                if (!$user['new_user']) {
                    $user['eo_number'] = session()->get('userId');
                    $accion = "VENTA";
                }else{
                    $user['eo_number'] = 0;
                    $accion = "INSCRIPCION";
                }
                $regOrder = new RegisterOrder();
                $order = $regOrder->regOrder(session()->get('prods'),$user,$accion);
                session()->put("order_id",$order);
                $orderDetails = new registerOrderDetails();
                $details = $orderDetails->regOrderDetails(session()->get('sessionProductsCart'),session()->get('ListPromotions'),$order);
                $orderShip = new registerOrderShipAddress();
                $ship = $orderShip->regOrderShipAddress($user,$order);
                if(!session()->has('userId'))
                    MailController::send("sponsor", "New prospect", "new_prospect", array());
                
                return redirect('/paypal/payment');
            }
            else{
                session()->flash('message','Ocurrio un error durante el proceso.');
                return \Redirect::route('checkout');
            }
        }
    }

    public function postPayment(){
        $payer = new Payer(); 
        $payer->setPaymentMethod('paypal');
        $products = new CheckoutController;
        $prods = $products->separateProducts(session()->get('sessionProductsCart'));
        $items = array();
        $subtotal =session()->get('subTotalProductsCart');
        //die(var_dump($prods['all']));
        
        $ship_cost = session()->get('management');
        $taxes = session()->get('taxes');
        $currency = 'USD';
        $subtotalPaypal = 0;
        foreach ($prods['all'] as $prod) {
            $item = new Item();
            $item->setName($prod['description'])
            ->setCurrency($currency)
            ->setDescription($prod['sku'])
            ->setQuantity($prod['quantity'])
            ->setPrice($prod['price']);
            $items[] = $item;
            $subtotalPaypal += $prod['quantity'] * $prod['price'];  
        }
        $total = $subtotalPaypal + $ship_cost + $taxes;

        $item_list = new ItemList();
        $item_list->setItems($items);

        $details =  new Details();
        $details->setSubtotal($subtotalPaypal)
        ->setShipping($ship_cost)
        ->setTax($taxes);

        $amount = new Amount();
        $amount->setCurrency($currency)
        ->setTotal($total)
        ->setDetails($details);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
        ->setItemList($item_list)
        ->setDescription('Pedido de prueba en nfuerza');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(\URL::route('payment.status'))
        ->setCancelUrl(\URL::route('payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        } catch (\Paypal\Exception\PPConnectionException $ex) {
            var_dump(json_decode($ex->getData()));
            if (\Config::get('app.debug')){
                echo "Exception: " . $ex->getMessage(). PHP_EOL;
                $err_data = json_decode($ex->getData(),true);
                exit;
            } else{
               die('Ocurrio un error durante el pago');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        Session::put('paypal_payment_id',$payment->getId());
        if (isset($redirect_url)) {
            session()->put('prods',$prods['all']);
            return \Redirect::away($redirect_url);
        }
        session()->flash('message','Ocurrio un error externo.');
        return \Redirect::route('home');

    }

    public function getPaymentStatus(){

        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        $payerId = Input::get('PayerID');
        $token = Input::get('token');
        if (empty($payerId) || empty($token)) {
            session()->flash('message','No se pudo procesar el pago en paypal');
            $regOrder = new RegisterOrder();
            $bank = "Payment Rejected";
            $order_status = 5;
            $corbiz_error = null;
            $order = $regOrder->updateOrder(null,$bank,$order_status,$corbiz_error);
            return \Redirect::route('rejectedCharge');
        }
        $payment = Payment::get($payment_id,$this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        $result = $payment->execute($execution,$this->_api_context);
        if ($result->getState() == "approved") {
            $after = self::afterPaymet();
            MailController::send("user", "Confirmation payment", "confirmation_payment", array());
            if (session()->has('userId')) {
                $removeCart= new Cart();
                $removeCart->removeProductsCart(session()->get('userId'));
            }
            return \Redirect::route('successProcess');
        }
        $regOrder = new RegisterOrder();
        $bank = "Payment cancelled";
        $order_status = 6;
        $corbiz_error = "";
        $order = $regOrder->updateOrder(0,$bank,$order_status,$corbiz_error);
        session()->flash('message','La compra fue cancelada');
        return \Redirect::route('rejectedCharge');
    }

    public function afterPaymet(){
        $user = session()->has('formReg.new_user');
            if ($user) {
                $accion = "INSCRIPCION";
            }else{
                $accion = "VENTA";
            }
        $data = array(
            "metodo"=>"cierraTransaccionWeb",
            "params"=>array(
                "pais" => session()->get('formReg.country'),
                "accion" => $accion,
                "transaccion" => session()->get('corbiz_transaction'),
                "products" => []
            )
        );
        $result = UrlService::webService($data); 
        $regOrder = new RegisterOrder();
        $updateUser = new RegisterOrderShipAddress();
        $bank = "Payment Successful";
        $corbiz_orden = $result['data']['orden'];
        if ($result['exito']) {
            $corbiz_error = null;
            $order_status = 10;
            //die(var_dump($result['data']));
            session()->put("cierra_transaction",true);
            $order = $regOrder->updateOrder($corbiz_orden,$bank,$order_status,$corbiz_error);
            $order2 = $regOrder->updateUserInfo($corbiz_error);
            if(!session()->has('userId')){
                $addUser = $updateUser->addUser($result['data'],session()->get('order_id'));
                $addUser2 = $regOrder->updateUser($result['data'],session()->get('order_id'));
                session()->put("user_eo_number",$result['data']['usuario']);
                MailController::send("sponsor", "New eo", "new_eo", array("eo_number" => $result["data"]["usuario"]));
                MailController::send("user", "Welcome", "welcome", array("eo_number" => $result["data"]["usuario"], "eo_password" => $result["data"]["contrasena"], "eo_question" => $result["data"]["pregunta_secreta"]));
            }
            MailController::send("user", "Orden", "orden", array("orden" => $result["data"]["orden"]));
            //MailController::send("user", "Confirmation shipping", "confirmation_shipping", array("orden" => $result["data"]["orden"]));
            
        }else{
            $rnd = session()->get('corbiz_transaction');
            session()->put("user_eo_number",$rnd);
            session()->put("cierra_transaction",false);
            $corbiz_error = $result['data']['error'];
            $order_status = 11;
        }    
        $order = $regOrder->updateOrder($corbiz_orden,$bank,$order_status,$corbiz_error);
        $order2 = $regOrder->updateUserInfo($corbiz_error);
        //die(var_dump($result));
        if (!session()->get('userId')) {
            $create_pdf = new InscriptionController();
            $pdf = $create_pdf->pdf_generator("downloadPDF");
        }
        
        return json_encode(true);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('paypal::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('paypal::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Respon4se
     */
    public function show()
    {
        return view('paypal::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('paypal::edit');
    }

}
