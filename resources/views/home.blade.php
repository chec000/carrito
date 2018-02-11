@extends('layout.layout')
@section('content')
<div>
     @include('partial_views.select_country')
    @include('partial_views.view_zip')
    @include('partial_views.welcome')
</div>
<div id="carouselExampleIndicators" class="carousel slide m-top-carousel" data-interval="16000" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    @php ($first = true)
    @foreach ($banner as $banner)
      @if($first)
      <div class="carousel-item active" style="background-image: url('{{asset('/img/banners/'.$banner->main_image)}}')">
      @else
      <div class="carousel-item" style="background-image: url('{{asset('/img/banners/'.$banner->main_image)}}')">
      @endif
        <div class="carousel-caption d-none d-md-block centered">
          <h3 class="titulo"></h3>
          <!--<p class="sub-titulo">{{$banner->name}}</p>-->
        </div>
      </div>
      @php ($first = false)
    @endforeach
  </div>
  <a class="carousel-control-prev btn-c" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon btn-c" aria-hidden="true"></span>
    <span class="sr-only">{{ trans('welcome.common.previous') }}</span>
  </a>
  <a class="carousel-control-next btn-c" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">{{ trans('welcome.common.next') }}</span>
  </a>
</div>
  <carousel :title="product.prop.homeProducts.titles[0]" add="{{ trans('welcome.home.add_cart') }}"   see="{{trans('welcome.common.read_more')}}" points="{{trans('welcome.products.points')}}" v-bind:products="product.prop.homeProducts.categories.newReleases"></carousel>
  <carousel :title="product.prop.homeProducts.titles[1]" add="{{ trans('welcome.home.add_cart') }}"   see="{{trans('welcome.common.read_more')}}" points="{{trans('welcome.products.points')}}"  v-bind:products="product.prop.homeProducts.categories.starProducts"></carousel>
  <carousel :title="product.prop.homeProducts.titles[2]" add="{{ trans('welcome.home.add_cart') }}" see="{{trans('welcome.common.read_more')}}" points="{{trans('welcome.products.points')}}" v-bind:products="product.prop.homeProducts.categories.seasonProducts"></carousel>
<div class="container col-lg-6">
<!--  <button type="button" >-->

      <a class="height80 fondo-morado letra-blanca btn btn-secondary btn-lg btn-block" v-bind:href='productsUrl+"/productsCategory/10"'> 
             <img src="conoce_mas_productos.png" class="rounded"><b>{{ trans('welcome.home.more_products') }}</b>
  
  
<!--  </button>        -->

</a>      
</div>
<div class="container">
<!--  <form method="POST" action="saveCountry" id="form_country_selected">
        <input type="hidden" name="country_selected" id="country_selected" value="">
        <input type="hidden" name="state_selected" id="state_selected" value="">
        <input type="hidden" id="language" name="language" value="">
    </form>
  <form method="POST" action="saveZipSelected" id="form_zip_selected">
      <input type="hidden" id="zip_selected" name="zip_selected" value=""></input>
  </form>-->
</div>
@stop
