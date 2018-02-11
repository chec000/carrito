<div id="purchaseSummary" class="container-fluid col-xl-10 col-lg-9 col-md-12">
    <div class="col-12 pb-4" align="center">
        <span class="bsman-colorViolet bsman-font35">{{ trans('welcome.orders_summary.order_summary')}}</span>
    </div>

    <div id="purchaseSummary-content">
        <div id="purchaseSummary-titles" class="row col-10">
            <div id="ps-titleProduct" class="col-8">
                <span class="bsman-colorViolet bsman-font20">{{ trans('welcome.products.products')}}</span>
            </div>
            <div id="ps-titlePoints" class="col-2 bsman-hideMobile" align="center">
                <span class="bsman-colorViolet bsman-font20">{{ trans('welcome.products.points')}}</span>
            </div>
            <div id="ps-titleTotal" class="col-2 bsman-hideMobile" align="center">
                <span class="bsman-colorViolet bsman-font20">{{ trans('welcome.common.total')}}</span>
            </div>
        </div>
        <hr class="bsman-hrBlue">
        @for($i=0;$i<=4;$i++)
        <div class="row">
            <div class="col-lg-11 col-md-11 col-sm-11 ps-rowProduct">
                <div class="row">
                    <div class="ps-colImgProduct  col-lg-2 col-md-2 col-sm-4"  align="center">
                        <a role="button" class="bsman-detailProduct">
                            <!--<img src="/img/Icono.Productos.png" class="figure-img img-fluid bsman-sizeProductLst"> -->
                            <img src="http://intranet3.omnilife.com/demo/images/productos/4278604.png" class="figure-img img-fluid bsman-sizeProductLst">
                        </a>
                    </div>
                    <div class="ps-colDescProduct col-lg-6 col-md-6 col-sm-8">
                        <span class="bsman-colorBlue bsman-font20">{{"ALOE BETA LIMON SUPREME"}}</span>
                        <br>
                        <span class="bsman-font15 light-font">
                            {{"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sed aliquam risus."}}
                        </span>

                        <div>
                            <span class="bsman-font12">{{trans('welcome.products.quantity')}}</span>
                            <div class="input-group p-1">
                                <input type="text" class="bsman-borderViol bsman-font13 bsman-quantitySize" value="1">
                                <span class="input-group-addon boton_iconViol bsman-borderViol">
                                    <i class="fa fa-minus-square-o fa-2x" aria-hidden="true"></i>
                                </span>
                                <span class="input-group-addon boton_iconViol bsman-borderViol">
                                    <i class="fa fa-plus-square-o fa-2x" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="ps-colPoints col-lg-2 col-md-2 col-sm-6">
                        <span class="bsman-colorBlue  bsman-font22">{{"pts:0000"}}</span>
                    </div>
                    <div class="ps-colTotal col-lg-2 col-md-2 col-sm-6">
                        <span class="bsman-colorBlue  bsman-font22 medium-din">{{"$320.00"}}</span>
                    </div>
                </div>
            </div>
            <div class="ps-removeProduct col-lg-1 col-md-1 col-sm-1">
                <a href="" class="bsman-clsDetail" role="button"><i class="fa fa-times-circle fa-2x boton_iconNoBackround" aria-hidden="true"></i></a>
            </div>
        </div>
        <hr class="bsman-hrBlue">
        @endfor
    </div>

    <div id="purchaseSummary-Actionbuttons" class="row">
        <div class="col-lg-6 col-sm-12 mb-3">
            <div align="center">
                <button type="button" class="btn boton_omni bsman-font14 boton_lg">
                    <b>{{trans('welcome.orders_finished.add_products')}}</b></button>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="row">
                <div class="col-6" align="right">
                    <span class="bsman-font32 bsman-colorBlue"><b>{{trans('welcome.products.points')}}: </b></span>
                </div>
                <div class="col-6" align="right">
                    <span class="bsman-font32 bsman-colorBlue"><b>1,813</b></span>
                </div>
            </div>
            <hr class="bsman-hrBlue">
            <div class="row">
                <div class="col-6" align="right">
                    <span class="bsman-font32 bsman-colorBlue"><b>{{trans('welcome.common.subtotal')}}: </b></span>
                </div>
                <div class="col-6" align="right">
                    <span class="bsman-font32 bsman-colorBlue"><b>$559.20</b></span>
                </div>
            </div>
            <hr class="bsman-hrBlue">
        </div>
        <div id="ps-btnSuccesBuy" class="col-lg-12 mt-3" align="right">
            <button type="button" class="btn boton_omni bsman-font16 boton_lg">
                <b>{{trans('welcome.menu.finalized_purchase')}}</b></button>
        </div>
    </div>
</div>