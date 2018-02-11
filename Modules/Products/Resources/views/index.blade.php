@extends('layout.layout')

@section('content')
<div id="products" class="container-fluid">           

    <div class="row">
        <div class="col-md-12 breadcrumb-style m-top5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item custom-control-description products-font13 products-type-font-regular products-uppercase">
                    <a class="products-colorBlu_Viol" v-bind:href='urlGeneral'>{{trans('support.home')}}</a></li>
                <li class="breadcrumb-item custom-control-description products-font13 products-type-font-regular products-uppercase">
                    <a class="products-colorBlu_Viol"  v-bind:href="linksUrl">
                        @{{urlSelected}}
                    </a>
<!--                        <span v-on:click=getTipeFilter(methodFilter,idTipoFilter)">    @{{urlSelected}}</span>                        -->

                </li>
                                   <!--<span class="products-colorBlu_Viol"  v-on:click="methodFilter">@{{methodFilter}}</></li>-->                
                <li class="breadcrumb-item active custom-control-description products-font13 products-type-font-regular products-uppercase ">
                    <span class="products-colorBlu_Viol ">
                        @{{product.prop.product.detail_product.product_selected}}
                    </span>
                </li>  
            </ol>     
        </div>
        <div class="col-md-12 breadcrumb-product">                
            <span class="product-selectedFilter products-font32 products-colorViolet products-type-font-bold fontBold">
                @{{urlSelected}}
            </span>
        </div>
    </div>
    <div class="row">
        <!-- Sidebar Holder -->
        @include('products::sidebar')
        <!-- Page Content Holder -->
        @include('products::products')
        <!-- Products detail -->
        @include('products::detailProducts')

    </div>
</div>
<div class="loader">
    <div class="content">
        <img style="vertical-align:middle;width: 255px;"   src={{asset('img/loadingNfuerza.gif')}} id="image_nfuerza" class="img-responsive center-block" alt='omnilife Nfuerza' />
            
    </div>


    </div>
@stop
