@extends('layout.layout')
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/vuejs-paginator/2.0.0/vuejs-paginator.js"></script>-->

@section('content')
    <div id="products" class="container-fluid">
        <div class="row">
            <span class="product-selectedFilter products-font32 products-colorViolet">
                <b>
                @{{product.prop.type_filter}}
                </b></span>
        </div>
        <div class="row">
            <!-- Sidebar Holder -->
            @include('products::sidebar')
            <!-- Page Content Holder -->         
            <!-- Products detail -->
            @include('products::detailProducts')

        </div>


    </div>

<!--<div class="loader"></div>-->
@stop