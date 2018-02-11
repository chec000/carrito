<div class="modal fade" id="select_zip" tabindex="-1" role="dialog" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog margenes_modal" role="document">
        <div class="modal-content bordes_modal">
            <div class="">
                <div class="centrar_items m-top6">
                    <img src={{asset('img/Icons-Proceso-Afiliacion/Localizador-2x.png')}}  class="img-responsive center-block" alt="imagen-kit">
                </div>
            </div>
            <div class="">     
                <div class="centrar_items" >
                    <p  class="fontBold products-font25 products-colorViolet" >{{ trans('welcome.start') }} </p>
                    <form id="formSeleccionarZip" @submit.prevent='guardarZipCode'>
                        <!--<input type="text" autofocus="autofocus"  name="zip" id="zip" >-->          
                         <input type="text" autofocus="autofocus" class="input_selectcionar_zip wh70" name="zip" id="zip"  required placeholder="{{trans('welcome.Introduce_zip')}} ">          

                    </form>
                 <p class="text-danger" id="message_error" ></p>
                    </div>
                </div>            
                    <div class="centrar_items margen_botones_seleccionar_zip">
                        <div class="container_bottons_zip">
                            <div class="row">
                                <div class="col-md-12">
                                    
                            <button class="boton_omni" id="seleccionar_zip" onclick="guardarZipCode()">{{trans('welcome.button_continue')}} 
                            </button>
                              
                                </div>
                                      <div class="col-md-12">

                                     <button class="boton_omni_trasparente"  id="button_cancel_zip"  onclick="showModal('start_view','select_zip')">{{trans('welcome.botton_cancel')}} 
                            </button>      
                                                                    
                                    </div>
                            </div>

                        </div>
                       
                    </div>

            </div>
        </div>
  <form method="POST" action="saveZipSelected" id="form_zip_selected">
      <input type="hidden" id="zip_selected" name="zip_selected" value=""></input>
  </form>
    </div>
