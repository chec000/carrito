@extends('layout.layout')
@section('content')
<div id="chckt-successContent" class="container-fluid">
    <div id="chckt-messageWelcome" class="col-12 ">
        <p class="chckt-colorBlue chckt-font22" align="center">
        {{trans('welcome.payment.welcome_nfuerza')}}
        </p>
        <p align="center"><i class="fa fa-check-circle fa-5x chckt-colorGreen" aria-hidden="true"></i></p>

        <p class="chckt-colorViolet chckt-font25" align="center">
            {{trans('welcome.payment.payment_successful')}}
        </p>
    </div>

    <div id="chckt-messagePaymentProcess" class="col-12">
        <p class="chckt-colorBlue chckt-font22" align="center">
            {{trans('welcome.payment.pay_proccess_perfil_generated')}}
        </p>

    </div>

    <div id="chckt-messageCongrat" class="col-12">
        <p class="chckt-colorBlue chckt-font22" align="center">
            {{trans('welcome.payment.congrats')}} {{Session::get('formReg')['name']}}{{"!"}}
        </p>
        @if(!session()->get('userId'))
            <p class="chckt-colorBlue chckt-font22" align="center">
                {{trans('welcome.payment.successful_businessman')}}{{"!"}}
            </p>
         @endif
    </div>
    @if(!session()->get('userId') && session()->get('cierra_transaction'))
        <div id="chckt-businesmanNumber" class="col-12 mt-5 mb-5">
            <p class="chckt-colorViolet chckt-font15" align="center">
                {{trans('welcome.payment.businessman_number')}}@{{main.sessions.all.user_eo_number}}
            </p>
        </div>
        <div id="chckt-pdfContractDownload" class="col-12" align="center">
            <a onclick="contract()"><button class="btn boton_omni chckt-font14 p-3 font-italic">
                {{trans('welcome.payment.download_contract')}}
            </button></a>
        </div>
        @include('partial_views.pdf')
        <div id="chckt-messageIndications" class="col-12 mt-5">
            <p class="chckt-colorGray" align="center">
                {{trans('welcome.payment.detail_successful')}}
            </p>
            <p class="chckt-colorGray" align="center">
                {{trans('welcome.payment.email_detail_successful')}}
            </p>     
        </div>
    @endif
</div>
<div id="chckt-btnsRedirect" class="container-fluid">
    <div class="d-flex justify-content-around row">
        <div class="p-2 col-lg-4 col-md-4 col-sm-12"  align="center">
            <a href="https://www.omnilife.com/en/login/?ref=zona-de-empresarios" target="_blank">
                <button class="btn boton_omni4 chckt-font20 chckt-sizeBtnsRedirect">
                    {{trans('welcome.payment.your_profile')}}
                </button>
            </a>
        </div>
        <!--<div class="p-2 col-lg-4 col-md-4 col-sm-12"  align="center">
            <button class="btn boton_omni4 chckt-font20 chckt-sizeBtnsRedirect">
                <p> {{trans('welcome.payment.order_status')}}</p>
            </button>
        </div>-->
        <div class="p-2 col-lg-4 col-md-4 col-sm-12"  align="center">
            <a href="https://www.nfuerza.com/shopping" target="_blank">
            <button class="btn boton_omni4 chckt-font20 chckt-sizeBtnsRedirect">
                {{trans('welcome.payment.omnilife_store')}}
            </button>
            </a>
        </div>
    </div>
</div>

<div id="chckt-btnsMoreOmnilife" class="container-fluid">

    <div class="d-flex justify-content-around  row">
        <div class="col-lg-12 col-md-12 col-xs-12 mt-5 mb-5" align="center">
            <span class="chckt-font32 chckt-colorViolet">
                {{trans('welcome.payment.more_omnilife')}}
            </span>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 mt-3" align="center">
            <a href="https://www.nfuerza.com/ES/actualizatech.php" target="_blank">
            <button class="btn boton_omni4 chckt-font28 chckt-sizeBtnsMoreOmni">
                {{trans('welcome.orders_finished.training')}}
            </button>
            </a>
        </div>
        <!--<div class="col-lg-4 col-md-4 col-xs-12 mt-3" align="center">
            <button class="btn boton_omni4 chckt-font28 chckt-sizeBtnsMoreOmni">
                {{trans('welcome.orders_finished.e_books')}}
            </button>
        </div>-->
        <div class="col-lg-4 col-md-4 col-xs-12 mt-3" align="center">
            <a href="https://www.omnilife.com/appmovil" target="_blank">
            <button class="btn boton_omni4 chckt-font28 chckt-sizeBtnsMoreOmni">
                <p> {{trans('welcome.orders_finished.omni_business')}}</p>
            </button>
            </a>
        </div>
    </div>
</div>
@stop