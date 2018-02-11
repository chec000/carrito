@extends('layout.layout')

@section('content')
<div class="container m-top" id="profile-view">
    <div id="nav-reg" class="text-center" v-if="!sessions.user.id">
        <div class="boxItem">
            <i id='information' class="fa fa-user fa-4x azult" aria-hidden="true"></i>
            <p>{{trans('welcome.register.personal_info')}}</p>
        </div>
        <div class="boxItem">
            <i id='kit' class="fa fa-shopping-bag fa-4x azult" aria-hidden="true"></i>
            <p>{{trans('welcome.register.select_kit')}}</p>
        </div>
        <div class="boxItem">
            <i id='payment' class="fa fa-money fa-4x azult" aria-hidden="true"></i>
            <p>{{trans('welcome.shipp.payment_method')}}</p>
        </div>
        <div class="boxItem">
            <i id='confirmation' class="fa fa-check-circle fa-4x azult" aria-hidden="true"></i>
            <p>{{trans('welcome.register.confirmation')}}</p>
        </div>
    </div>
    <input type="hidden" id='subMenu' value="3">
    <h1 id="form-title" class="m-top25 products-title morado"><b>{{ trans('welcome.shipp.payment_method') }}</b></h1>
    <div class="row" id="payment-method">
        <div class="col-lg-7" id="shipp_method">
            <h3 class="morado">{{ trans('welcome.shipp.shipping_method') }}</h3><br>
            <h4>{{trans('welcome.shipp.current_address')}}</h4><br>
            <div class="d-inline-block">
                <div class="d-inline-block col-lg-12">
                    <template v-if="sessions.new_user.formReg.new_user">
                        <p v-if="sessions.new_user.formReg.address" id="idNameAddressShipp" class="azult">
                            <i class="fa fa-check-circle fa-2x azult"></i> @{{sessions.new_user.formReg.address +' '+ sessions.new_user.formReg.county +' '+ sessions.new_user.formReg.zip_code}}
                        </p><br>
                        <p v-else id="idNameAddressShipp" class="azult">{{trans('welcome.shipp.empty_shipp')}}</p><br>
                    </template>

                    <template v-else>
                        <p v-if="checkout.prop.addresShipp" id="idNameAddressShipp" class="azult">
                            <i class="fa fa-check-circle fa-2x azult"></i> @{{checkout.prop.addresShipp.direccion +' '+ checkout.prop.addresShipp.condado +', '+ checkout.prop.addresShipp.ciudad +', '+ checkout.prop.addresShipp.estado +', '+ checkout.prop.addresShipp.cp}}
                        </p><br>
                        <p v-else id="idNameAddressShipp" class="orange-font"><i class="fa fa-times-circle fa-2x orange-font"></i>{{trans('welcome.shipp.empty_shipp')}}</p><br>
                    </template>
                </div>
            </div><br>
            <div>
                <template v-if="!sessions.new_user.formReg.new_user">
                    <button id="modal-address" type="button" name="change" class="btn boton_omni boton_lg height30" data-toggle="modal" data-target="#modalLstShippAddres" v-on:click="checkout.method.getListAddress(false)">
                        <h4 class="medium-din m-top1">{{ trans('welcome.shipp.change_address') }}</h4>
                    </button>
                </template>
            </div><br>
            <div class="m-top10">
                <p class="medium-italic xs-font azult">{{ trans('welcome.shipp.extra_charge_shipping') }}</p>
            </div><br>
            <h4 class="azult medium-din">{{ trans('welcome.shipp.selected_parcel') }}</h4><br>
            <div class="row" id="parcel">
                <div class="col-2">
                    <div class="" align="right">
                        <i class="fa fa-truck fa-5x morado" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="col-3">
                    <div><br>
                        <h5 class="medium-din products-font13">{{ trans('welcome.shipp.selected_parcel') }}</h5>
                    </div>
                </div>
                <div class="col-7" align="left"><br>
                    @if(!session()->has('userId'))
                    <h5 class="medium-din products-font13" v-show="sessions.new_user.formReg.ship_company">@{{sessions.new_user.formReg.ship_company}}</h5>
                    @else
                        <h5 class="medium-din products-font13" v-if="!checkout.prop.addresShipp"> {{trans('welcome.common.empty_result')}}</h5>
                        <h5 class="medium-din products-font13" v-else> @{{checkout.prop.addresShipp.comp_env}}</h5>

                     @endif
                </div>
            </div>
            <hr><br>
            <div id="choose-method">
                <h3 class="azult">{{ trans('welcome.shipp.payment_method') }}</h3>
                <!--<div class="col d-inline-block">
                        <label id="select-country" class="d-inline-block medium-din">{{ trans('welcome.shipp.country_facutreation') }}</label>
                        <div class="col-lg-4 d-inline-block">
                                <select class="form-control m-bottom bottom-line line-down" name="day">
                                        <option v-for="country in fillSelectCountry.prop.countries" :value="country.country_id" >@{{country.name}}</option>
                                </select>
                        </div>
                </div>-->
                <div id="cards">
                    <!--<div class="col">
                            <input id="checkbox-3" class="checkbox-custom" name="country-check" type="checkbox">
               <label for="checkbox-3" class="checkbox-custom-label">{{ trans('welcome.shipp.country_facutreation_live') }}</label>
                    </div>-->
                    <div class="d-inline-block col-lg-12">
                        <a id="paypal_img">
                            <i class="fa fa-check-circle check-cards"></i>
                            <img id="paypal" class="card-border" src="{{asset('img/PayPal.png')}} ">
                        </a>
                        <a href="#">
                                <!--<img id="card" src="https://goo.gl/xbXQkz">-->
                        </a>
                    </div>
                </div>
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
                    <div v-if="product.sku != sessions.new_user.selected_kit.sku" class="row m_left_closer">
                        <div class="col-lg-3">
                            <img :src="path_image + product.sku +'.png'" onerror='this.src="{{asset('img/imagen_producto.png')}}"'>
                        </div>
                        <div class="col-lg-5 light-font" id="prod-check">
                            <label class="xs-font">@{{ product.name}}</label>
                            <label>@{{ product.quantity}}</label><label>x$</label><label>@{{ product.price.toLocaleString(undefined, {'maximumFractionDigits':2}) }}</label>
                        </div>
                        <div class="col-lg-4" id="price-prod">
                            <p class=" medium-din azult d-inline-block">$@{{ product.price.toLocaleString(undefined, {'maximumFractionDigits':2}) }}</p>
                            <div v-if="(!product.isPromotion && product.is_kit == 0) || product.isCombo"><i v-on:click="menu.method.subtractProduct(index)" class="fa fa-times-circle-o azult fa-2x"></i></div>
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
                        <p class="text-left medium-din azult "><b>{{ trans('welcome.shipp.taxes') }}</b></p>
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
                        <p class="text-left medium-din azult "><b>{{ trans('welcome.shipp.management') }}</b></p>
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
                        <h1 class="text-right morado "><b>$@{{ (sessions.all.subTotalProductsCart + sessions.all.management + sessions.all.taxes).toLocaleString('en', {'maximumFractionDigits':2}) }}</b></h1>
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
                          <p class="text-right medium-din azult "><b>@{{sessions.all.points}}</b></p>       
                    </div>
                </div>
            </div>
        </div>
        <template v-if="sessions.all.subTotalProductsCart != 0">
            <div id="pay" class="container col-lg-3" style="display:none">
                <button type="button"
                        v-on:click="checkout.method.callPaypal()"
                        class="height80 fondo-morado letra-blanca btn btn-secondary btn-lg btn-block m-top">
                    <b>{{ trans('welcome.shipp.do_payment') }}</b>
                </button>
            </div>
        </template>
    </div>
</div>
<img id="wait" src="{{ asset('img/load.gif')}}" alt="loading">
@include('checkout::listShippingAddress')
@include('checkout::formShippingAddress')
@include('checkout::modalPromos')
<div class="loader">
    <div class="content">
        <img style="vertical-align:middle;width: 255px;"   src={{asset('img/loadingNfuerza.gif')}} id="image_nfuerza" class="img-responsive center-block" alt='omnilife Nfuerza' />        
    </div>
</div>
@stop
