<div class="modal fade" id="modalContinuePayPal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header-info modalHeaderMessage">
                <span class="products-colorWhite products-font25 modalGeneralMessagesTitle">{{trans('welcome.common.confirmation_message')}}</span>
                <button @click="checkout.method.callPaypal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times fa-2x products-colorWhite" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <p class="products-colorViolet products-font16 modalContentMessage">{{trans('welcome.promotion.product_add_success')}}</p>
            </div>
            <div class="modal-footer">
                <button onclick="getAllSessionVariables" type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.common.close')}}</button>
            </div>
        </div>
    </div>
</div>
