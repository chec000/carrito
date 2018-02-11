@extends('layout.layout')

@section('content')
    <div id="paymentFailed-content" class="container">
        <div class="row" align="center"  v-if="!sessions.user.id">
            <div id="nav-reg" class="col-12 text-center">
                <div class="boxItem">
                    <i class="fa fa-user fa-2x azult" aria-hidden="true"></i>
                    <p>{{trans('welcome.register.personal_info')}}</p>
                </div>
                <div class="boxItem">
                    <i class="fa fa-shopping-bag fa-2x azult" aria-hidden="true"></i>
                    <p>{{trans('welcome.register.select_kit')}}</p>
                </div>
                <div class="boxItem">
                    <i class="fa fa-money fa-2x azult" aria-hidden="true"></i>
                    <p>{{trans('welcome.shipp.payment_method')}}</p>
                </div>
                <div class="boxItem">
                    <i class="fa fa-check-circle fa-2x azult" aria-hidden="true"></i>
                    <p>{{trans('welcome.menu.confirm')}}</p>
                </div>
            </div>
        </div>
        <input type="hidden" id='subMenu' value="4">
        <div class="d-flex justify-content-center mt-5 row">
            <div id="paymentFailed-buttons" class="col-lg-5 col-md-5 col-sm-12 mb-4" align="center">
                <div class="m-4">
                    <p align="center"><i class="fa fa-times-circle fa-5x chckt-colorOrange" aria-hidden="true"></i></p>
                    <p class="chckt-colorOrange chckt-font25">{{trans('welcome.payment.payment_rejected')}}</p>
                </div>
                <div class="m-4">
                    <a href="checkout"><button class="btn boton_omni chckt-font14 p-3 rejecCharge-btnsOptions">
                        {{trans('welcome.payment.try_again')}}
                    </button></a>
                </div>
                <!--<div class="m-4">
                    <button class="btn boton_omni chckt-font14 p-3 rejecCharge-btnsOptions">
                        {{trans('welcome.payment.choose_different_payment')}}
                    </button>
                </div>-->
                <div class="m-4">
                    <button v-on:click="cancelOrderRejected" class="btn boton_omni chckt-font14 p-3 rejecCharge-btnsOptions">
                        {{trans('welcome.payment.cancel_order')}}
                    </button>
                </div>

                <div class="m-4">
                    <p class="chckt-colorGray" align="center">
                        {{trans('welcome.payment.detail_failed')}}
                    </p>
                </div>
            </div>
            <div class="col-lg-4" id="sidebar-checkout">
            <div class="m-top10">
                <center><h3 class="morado">{{ trans('welcome.shipp.payment_details') }}</h3></center>
            </div>
            @if(!session()->has('userId'))
                <!--<div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="text-left medium-din azult ">{{trans('welcome.register.affiliation')}}</p>
                            <p class="light-font m_top_closer">{{ trans('welcome.shipp.details') }}</p>
                        </div>
                        <div class="col-lg-6">
                            <p class="text-right medium-din azult ">$500.00</p>
                        </div>
                    </div>
                    <hr>
                </div>-->
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="text-left medium-din azult ">kit omnilife</p>
                            <p class="light-font m_top_closer">@{{sessions.new_user.selected_kit.name}}</p>

                        </div>
                        <div class="col-lg-6">
                            <p class="text-right medium-din azult ">$@{{sessions.new_user.selected_kit.price}}</p>

                        </div>
                    </div>
                    <hr>
                </div>
            @endif
            <div class="col-lg-12" id="prods-shop">
                <p class="medium-din azult ">{{ trans('welcome.shipp.online_shopping') }}</p>
                <p class="light-font  azult">{{ trans('welcome.shipp.details') }}</p>
                <div class="col-lg-12" v-for="(product, index) in menu.prop.productsCart">
                    <div v-if="product.sku != sessions.all.selected_kit.sku" class="row">
                        <div class="col-lg-3">
                            <img :src="path_image + product.sku +'.png'" onerror='this.src="{{asset('img/imagen_producto.png')}}"'>
                        </div>
                        <div class="col-lg-5" id="prod-check">
                            <label class="">@{{ product.name}}</label>
                            <br><label>@{{ product.quantity}}</label><label>x$</label><label>@{{ product.price.toLocaleString(undefined, {'maximumFractionDigits':2}) }}</label>
                        </div>
                        <div class="col-lg-4" id="price-prod">
                            <p class=" medium-din azult d-inline-block">$@{{ product.price.toLocaleString(undefined, {'maximumFractionDigits':2}) }}</p>
                            <div v-if="!product.isPromotion && product.is_kit == 0"></div>
                        </div>
                    </div><br>
                </div>
                <hr>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8">
                        <p class="text-left medium-din azult "><b>{{ trans('welcome.common.subtotal') }}</b></p>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-right medium-din azult "><b>$@{{ menu.prop.subTotalProductsCart.toLocaleString(undefined, {'maximumFractionDigits':2}) }}</b></p>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-lg-12" id="shipp_prods">
                <div class="row">
                    <div class="col-lg-8">
                        <p class="text-left medium-din azult "><b>Taxes</b></p>
                        <!-- <p class="light-font m_top_closer">Entrega de 5-7 dias habiles</p> -->
                    </div>
                    <div class="col-lg-4">
                        <p class="text-right medium-din azult "><b>+ $@{{ sessions.all.taxes }}</b></p>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-lg-12" id="shipp_prods">
                <div class="row">
                    <div class="col-lg-8">
                        <p class="text-left medium-din azult "><b>Management</b></p>
                    </div>
                    <div class="col-lg-4">
                        <p class="text-right medium-din azult "><b>+ $@{{ sessions.all.management }}</b></p>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="text-left morado "><b>{{ trans('welcome.common.total') }}</b></h1>
                    </div>
                    <div class="col-lg-4">
                        <h1 class="text-right morado "><b>$@{{ (sessions.all.subTotalProductsCart + sessions.all.management + sessions.all.taxes).toLocaleString(undefined, {'maximumFractionDigits':2}) }}</b></h1>
                    </div>
                </div>
                <hr>
            </div>
            <div class="col-lg-12">
                <div class="row col-lg-11">
                    <div class="col-lg-9">
                        <p class="text-left medium-din azult "><b>{{ trans('welcome.shipp.generated_points') }}</b></p>
                    </div>
                    <div class="col-lg-3">
                        <p class="text-right medium-din azult "><b>@{{main.sessions.all.ws_acceptedItems.points}}</b></p>
                    </div>
                </div>
            </div>
        </div>

        </div>

    </div>

@stop
