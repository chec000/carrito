@extends('layout.layout')

@section('content')
    <div id="yourOrders-content" class="container-fluid">
        <div id="youOrders-tittle" class="row">
            <div class="col-12" align="center">
                <span class="chckt-colorViolet chckt-font32">
                    {{trans('welcome.orders_finished.your_orders')}}
                </span>
                <br>
                <span class="chckt-colorOrange chckt-font32">
                    {{trans('welcome.orders_finished.successful_purchase')}}
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
                        {{"Alejandro González"}}
                    </span>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <span class="chckt-colorBlue chckt-font16 light-font">
                        {{trans('welcome.orders_finished.your_order_number')}}
                    </span>
                    <br>
                    <span class="chckt-colorViolet chckt-font16 light-font">
                        {{"1234567890"}}
                    </span>
                    <br>
                    <span class="chckt-colorBlue chckt-font16 light-font">
                        {{"Paqueteria UPS"}}
                    </span>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <span class="chckt-colorBlue chckt-font16 light-font">
                        {{trans('welcome.orders_finished.shipp_address')}}
                    </span>
                    <br>
                    <span class="chckt-colorViolet chckt-font16 light-font">
                        {{"Juan Gil Preciado 2450 J, Col. El Tigre, Zapopan, Jalisco, México, CP 45203"}}
                    </span>
                </div>
            </div>
        </div>

        <div id="yourOrders-products" class="mt-5">
            <div id="yourOrders-titles" class="row col-12">
                <div id="yo-titleProduct" class="col-8">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.products.products')}}</span>
                </div>
                <div id="yo-titlePoints" class="col-2 chckt-hideMobile">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.products.points')}}</span>
                </div>
                <div id="yo-titleTotal" class="col-2 chckt-hideMobile">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.orders_finished.status')}}</span>
                </div>
            </div>
            <hr class="chckt-hrBlue">
            @for($i=0;$i<=4;$i++)
                <div class="col-12 ps-rowProduct">
                    <div class="row">
                        <div class="yo-colImgProduct  col-lg-2 col-md-2 col-sm-4"  align="center">
                            <a role="button" class="chckt-detailProduct">
                                <!--<img src="/img/Icono.Productos.png" class="figure-img img-fluid chckt-sizeProductLst"> -->
                                <img src="http://intranet3.omnilife.com/demo/images/productos/4278604.png" class="figure-img img-fluid chckt-sizeProductLst">
                            </a>
                        </div>
                        <div class="yo-colDescProduct col-lg-6 col-md-6 col-sm-8">
                            <span class="chckt-colorBlue chckt-font20">{{"ALOE BETA LIMON SUPREME"}}</span>
                            <br>
                            <span class="chckt-font15 light-font">
                                {{"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sed aliquam risus."}}
                            </span>

                            <div>
                                <span class="chckt-font12">{{trans('welcome.products.quantity')}}</span>
                                <div class="input-group p-1">
                                    <input type="text" class="chckt-borderViol chckt-font13 chckt-quantitySize" value="1">
                                    <span class="input-group-addon boton_iconViol chckt-borderViol">
                                <i class="fa fa-minus-square-o fa-2x" aria-hidden="true"></i>
                            </span>
                                    <span class="input-group-addon boton_iconViol chckt-borderViol">
                                <i class="fa fa-plus-square-o fa-2x" aria-hidden="true"></i>
                            </span>
                                </div>
                            </div>
                        </div>
                        <div class="yo-colPoints col-lg-2 col-md-2 col-sm-6">
                            <span class="chckt-colorBlue  chckt-font22">{{"pts:0000"}}</span>
                        </div>
                        <div class="yo-colStatus col-lg-2 col-md-2 col-sm-6">
                            <span class="chckt-colorBlue  chckt-font22 medium-din">{{"EN PROCESO"}}</span>
                        </div>
                    </div>
                </div>
                <hr class="chckt-hrBlue">
            @endfor
        </div>
        <div id="yourOrders-buttonsActions">
            <div class="row">
                <div class="col-lg-4 col-sm-12 mt-3">
                    <button class="btn boton_omni chckt-font12 p-3 yourOrders-btnsOptions">
                        <a v-bind:href='productsUrl'  style="color:white">
                                                    <b>{{trans('welcome.orders_finished.add_products')}}</b>
                        </a>
                    </button>
                    
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