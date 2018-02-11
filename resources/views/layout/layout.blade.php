<?php
if (Auth::check()) {
   echo "hola";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/slick2.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/buttonsStylesOmni.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesh.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.css') }}">
        <!-- CSS productos-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styleProducts.css') }}">
        <!-- CSS Empresario-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/StyleBusinessman.css') }}">
        <!-- CSS checkout-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/StylesCheckout.css') }}">
        <!-- CSS shippingAddress-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/StylesShippingAddress.css') }}">
        <link rel="icon" href="{{asset('img/omnilife.png')}}">
        <script type="text/javascript">
            if(/MSIE \d|Trident.*rv:/.test(navigator.userAgent)){
                alert("La plataforma se encuentra optimizada para un navegador mas actualizado."); 
            }                
        </script>
    </head>
    <body id="principal_body">
        @if(Session::get('message'))
            @include('partial_views.messagePaypal')
        @endif
        <div id="main">
            @include('includes.menu')
            <div>
                @yield('content')
            </div>
            @include('includes.footer')
            @include('includes.messagesModal')
            @include('includes.modalContinuePayPal')
        </div>
        <script type="text/javascript" > var APP_URL = {!! json_encode(url('/')) !!}; </script>
        <script src="{{ asset('js/app.js') }}" ></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDSOJLFKgQ2WZqB_tESnf0e7-1C9I05Cyk&callback"></script>
<!--        <script type="text/javascript" src="{{URL::asset('js/localization.js')}}"></script>-->

   <div class="loader-general" >
    <div class="content">
        <img style="vertical-align:middle;width: 255px;"   src={{asset('img/loadingNfuerza.gif')}} id="image_nfuerza" class="img-responsive center-block" alt='omnilife Nfuerza' />
            
    </div>


    </div>

    </body>
</html>
