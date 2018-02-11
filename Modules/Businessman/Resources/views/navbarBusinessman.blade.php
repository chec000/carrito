    <nav id="businessman-navbar" class="navbar navbar-fixed-top navbar-light col-12" style="width:95%">

            <ul class="nav nav-tabs d-flex justify-content-around" role="tablist">
                <li class="nav-item pull-left">
                    <a class="navbar-link " data-toggle="collapse" data-target="#nb-collapse_filters">
                        <span class="bsman-colorBlue medium-din bsman-font16"><b>{{ trans('welcome.common.filter') }}</b> <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                    </a>
                </li>
                <li class="nav-item pull-right" >
                    <button class="navbar-link bsman-borderBlue_Viol bsman-noBackground " data-toggle="collapse" data-target="#nb-collapse_sortBy">
                        <span class="bsman-colorBlue light-font bsman-font16"><b>{{ trans('welcome.products.sort_by') }}</b> <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                    </button>
                </li>
            </ul>

<!--
            <div class="col-5" align="center">
                <a class="navbar-toggler pull-xs-right hidden-xs-down-up hidden-lg-up boton_omni_4 boton_small" type="button" data-toggle="collapse" data-target="#nb-collapse_filters">
                    <span class="bsman-colorBlue medium-din bsman-font16"><b>{{ trans('welcome.common.filter') }}</b> <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-7" align="center">
                <button class="navbar-toggler pull-xs-right hidden-xs-down-up hidden-lg-up boton_omni4 boton_mid" type="button" data-toggle="collapse" data-target="#nb-collapse_sortBy">
                    <span class="bsman-colorBlue light-font bsman-font14"><b>{{ trans('welcome.products.sort_by') }}</b> <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </button>
            </div>-->

        <div class="collapse navbar-toggleable-md bsman-borderBlue_Viol" id="nb-collapse_filters">
            <ul class="nav navbar-nav mb-3">
                <li class="nav-item mt-3 mb-2">
                    <div align="right">
                        <button class="btn btn small boton_icon" data-toggle="collapse" data-target="#nb-collapse_filters">{{ trans('welcome.common.close') }} <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                </li>
                <li class="nav-item ">
                    <div class="input-group p-1 bsman-colorBlue">
                        <input type="text" class="form-control bsman-borderBlue" placeholder="{{ trans('welcome.products.search_products') }}"/>
                        <span class="input-group-addon boton_icon bsman-borderBlue">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    <hr class="bsman-hrBlue">
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle bsman-borderWhite" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="bsman-colorWhite bsman-font16">{{ trans('welcome.common.categories') }}</span></a>
                    <div class="dropdown-menu ">
                        @for($i=0;$i<5; $i++)
                        <a class="dropdown-item" href="#"><span class="bsman-colorBlu_Viol bsman-font14">{{ trans('welcome.common.categories') }} {{$i}}</span></a>
                        @endfor
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle bsman-borderWhite" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="bsman-colorWhite bsman-font16">{{ trans('welcome.common.filter') }}</span></a>
                    <div class="dropdown-menu ">
                        @for($i=0;$i<5; $i++)
                            <a class="dropdown-item" href="#"><span class="bsman-colorBlu_Viol bsman-font14">{{ trans('welcome.common.benefits') }} {{$i}}</span></a>
                        @endfor
                    </div>
                </li>
                <hr class="bsman-hrBlue">
                <li class="nav-item dropdown">
                    <div align="center">
                        <button id="findNavbarFltrs" class="btn boton_small boton_omni bsman-font16 medium-din" type="button">
                            <b>{{ trans('welcome.common.filter') }}</b>
                        </button>
                    </div>
                </li>
            </ul>
        </div>

        <div class="collapse navbar-toggleable-md bsman-borderBlue_Viol" id="nb-collapse_sortBy">
            <ul class="nav navbar-nav mb-3">
                <li class="nav-item dropdown mt-3 mb-2">
                    <div align="right">
                        <button class="btn btn small boton_icon" data-toggle="collapse" data-target="#nb-collapse_sortBy">{{ trans('welcome.common.close') }} <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="dropdown-item" href="#"><span class="bsman-colorBlu_Viol bsman-font14">{{ trans('welcome.products.higher_points') }}</span></a>
                </li>
                <li class="nav-item">
                    <a class="dropdown-item" href="#"><span class="bsman-colorBlu_Viol bsman-font14">{{ trans('welcome.home.beauty_products') }}</span></a>
                </li>
                <hr class="bsman-hrBlue">
                <li class="nav-item">
                    <a class="dropdown-item" href="#"><span class="bsman-colorBlu_Viol bsman-font14">{{ trans('welcome.products.alphabetical_order') }}</span></a>
                </li>
            </ul>
        </div>

    </nav>
