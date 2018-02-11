<div class="modal" id="modalLstShippAddres" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div id="shippingAddress" class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col align-self-center">
                        <span id="titleModalLstShippAddres" class="products-colorBlue products-font25">{{trans('welcome.shipp.registered_addresses')}}</span>
                    </div>
                </div>
                <template v-if="checkout.prop.listAddress.length > 0">
                    <button v-if="checkout.prop.checkedAddress" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times fa-2x products-colorBlue" aria-hidden="true"></i></span>
                    </button>
                </template>
            </div>

            <div class="modal-body">
                <div><p v-if="checkout.prop.listAddress.length < 1 || !checkout.prop.checkedAddress" class="chckt-font15 chckt-colorOrange">{{trans('welcome.shipp.message_address_shipp_required')}}</p></div>
                <div align="right">
                    <button type="button" class="btn boton_omni boton_mid" data-toggle="modal" data-target="#modalFormDirecShipp"
                            v-if="checkout.prop.listAddress.length < 4" @click="checkout.method.newFormShippAddress()">{{trans('welcome.common.add')}}</button>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" class="products-colorViolet products-font14">{{trans('welcome.register.select')}}</th>
                        <th scope="col" class="products-colorViolet products-font14">{{trans('welcome.orders_finished.shipp_address')}}</th>
                        <th scope="col" class="products-colorViolet products-font14">{{trans('welcome.register.zip_code')}}</th>
                        <th scope="col" class="products-colorViolet products-font14">{{trans('welcome.common.see')}}/{{trans('welcome.common.modify')}}</th>
                        <th scope="col" class="products-colorViolet products-font14">{{trans('welcome.common.delete')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-if="checkout.prop.listAddress.length < 1">
                        <td colspan="5">{{trans('welcome.common.empty_result')}}</td>
                    </tr>
                    <tr v-if="checkout.prop.listAddress.length > 0" v-for="(address , index) in checkout.prop.listAddress" >
                        <td>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input position-static" type="radio" name="dirShippRadio" id="blankRadio1" v-bind:value="index"
                                           v-bind:checked="checkout.prop.existZIPSelected.folio_selected == address.folio ? 'checked' : false"
                                    @change="checkout.method.changeAddressShipp(address)">
                                </label>
                            </div>
                        </td>
                        <td>@{{ address.etiqueta }}</td>
                        <td>@{{ address.cp }}</td>
                        <td>
                            <button type="button"
                                class="btn boton_small boton_omni3" data-toggle="modal" data-target="#modalFormDirecShipp"
                                @click="checkout.method.getAddressDistMod(address, false)">{{trans('welcome.common.modify')}}</button>
                        </td>
                        <td>
                            <button type="button" class="btn boton_small boton_omni2" v-if="address.tipo === 'ALTERNA'"
                                    data-toggle="modal" data-target="#modalConfirmDeleteAddress"
                                    @click="checkout.method.getAddressDistMod(address,true)">{{trans('welcome.button_delete')}}</button>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <template v-if="checkout.prop.checkedAddress">
                    <button v-if="checkout.prop.listAddress.length > 0" type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal" @click="promotion.method.unsetPromotionsAndRecalculate()">{{trans('welcome.common.close')}}</button>
                </template>

            </div>
        </div>
    </div>
</div>

<!-- Modal delete data-->
<div class="modal" id="modalConfirmDeleteAddress" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteAddresslLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span id="titleModalConfirmSave" class="products-colorBlue products-font25">{{trans('welcome.menu.confirm')}}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times products-colorBlue" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <p class="products-colorOrange products-font16">{{trans('welcome.payment.message_modal_confirm_delete')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.botton_cancel')}}</button>
                <button type="button" class="btn boton_omni4 boton_lg" data-toggle="modal" @click="checkout.method.disableAddressShipp(checkout.prop.addresShipp.folio)">{{trans('welcome.button_delete')}}</button>
            </div>
        </div>
    </div>
</div>