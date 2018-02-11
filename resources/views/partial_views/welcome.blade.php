<div class="modal fade" id="start_view" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog margenes_modal" role="document">     
        <div class="modal-content bordes_modal">
            <div class="">
                <div class="centrar_items m-top6">
                    <img id="image_product" src={{asset('img/Icono.Productos.png')}} class="img-responsive" alt="productos">
                </div>
            </div>
            <div class="modal-body">     
                <div class="centrar_items" >
                    <p class="title-size-modal font-tittle" id="titulo_inicial">{{ trans('welcome.start') }}</p>
                    <button class="boton_omni_azul" onclick="showModal('select_zip','start_view')">{{ trans('welcome.button_Next') }}</button>
                    <div>
                        <img id="image_word" src={{asset('img/Mundo.png')}} class="img-responsive center-block" alt="mundo">      	
                    </div>
                    <div>
                        <button class="boton_omni_azul" onclick="showModal('select_country','start_view')">{{ trans('welcome.button_select_country') }}</button>
                    
                            <a href="https://www.nfuerza.com">
                                    <button class="boton_omni_azul">
                                  {{ trans('welcome.botton_cancel') }}</button>  
                            </a>
                                 
                    </div>
                </div>
            </div>
            <div class="footer_modal">
                <div class="imagen_header">
                    <img src={{asset('img/Header/Nfuerza.png')}} id="image_nfuerza" class="img-responsive center-block" alt='omnilife Nfuerza' ></img>
                </div>
            </div>     	
         
        </div>
    </div>
</div>

