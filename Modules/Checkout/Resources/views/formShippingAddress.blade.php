<div class="modal"id="modalFormDirecShipp" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <form id="shippingAddressForm" class="modal-content" @submit.prevent="checkout.method.CheckValidation('modalConfirmSaveAddress','shippingAddressForm')">
            <div class="modal-header">
                <div class="row">
                    <div class="col align-self-center">
                        <span id="titleMdalFormDirecShipp" class="products-colorBlue products-font25">{{trans('welcome.common.add')}}/
                            {{trans('welcome.common.modify')}} {{trans('welcome.register.address')}}</span>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times fa-2x products-colorBlue" aria-hidden="true"></i></span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row"  >
                    <div class="col-md-4 my-3">

                        <label for="saId-description">{{trans('welcome.products.description')}}</label>
                        <input type="text" required class="form-control input-xs is-valid sa-bottomLineBlue" id="saId-description"
                               :value="checkout.prop.addresShipp.etiqueta" @change="checkout.method.setNewValueVM('description','etiqueta')"
                               data-msgvalidation="{{trans('validation.size.string_min',['attribute' => trans('welcome.products.description'), 'size' => 5])}}"
                               placeholder="{{trans('welcome.products.description')}}">
                    </div>
                    <div class="col-md-8"></div>
                    <div class="col-md-8 my-3">
                        <label for="saId-name">{{trans('welcome.register.name')}}</label>
                        <input type="text" required class="form-control is-valid sa-bottomLineBlue" id="saId-name"
                               :value="checkout.prop.addresShipp.nombre" @change="checkout.method.setNewValueVM('name','nombre')"
                               data-msgvalidation="{{trans('validation.size.string_min',['attribute' => trans('welcome.register.name'), 'size' => 5])}}"
                               placeholder="{{trans('welcome.register.name')}}">
                    </div>
                    <div class="col-md-4 my-3">
                    </div>
                    <div class="col-md-8 my-3">
                        <label for="saId-address">{{trans('welcome.register.address')}}</label>
                        <input type="text" required class="form-control is-valid sa-bottomLineBlue" id="saId-address"
                               :value="checkout.prop.addresShipp.direccion" @change="checkout.method.setNewValueVM('address','direccion')"
                               data-msgvalidation="{{trans('validation.size.string_min',['attribute' => trans('welcome.register.address'), 'size' => 5])}}"
                               placeholder="{{trans('welcome.register.address')}}">
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-md-4 my-3">
                        <label for="saId-zipCode">{{trans('welcome.register.zip_code')}}</label>
                        <input class="form-control is-valid sa-bottomLineBlue" id="saId-zipCode" type="text" pattern="(\d{5}([\-]\d{4})?)"
                               placeholder="{{trans('welcome.register.zip_code')}}" required
                               :value="checkout.prop.addresShipp.cp" @keyup="checkout.method.getStateByZipCode()" @change="checkout.method.getStateByZipCode()">
                    </div>
                    <div class="col-md-4 my-3">
                        <label for="saId-state">{{trans('welcome.register.state')}}</label>
                        <input type="text" class="form-control is-valid sa-bottomLineBlue" id="saId-state" placeholder="{{trans('welcome.register.state')}}"
                               :value="checkout.prop.addresShipp.estado" readonly>
                    </div>
                    <div class="col-md-4 my-3">
                        <label for="saId-city">{{trans('welcome.register.town')}}</label>
                        <select id="saId-city" class="custom-select form-control d-block sa-bottomLineBlue"
                                @change="checkout.method.getCountysZipCode()" required>
                            <option value="">{{trans('welcome.register.town')}}</option>
                            <option v-for="option in checkout.prop.addresShipp.listCitys" v-bind:value="option.city"
                                    :selected="option.city == checkout.prop.addresShipp.ciudad">
                                @{{ option.city }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 my-3">
                        <label for="saId-county">{{trans('welcome.register.county')}}</label>
                        <select id="saId-county" class="custom-select form-control d-block sa-bottomLineBlue"
                                @change="checkout.method.setNewValueVM('county','condado')" required>
                            <option value="">{{trans('welcome.register.county')}}</option>
                            <option v-for="option in checkout.prop.addresShipp.lstCountys" v-bind:value="option.suburb"
                                    :selected="option.suburb == checkout.prop.addresShipp.condado">
                                @{{ option.suburb }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 my-3">
                        <label for="saId-phoneNumber">{{trans('welcome.register.phone_number')}}</label>
                        <input class="form-control is-valid sa-bottomLineBlue" id="saId-phoneNumber" placeholder="{{trans('welcome.register.phone_number')}}"
                               type="tel" minlength="9" maxlength="11" required
                               :value="checkout.prop.addresShipp.telefono" @change="checkout.method.setNewValueVM('phoneNumber','telefono')">
                    </div>
                    <div class="col-md-4 my-3">
                        <label for="saId-email">{{trans('welcome.register.e_mail')}}</label>
                        <input type="email" class="form-control is-valid sa-bottomLineBlue" id="saId-email" placeholder="{{trans('welcome.register.e_mail')}}"
                               :value="checkout.prop.addresShipp.correo" @change="checkout.method.setNewValueVM('email','correo')" required>
                    </div>
                    <div class="col-md-4 my-3">
                        <label for="saId-servDelivery">{{trans('welcome.shipp.service_delivery')}}</label>
                        <select id="saId-servDelivery" class="custom-select form-control d-block my-3 sa-bottomLineBlue"
                                @change="checkout.method.setNewValueVM('servDelivery','comp_env')" required>
                            <option value="">{{trans('welcome.shipp.service_delivery')}}</option>
                            <option v-for="option in checkout.prop.addresShipp.lstShippsComp" v-bind:value="option.value"
                                    :selected="option.value == checkout.prop.addresShipp.comp_env">
                                @{{ option.text }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.botton_cancel')}}</button>
                    <button type="submit" class="btn boton_omni4 boton_lg">{{trans('welcome.button_save')}}</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal save data-->
<div class="modal" id="modalConfirmSaveAddress" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span id="titleModalConfirmSave" class="products-colorBlue products-font25">{{trans('welcome.menu.confirm')}}</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times fa-2x products-colorBlue" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <p class="products-colorViolet products-font16">{{trans('welcome.payment.message_modal_confirm_save')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.botton_cancel')}}</button>
                <button type="button" class="btn boton_omni4 boton_lg" data-toggle="modal" @click="checkout.method.getSaveAddressDist(checkout.prop.addresShipp)"
                    >{{trans('welcome.button_save')}}</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal to readonly data-->
<div class="modal" id="modalFormDirecShippReadonly" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col align-self-center">
                        <span id="titleMdalFormDirecShipp" class="products-colorBlue products-font25">{{trans('welcome.register.address')}}</span>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times fa-2x products-colorBlue" aria-hidden="true"></i></span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row"  >
                    <div class="col-md-4 my-3">

                        <label for="saId-description">{{trans('welcome.products.description')}}</label>
                        <input type="text" class="form-control input-xs sa-bottomLineBlue"
                               :value="checkout.prop.addresShipp.etiqueta" readonly
                               placeholder="{{trans('welcome.products.description')}}">
                    </div>
                    <div class="col-md-8"></div>
                    <div class="col-md-8 my-3">
                        <label for="saId-name">{{trans('welcome.register.name')}}</label>
                        <input type="text" class="form-control sa-bottomLineBlue"
                               :value="checkout.prop.addresShipp.nombre" readonly
                               placeholder="{{trans('welcome.register.name')}}">
                    </div>
                    <div class="col-md-4 my-3">
                    </div>
                    <div class="col-md-8 my-3">
                        <label for="saId-address">{{trans('welcome.register.address')}}</label>
                        <input type="text" required class="form-control sa-bottomLineBlue" placeholder="{{trans('welcome.register.address')}}"
                               :value="checkout.prop.addresShipp.direccion" readonly>
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-md-4 my-3">
                        <label for="saId-zipCode">{{trans('welcome.register.zip_code')}}</label>
                        <input class="form-control sa-bottomLineBlue" type="text"
                               placeholder="{{trans('welcome.register.zip_code')}}"
                               :value="checkout.prop.addresShipp.cp" readonly>
                    </div>
                    <div class="col-md-4 my-3">
                        <label>{{trans('welcome.register.state')}}</label>
                        <input type="text" class="form-control sa-bottomLineBlue" placeholder="{{trans('welcome.register.state')}}"
                               :value="checkout.prop.addresShipp.estado" readonly>
                    </div>
                    <div class="col-md-4 my-3">
                        <label>{{trans('welcome.register.town')}}</label>
                        <input type="text" class="form-control sa-bottomLineBlue" placeholder="{{trans('welcome.register.city')}}"
                               :value="checkout.prop.addresShipp.ciudad" readonly>
                    </div>
                    <div class="col-md-4 my-3">
                        <label>{{trans('welcome.register.county')}}</label>
                        <input type="text" class="form-control sa-bottomLineBlue" placeholder="{{trans('welcome.register.county')}}"
                               :value="checkout.prop.addresShipp.condado" readonly>
                    </div>
                    <div class="col-md-4 my-3">
                        <label for="saId-phoneNumber">{{trans('welcome.register.phone_number')}}</label>
                        <input type="tel" class="form-control sa-bottomLineBlue" placeholder="{{trans('welcome.register.phone_number')}}"
                               :value="checkout.prop.addresShipp.telefono" readonly>
                    </div>
                    <div class="col-md-4 my-3">
                        <label for="saId-email">{{trans('welcome.register.e_mail')}}</label>
                        <input type="email" class="form-control sa-bottomLineBlue" placeholder="{{trans('welcome.register.e_mail')}}"
                               :value="checkout.prop.addresShipp.correo"readonly>
                    </div>
                    <div class="col-md-4 my-3">
                        <label for="saId-servDelivery">{{trans('welcome.shipp.service_delivery')}}</label>
                        <input type="text" class="form-control sa-bottomLineBlue" placeholder="{{trans('welcome.shipp.service_delivery')}}"
                               :value="checkout.prop.addresShipp.comp_env" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.common.close')}}</button>
            </div>
        </div>
    </div>
</div>