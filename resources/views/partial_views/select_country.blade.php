<div class="modal fade" id="select_country" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog margenes_modal" role="document">
        <div class="modal-content bordes_modal">
            <div class="">
                <div class="centrar_items m-top6">
                    <img src={{asset('img/Icons-Proceso-Afiliacion/Localizador-2x.png')}} class="img-responsive center-block imagen_localizacion" alt="imagen-kit">
                    <div>
                        
                    </div>
                </div>
            </div>
            <div class="panel_flags">     
                  <div class="titulo_flags">
                      <span class="seleccion_pais">{{trans('welcome.select_country') }}</span>
                    </div>
                <div class="contenedor_flags" >
                    <div class="container-fluid margenes_contenedor_flags">
                    
                        <div class="row margenes_rows">
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/argentina.png')}} class="tamanio_flags" alt="Argentina"></a>
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"> <img src={{asset('img/Flags/bolivia.png')}} class="tamanio_flags" alt=Bolivia> 	
                                </a>

                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://br.omnilife.com/login"><img src={{asset('img/Flags/brasil.png')}} class="tamanio_flags" alt="Brasil"> 	
                                </a>
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://cl.omnilife.com/login"><img src={{asset('img/Flags/chile.png')}} class="tamanio_flags" alt="Chile">        	
                                </a>     
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/colombia.png')}} class="tamanio_flags" alt="Colombia">
                                </a>     
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/costa_rica.png')}} class="tamanio_flags" alt="Costa Rica">
                                </a>    
                            </div>
                          </div>
                           <div class="row margenes_rows">
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/nicaragua.png')}} class="tamanio_flags" alt="Nicaragua"></a> 
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/ecuador.png')}} class="tamanio_flags" alt="Ecuador
                                                ">
                                </a>     
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/el_salvador.png')}} class="tamanio_flags" alt="El Salvador
                                                ">
                                </a> 
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/espania.png')}} class="tamanio_flags" alt="España
                                                ">
                                </a> 
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/guatemala.png')}} class="tamanio_flags" alt="Guatemala
                                                ">
                                </a> 
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/italia.png')}} class="tamanio_flags" alt="Italia
                                                ">
                                </a> 
                            </div>
                          </div>
                           <div class="row margenes_rows">
                            <div class="col-md-2 margenes_flags">
                                <a href="https://mx.omnilife.com/login"><img src={{asset('img/Flags/mexico.png')}} class="tamanio_flags" alt="Mexico
                                                ">
                                </a> 
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/panama.png')}} class="tamanio_flags" alt="Panama"></a> 
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/paraguay.png')}} class="tamanio_flags" alt="Paraguay"></a> 
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/peru.png')}} class="tamanio_flags" alt="Peru"></a> 
                            </div>
                               <div class="col-md-2 margenes_flags">
                                <a href="https://www.omnilife.com/shopping/"><img src={{asset('img/Flags/dominicana.png')}} class="tamanio_flags" alt="Republica Dominicana"></a> 
                            </div>
                            <div class="col-md-2 margenes_flags">
                                <a href="https://ru.omnilife.com/login"><img src={{asset('img/Flags/russia.png')}} class="tamanio_flags" alt="Rusia"></a> 
                            </div>
                              <div class="col-md-2 margenes_flags">
                                <a href="https://uy.omnilife.com/login"><img src={{asset('img/Flags/uruguay.png')}} class="tamanio_flags" alt="Uruguay"></a> 
                            </div>
                                 <div class="col-md-2 margenes_flags">
                                <a onclick="showModal('select_zip')"><img src={{asset('img/Flags/usa.png')}} class="tamanio_flags" alt="Estados Unidos"></a> 
                            </div>
                        </div>
                    </div>

                </div>
                     <div class="centrar_items margen_botones_seleccionar_zip">
                         <div class="buttons_flasg">
                         <!--<button class="boton_omni_modal boton_omni " onclick="">{{trans('welcome.button_continue') }}</button>-->

                         <button class="boton_omni_trasparente "  id="cancel_country"  onclick="showModal('start_view','select_country')" >{{trans('welcome.botton_cancel') }}</button>
                         </div>          
                    </div>  
            </div>
        </div>
    </div>
          <form method="POST" action="saveCountry" id="form_country_selected">
        <input type="hidden" name="country_selected" id="country_selected" value="">
        <input type="hidden" name="state_selected" id="state_selected" value="">
        <input type="hidden" id="language" name="language" value="">
    </form>
</div>