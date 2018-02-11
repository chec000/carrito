<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmsLDysXVDi2T3_HPDZhm6BhFVUfoGp4k" async defer></script>-->

        <script type="text/javascript" src="{{URL::asset('js/tether.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/estilos.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/buttonsStylesOmni.css') }}">
        <link type="text/css" href="{{ asset('css/bootstrap.min.css') }}" > </link>

        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDSOJLFKgQ2WZqB_tESnf0e7-1C9I05Cyk&callback"></script>
        <script type="text/javascript" src="{{URL::asset('js/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('js/bootstrap.min.js')}}"></script>

        <script type="text/javascript" src="{{URL::asset('js/localizacion.js')}}"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <div class="container"  >
    {{ trans('welcome.start') }}
    </div>
    <body>
     @include('partial_views.seleccion_tienda')
    @include('partial_views.seleccionar_pais')
    @include('partial_views.introducir_zip')    
    </body>
    
    
    <form method="POST" action="guardar" id="form_country_selected">
            <input type="hidden" name="country_selected" id="country_selected" value="">
        <input type="hidden" name="state_selected" id="state_selected" value="">
        <input type="hidden" id="languaje" name="languaje">
    </form>
    
</html>
