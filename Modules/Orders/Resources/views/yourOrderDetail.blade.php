@extends('layout.layout')

@section('content')
    <div id="yourOrders-content" class="container-fluid">
        <div id="youOrders-tittle" class="row">
            <div class="col-12" align="center">
                <span class="chckt-colorViolet chckt-font32">
                    {{trans('welcome.orders_finished.order_detail')}}
                </span>
            </div>
        </div>
        <div id="yourOrders-purchaseShipment">
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <span class="chckt-colorBlue chckt-font16 light-font">
                        {{trans('welcome.orders_finished.businessman_name')}}
                    </span>
                    <br>
                    <span class="chckt-colorViolet chckt-font16 light-font">
                        {{$dataOrder->shippingAddress->eo_name}}
                    </span>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <span class="chckt-colorBlue chckt-font16 light-font">
                        {{trans('welcome.orders_finished.your_order_number')}}
                    </span>
                    <br>
                    <span class="chckt-colorViolet chckt-font16 light-font">
                        {{$dataOrder->order_number}}
                    </span>
                    <br>
                    <span class="chckt-colorBlue chckt-font16 light-font">
                        {{trans('welcome.shipp.selected_parcel').':'}}
                    </span>
                    <br>
                    <span class="chckt-colorViolet chckt-font16 light-font">
                        {{$dataOrder->shipping_company}}
                    </span>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <span class="chckt-colorBlue chckt-font16 light-font">
                        {{trans('welcome.orders_finished.shipp_address')}}
                    </span>
                    <br>
                    <span class="chckt-colorViolet chckt-font16 light-font">
                        {{$dataOrder->shippingAddress->address.', '.$dataOrder->shippingAddress->suburb.',  '.$dataOrder->shippingAddress->county.', '.
                        $dataOrder->shippingAddress->city.', '.$dataOrder->shippingAddress->state.', '.$dataOrder->shippingAddress->country_key.', '.
                        trans('welcome.register.zip_code').' '.$dataOrder->shippingAddress->zip_code}}
                    </span>
                </div>
            </div>
        </div>

        <div id="yourOrders-products" class="mt-5">
            <div id="yourOrders-titles" class="row col-12">
                <div id="yo-titleProduct" class="col-6">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.products.products')}}</span>
                </div>
                <div id="yo-titlePoints" class="col-2 chckt-hideMobile" align="center">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.products.quantity')}}</span>
                </div>
                <div id="yo-titlePoints" class="col-2 chckt-hideMobile" align="center">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.products.points')}}</span>
                </div>
                <div id="yo-titleTotal" class="col-2 chckt-hideMobile" align="center">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.common.total')}}</span>
                </div>
            </div>
            <hr class="chckt-hrBlue">
            @foreach($dataOrder->ordersDetail as $orderProduct)
                <div class="row ps-rowProduct">
                    <div class="yo-colImgProduct  col-lg-2 col-md-2 col-sm-4"  align="center">
                        <a role="button" class="chckt-detailProduct">
                            <!--<img src="/img/Icono.Productos.png" class="figure-img img-fluid chckt-sizeProductLst"> -->
                            <img :src="path_image +'{{$orderProduct->dataProduct->sku}}'+'.png'" onerror='this.src="{{asset('img/imagen_producto.png')}}"' class="figure-img img-fluid chckt-sizeProductLst">
                        </a>
                    </div>
                    <div class="yo-colDescProduct col-lg-4 col-md-6 col-sm-8">
                        <span class="chckt-colorBlue chckt-font20">{{"ALOE BETA LIMON SUPREME"}}</span>
                        <br>
                        <span class="chckt-font15 light-font">
                            {{"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sed aliquam risus."}}
                        </span>
                    </div>
                    <div class="yo-colPoints col-lg-2 col-md-2 col-sm-6" align="center">
                        <span class="chckt-colorBlue  chckt-font22">{{$orderProduct->quantity}}</span>
                    </div>
                    <div class="yo-colPoints col-lg-2 col-md-2 col-sm-6" align="center">
                        <span class="chckt-colorBlue  chckt-font22">{{$orderProduct->points}}</span>
                    </div>
                    <div class="yo-colStatus col-lg-2 col-md-2 col-sm-6" align="center">
                        <span class="chckt-colorBlue  chckt-font22 medium-din">${{$orderProduct->final_price}}</span>
                    </div>
                </div>
                <hr class="chckt-hrBlue">
            @endforeach
        </div>
        <div id="yourOrders-buttonsActions">
            <div class="row">
                <div class="col-lg-4 col-sm-12 mt-3">
                        <a href='../getDataOrdersByEoNumber'   class="btn boton_omni chckt-font12 p-3 yourOrders-btnsOptions">
                            <b>{{trans('welcome.button_back')}}</b>
                        </a>

                </div>
                <div class="col-lg-4 col-sm-12 mt-3">
                    <button class="btn boton_omni chckt-font12 p-3 yourOrders-btnsOptions">
                        <b>{{trans('welcome.orders_finished.add_favorite')}}</b>
                    </button>
                </div>
                <div class="col-lg-4 col-sm-12 mt-3">
                    <button class="btn boton_omni chckt-font12 p-3 yourOrders-btnsOptions">
                        <a v-bind:href='productsUrl' style="color:white">
                            <b>{{trans('welcome.orders_finished.back_store')}}</b>
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop