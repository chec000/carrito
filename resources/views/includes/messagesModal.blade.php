<div class="modal fade" id="modalGeneralMessages" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="modalHeaderMessage" class="modal-header">
                <span id="modalGeneralMessagesTitle" class="products-colorWhite products-font25">{{trans('welcome.common.title')}}</span>
                <button @click="resetChangingVariables" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times fa-2x products-colorWhite" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <p id="modalContentMessage" class="products-colorViolet products-font16">{{trans('welcome.common.message')}}</p>
            </div>
            <div class="modal-footer">
                <button @click="resetChangingVariables" type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.common.close')}}</button>
                <button v-if="zipChanging" @click="menu.method.updateLocation(sessions.all.zip.zip)" type="button" class="btn boton_omni4 boton_lg">{{trans('welcome.common.accept')}}</button>
                <button v-if="addressChanging" @click="menu.method.updateLocation(sessions.all.zip.zip)" type="button" class="btn boton_omni4 boton_lg" data-dismiss="modal">{{trans('welcome.common.accept')}}</button>
            </div>
        </div>
    </div>
</div>
