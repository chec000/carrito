    <!-- sidebar -->
<div id="businessman-sidebar" class="col-xl-2 col-lg-3 col-md-3" align="left">

    <div id="sidebar" class="p-2 products-borderBlue_Viol">

        <span class="products-colorBlue products-font14"><b>{{ trans('welcome.products.search_products') }}</b></span>
        <div class="input-group p-1 products-colorBlue">
            <input type="text" class="form-control products-borderBlue" placeholder="Buscar productos"/>
            <span class="input-group-addon boton_icon products-borderBlue">
                <i class="fa fa-search"></i>
            </span>
        </div>
        <hr class="products-hrBlue">
        <div class="form-group">
            <p class="products-colorBlue products-font14"><b>{{ trans('welcome.common.categories') }}</b></p>
            @for($i=0;$i<=5;$i++)
                    <div class="pl-3">
                        <label class="custom-control custom-radio products-colorBlu_Viol">
                            <input id="radio{{$i}}" name="radio" type="radio" class="custom-control-input">
                        <span class="custom-control-indicator fa fa-circle-o products-colorBlu_Viol"></span>
                        <span class="custom-control-description medium-din products-font13">{{"CATEGORIA ".$i}}</span>
                    </label>
                </div>
            @endfor

        </div>
        <hr class="products-hrBlue">
        <div class="form-group">
            <p class="products-colorBlue products-font14"><b>{{ trans('welcome.common.benefits') }}</b></p>
            @for($i=0;$i<=8;$i++)
                <div class="pl-3">
                    <label class="custom-control custom-radio products-colorBlu_Viol">
                        <input id="radio{{$i}}" name="radio" type="radio" class="custom-control-input">
                        <span class="custom-control-indicator fa fa-circle-o fa-md products-colorBlu_Viol"></span>
                        <span class="custom-control-description medium-din products-font13">{{"BENEFICIO ".$i}}</span>
                    </label>
                </div>
            @endfor
            
            
        </div>
        <div class="form-group" style="display: none">
            <p class="products-colorBlue products-font14"><b>{{"MIS PEDIDOS"}}</b></p>
            <div>
                <label class="custom-control custom-radio products-colorBlu_Viol">
                    <input id="radio{{$i}}" name="radio" type="radio" class="custom-control-input">
                    <span class="custom-control-indicator fa fa-circle-o fa-md products-colorBlu_Viol"></span>
                    <span class="custom-control-description medium-din products-font13">{{"PEDIDO EXPRESS"}}</span>
                </label>
            </div>
            <div>
                <label class="custom-control custom-radio products-colorBlu_Viol">
                    <input id="radio{{$i}}" name="radio" type="radio" class="custom-control-input">
                    <span class="custom-control-indicator fa fa-circle-o fa-md products-colorBlu_Viol"></span>
                    <span class="custom-control-description medium-din products-font13">{{"HISTORIAL DE PRODUCTOS"}}</span>
                </label>
            </div>
            <div>
                <label class="custom-control custom-radio products-colorBlu_Viol">
                    <input id="radio{{$i}}" name="radio" type="radio" class="custom-control-input">
                    <span class="custom-control-indicator fa fa-circle-o fa-md products-colorBlu_Viol"></span>
                    <span class="custom-control-description medium-din products-font13">{{"PRODUCTOS"}}</span>
                </label>
            </div>
        </div>
    </div>
</div>