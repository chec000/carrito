<div class="modal"id="modalPromosCheckout" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div id="shippingAddress" class="modal-content purple-border">
            <div class="modal-header">
                <div class="row">
                    <div class="col align-self-center">
                        <span id="titleModalPromos" class="products-colorBlue products-font25">{{trans('welcome.promotion.promotion')}}: @{{ checkout.prop.listProductsPromo.name }}</span>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="container ">
                    <div align="center"><label class="chckt-colorOrange chckt-font15 medium-italic">{{trans('welcome.promotion.label_promotions')}}</label></div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <span class="products-colorViolet products-font16"><b>{{trans('welcome.products.products')}}</b></span>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <span class="products-colorViolet products-font16"><b>{{trans('welcome.products.points')}}</b></span>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <span class="products-colorViolet products-font16"><b>{{trans('welcome.common.price')}}</b></span>
                        </div>
                        <div class="col-lg-2 col-sm-12">
                            <span class="products-colorViolet products-font16"><b>{{trans('welcome.common.total')}}</b></span>
                        </div>
                    </div>
                    <hr class="products-hrBlue">
                    <div class="chckt-scroll_v_modal">
                        <template v-for="(productPromo, index)  in checkout.prop.listProductsPromo.items">

                            <div class="row">
                                <div class="col-lg-6 col-sm-8">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-check" onclick="activateBoton()">
                                                <label class="form-check-label">
                                                    <input class="form-check-input position-static" type="radio" name="selectPromoRadio" id="blankRadio" required
                                                           @click="checkout.method.checkPromoProduct(false, checkout.prop.listProductsPromo.type, productPromo)">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-10">
                                            <span class="products-font15"><b>@{{ productPromo.name }}</b></span>
                                            <br>
                                            <span class="products-font15"><b v-if="productPromo.sku">{{ trans('welcome.common.sku') }}: @{{ productPromo.sku }}</b></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-xs-6">
                                    <span class="products-font15"><b>@{{ productPromo.points }}</b></span>
                                </div>
                                <div class="col-lg-2 col-xs-6">
                                    <span class="products-font15"><b>$@{{ productPromo.price.toLocaleString(undefined, {'maximumFractionDigits':2}) }}</b></span>
                                </div>
                                <div class="col-lg-2 col-xs-6">
                                    <span class="products-font15"><b>$@{{ productPromo.total.toLocaleString(undefined, {'maximumFractionDigits':2}) }}</b></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7 col-sm-12 col-sm-push-12">
                                    <div class="container-fluid" v-if="productPromo.isCombo == true" >
                                        <div class="card border-info mt-4 chckt-con_products_combo">
                                            <div class="card-header" data-toggle="collapse" :data-target="'#idCard'+index">
                                                <div class="products-colorBlu_Viol products-font13 row justify-content-between">
                                                    <div class="col-8"><b>{{trans('welcome.products.show_package_content')}}</b></div>
                                                    <div class="col-4" align="right"><i class="fa fa-angle-down fa-2x  " aria-hidden="true"></i></div>
                                                </div>
                                            </div>
                                            <div class="collapse" :id="'idCard'+index">
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item"  v-for="productCombo in productPromo.products">
                                                            <div class="col-12"><span class="products-colorViolet products-font13"><b>{{ trans('welcome.products.product') }}:</b> @{{ productCombo.name }}</span></div>
                                                            <div class="col-12"><span class="products-colorBlue products-font13"><b>{{ trans('welcome.products.quantity') }}:</b> @{{ productCombo.quantity }}</span></div>
                                                            <div class="col-12"><span class="products-colorBlue products-font13"><b>{{ trans('welcome.common.sku') }}:</b> @{{ productCombo.sku }}</span></div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-sm-12 col-sm-push-12">
                                    <div align="center">
                                        <div class="row">
                                            <div class="col pt-3">
                                                <span class="products-font15"><b>{{trans('welcome.products.quantity')}}:</b></span>
                                            </div>
                                            <div class="input-group p-1 col">
                                                <input type="number" class="products-borderBlue products-font13 products-quantitySize" v-bind:value="productPromo.quantity" readonly>
                                                <button type="button" class="sub_product input-group-addon boton_icon products-borderBlue"
                                                        @click="checkout.method.addSubProductPromo(2,productPromo)">
                                                    <i class="fa fa-minus-square-o fa-2x" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" class="add_product input-group-addon boton_icon products-borderBlue"
                                                        @click="checkout.method.addSubProductPromo(1,productPromo)">
                                                    <i class="fa fa-plus-square-o fa-2x" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                            </div>
                                            <div class="col">
                                                <span v-if="productPromo.max_quantity" class="products-font12 products-colorOrange">
                                                    <b>{{ trans('welcome.promotion.max_quantity') }}: @{{ productPromo.max_quantity }} </b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="products-hrBlue">
                        </template>
                    </div>
                </div>
            </div>


            <div class="modal-footer">
                <div class="col-4 align-content-start">
                    <button v-if="checkout.prop.listProductsPromo.required == false" type="button" class="btn boton_omni4 boton_mid"
                            @click="checkout.method.skipPromo(checkout.prop.listProductsPromo.type)">{{trans('welcome.button_skip_promotion')}}</button>
                </div>
                <div class="col-8" >
                    <button style="display: none" id="idBtnNexPromo" type="button" class="btn boton_omni boton_lg" @click="promotion.method.checkValidationRadiosPromo()">{{trans('welcome.button_continue')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal confirm buy promo -->
<div class="modal" id="modalConfirmPromoProducts" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span id="titleModalConfirmSave" class="products-colorBlue products-font25">{{trans('welcome.menu.confirm')}}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times products-colorBlue" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <p class="products-colorOrange products-font16">{{trans('welcome.payment.message_modal_confirm_promo')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.botton_cancel')}}</button>
                <button type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal" @click="checkout.method.getNextPromo()">{{trans('welcome.button_save')}}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal finish buy promo -->
<div class="modal" id="modalFinishPromo" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span id="titleModalFinishPromo" class="products-colorBlue products-font25">{{trans('welcome.menu.confirm')}}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times products-colorBlue" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <p class="products-colorOrange products-font16">{{trans('welcome.payment.message_modal_finish_promo')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.botton_cancel')}}</button>
                <button type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.common.finish')}}</button>
            </div>
        </div>
    </div>
</div>