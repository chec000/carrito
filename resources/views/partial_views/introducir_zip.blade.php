<div class="modal fade" id="select_zip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog margenes_modal" role="document">
        <div class="modal-content bordes_modal">
            <div class="">
                <div class="centrar_items">
                    <img src={{asset('img/Icons-web/Icons-Proceso-Afiliacion/Localizador-2x.png')}}  class="img-responsive center-block" alt="imagen-kit">
                </div>
            </div>
            <div class="">     
                <div class="centrar_items m-top6" >
                    <p class="font-tittle">{{ trans('welcome.start') }} </p>
                    <form id=formSeleccionarZip>
                        <input type="text" class="input_selectcionar_zip" name="zipEstado"  placeholder="$introducirZip ">	       	
                    </form>

                    </div>

                </div>            
                    <div class="centrar_items margen_botones_seleccionar_zip">
                        <div class="container_bottons_zip">
                        <button class="boton_omni">{{ trans('welcome.button_continue') }}</button>
                              <button class="boton_omni_trasparente"  id="buttonCancelZip"     data-dismiss="modal">$cancelar 
                            </button>      
                            
                        </div>
                       
                    </div>

            </div>
        </div>
    </div>
</div>
