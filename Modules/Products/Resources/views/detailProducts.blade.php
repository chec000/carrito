<div id="product-detail" class="container col-lg-9 col-md-12" style="display: none;">
    <div id="product-info" class="row" >
        <div class="col-lg-4 col-md-12 col-sm-12 d-flex justify-content-center products-contentVCenter">
            <div class="card mb-3" align="center" style="border:none">
                <img v-bind:src="path_image+'/'+product.prop.product.sku+'.png'"  onerror='this.src="{{asset('img/imagen_producto.png')}}"'  class="figure-img img-fluid products-sizeProductDetail product-new-size" style="background: transparent;">

                <div class="card-body cardsLeft">
                    <div class="row justify-content-start">
                        <div class="col-4">
                            <span class="products-colorBlue products-font16">{{trans('welcome.products.share')}}</span>
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-3">
                            <a role="button" @click="product.method.genericSocialShare(product.prop.product.product_id, product.prop.product.name, 'fb')"><i class="Facebook cursor-pointer m-left85"></i></a>
                        </div>
                        <div class="col-3">
                            <a role="button" @click="product.method.genericSocialShare(product.prop.product.product_id, product.prop.product.name, 'tw')"><i class="Twitter cursor-pointer"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 pr-5">
            <div class="row pl-3">
                <span class="products-font25 products-colorViolet ml-2"><b>@{{product.prop.product.name}}</b></span></td>
            </div>
            <div class="row pl-3">
               <div>
                <span class="products-font25 products-colorViolet ml-2"><b>$@{{product.prop.product.price}}</b></span>                &nbsp;&nbsp;&nbsp;
                </div>
                <span v-if='visible_points' class="products-font15 pt-3 product-color-points">{{trans('welcome.products.points')}}  :<span>@{{product.prop.product.points}}</span>  </span>
            </div>
            <div class="row">
                <div class="col-lg-9 pt-2">
                    <span class="products-font15"><b>{{trans('welcome.common.sku')}}  :<span>@{{product.prop.product.sku}}</span> </b></span>
                </div>
                <div class="col-lg-3" align="center">
                </div>
            </div>
            <div id="products-detail_btnsQuantAdd" class="row">
                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <span class="products-font12">{{trans('welcome.products.quantity')}}</span>
                    <div class="input-group p-1">
                        <input type="text" id="count-products" class="products-borderBlue products-quantitySize products-font13" v-model="product.prop.product.detail_product.counter" />
                        <span    v-on:click="addMoreProducts(0)" class="input-group-addon boton_icon products-borderBlue ">
                            <i class="fa fa-minus-square-o fa-2x" aria-hidden="true"></i>
                        </span>
                        <span  v-on:click="addMoreProducts(1)"  class="input-group-addon boton_icon products-borderBlue">
                            <i class="fa fa-plus-square-o fa-2x" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-4 col-sm-4 col-12 mb-5 pt-4 products-alingBottom d-inline-block">
                    <button   v-on:click="addProduct(product.prop.product)" type="button" class="btn products-font14 boton_omni boton_lg products-uppercase addProduct"><b>{{trans('welcome.common.add')}}</b></button>
<!--                      <p class="product" hidden>@{{ product.prop.product }}</p>-->
                </div>
                <div class="col-xl-5 col-lg-4 col-sm-4 col-12 pt-4 products-alingBottom">
                    <button type="button" class="products-font14 btn boton_omni boton_lg products-uppercase" onclick="closeDetail()"><b>{{trans('welcome.orders_finished.back_store')}}</b></button>


<!--                    <button type="button" class="btn boton_omni boton_lg">
                        <b>{{ trans('welcome.products.my_order') }}</b>
                    </button>-->
                </div>
            </div>
            <br>

            <div class="row pt-3">
                <div id="product-detailTabs" class="col-lg-12 ">
                    <ul class="nav nav-tabs nav-justified flex-column flex-xl-row products-borderBlue_Viol " role="tablist">
                        <li class="nav-item products-borderBlue">
                            <a class="nav-link active products-colorViolet" href="#idProd-detailDesc" role="tab" data-toggle="tab">
                                {{trans('welcome.products.description')}}
                            </a>
                        </li>
                        <li v-show="product.prop.product.product_category.showTableNutri" class="nav-item products-borderBlue">
                            <a class="nav-link products-colorViolet" href="#idProd-detailNutriTbl" role="tab" data-toggle="tab">
                                {{trans('welcome.products.nutritional_table')}}
                            </a>
                        </li>
<!--                        <li class="nav-item  products-borderBlue">
                            <a class="nav-link products-colorViolet" href="#idProd-detailStories" role="tab" data-toggle="tab">
                                {{trans('welcome.products.succes_stories')}}
                            </a>
                        </li>
                        <li class="nav-item  products-borderBlue">
                            <a class="nav-link products-colorViolet" href="#idProd-detailVideos" role="tab" data-toggle="tab">
                                {{trans('welcome.products.videos')}}
                            </a>
                        </li>-->
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="tab-content products-borderBlue_Viol products-hgtTabsDetail  pt-3">
                        <div role="tabpanel" class="container tab-pane fade-in active" id="idProd-detailDesc">
                            <span class="products-colorBlue products-font20"><b>{{trans('welcome.products.ingredients_benefit')}}</b></span>

                            <p  class="products-font14 medium-din" v-for="b in product.prop.product.detail_product.benefits">
                              @{{b.bennefit}}
                                <!--@{{product.prop.product.description}}-->
                            </p>
                            <hr class="products-hrBlue">
                            <span class="products-colorBlue products-font20"><b>{{trans('welcome.products.consumption_proposal')}}</b></span>
                            <p class="products-font14 medium-din" >
                                @{{product.prop.product.consupsion_tips}}
                        </div>
                        <div role="tabpanel" class="container tab-pane fade" id="idProd-detailNutriTbl">
                            <img class="products-sizeWidth100 p-4" v-bind:src="path_image+'nutritional/'+product.prop.product.nutritional_table+'.png'" onerror='this.src="{{asset('img/imagen_producto.png')}}"'>
                        </div>
                        <div role="tabpanel" class="container tab-pane fade" id="idProd-detailStories">
                            <div class="row" v-for="testimonies in product.prop.product.detail_product.testimonies">
                                <div class="col-lg-2">
                                    <span style="background: #BFDFE9; font-size:40px" class="products-colorWhite products-uppercase">
                                        <b>@{{testimonies.name.substring(0,1)+testimonies.last_name.substring(0,1)}}  </b></span>
                                </div>
                                <div class="col-lg-10">
                                    <span class="products-colorBlue products-font20"><b>@{{testimonies.name}}</b></span>
                                    &nbsp;&nbsp;
                                    <span class="products-font12 medium-din">@{{testimonies.country}}</span>
                                    <p class="products-font14 medium-din">@{{testimonies.testimony}}</p>
                                </div>
                                <hr class="products-hrBlue">
                            </div>
                        </div>

                        <div role="tabpanel" class="container tab-pane fade" id="idProd-detailVideos">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" v-bind:src="product.prop.product.video_url"  allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <br>
                    <span v-if="product.prop.product.detail_product.labels.length>0" class="products-colorViolet products-font15"><b>{{trans('welcome.products.tags')}}:</b></span> &nbsp;&nbsp;
                    <span   class="btn boton_omni4 boton_small products-font13" v-for ="labels in product.prop.product.detail_product.labels">
                        @{{labels.name}}
                    </span>
                </div>
            </div>
        </div>
        <div class="container products-bgBlueLight products-sizeDivCombo" v-if="product.prop.product.detail_product.visible_combo">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                     <div style="margin-top: 21px;"  v-for="package in product.prop.product.detail_product.package"
                            v-bind:id="'package-'+package.number_package"   v-bind:class="{ active: package.number_package==1}" class="carousel-item" >
                        <div class="row"  >
                            <div class="col-md-6">
                                <figure class="figure">
                                <img v-bind:src="path_image+package.image+'.png'"  onerror='this.src="{{asset('img/imagen_producto.png')}}"' class="card-img-top image-combo"
                                     alt="Card image cap">
                                <figcaption class="figure-caption">
                                    <div class="">
                                        <p class="prod-price products-font25"><b>$@{{package.price}}</b></p>
                                        <p class="prod-points products-font20" v-if='visible_points'>
                                            <b>{{trans('welcome.products.points')}}:@{{package.points}}</b></p>
                                    </div>
                                </figcaption>
                                </figure>
                            </div>
                            <div class="col-md-6">
                                <div class="card-block">
                                    <span class="card-title medium-din products-font25 products-uppercase" style="font-weight: bold;">@{{package.name}}</span>
                                    <br>
                                    <div class="product-scroll_v">
                                        <span class="products-font13 products-uppercase"  style="font-weight: bold;">{{trans('welcome.products.description')}}: </span>
                                        s<span class="products-font13">
                                            @{{package.description}}
                                        </span>
                                        <br>
                                        <span class="medium-din products-font15 products-uppercase"  style="font-weight: bold;">{{trans('welcome.products.contains')}}: </span>

                                        <ul>
                                        <li   class="radio" v-for="products in package.products">
                                            <p  class="products-font13">
                                                <strong>@{{products.quantity}}</strong>  <span>@{{products.product}}</span>
                                                 </p>
                                            </li>

                                        </ul>

                                    </div>
                                    <div>
                                      <button type="button" v-on:click="addProduct(package)"  class="products-font14btn boton_omni boton_lg addProduct top_closer products-uppercase"><b>{{trans('welcome.common.add')}}</b></button>
<!--                                       <p class="product" hidden>@{{ package }}</p>    -->
                                    </div>
                                </div>
                             </div>
                         </div>
                        <br>
                     </div>
                </div>
            </div>
            <a   v-if="product.prop.product.detail_product.package.length>1"class="carousel-control-prev"  style="width: 0%; "  href="#carouselExampleControls" role="button" data-slide="prev">
                <span  aria-hidden="true"   class="fa fa-angle-left products-carrusel-arrow" aria-hidden="true">
                </span>
                <span   class="sr-only products-carrusel-arrow-previous">{{trans('welcome.common.previous')}}</span>
            </a>
            <a class="carousel-control-next" v-if="product.prop.product.detail_product.package.length>1"  style="width: 0%; " href="#carouselExampleControls" role="button" data-slide="next">
                <span  aria-hidden="true" class="products-carrusel-arrow">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
                <span class="sr-only products-carrusel-arrow-previous">{{trans('welcome.common.next')}}</span>
            </a>
        </div>
        <div class="product-icon-share" id="btn-close-detail">
            <a  v-if="product.prop.product.redirect_home" role="button" :href="productsUrl"><i class="fa fa-times-circle fa-2x boton_iconNoBackround" aria-hidden="true"></i></a>
            <a  v-if="!product.prop.product.redirect_home" class="products-clsDetail" role="button"><i class="fa fa-times-circle fa-2x boton_iconNoBackround" aria-hidden="true"></i></a>
        </div>
    </div>

<!--    <section class="products" v-if="is_visible">

        <h2 class="products-title morado"  ><B>{{ trans('welcome.products.complementary_products') }}</B></h2>
        <div id="detailcarousel" class="products-slider slide_detailProduct">
            <div class="prod-item slick-slide slick-current main-category" v-for="product_related in product.prop.product.detail_product.products_related">
                <figure class="figure">
        <div class="col-md-10">
                    <div class="products-container">
                        <div class="text-center">
                               <a class='cursor-pointer'  v-on:click ="product.method.getDetailProduct(product_related.product_id)">
                         <img v-bind:src="path_image+'/'+product_related.sku+'.png'" class="slide-img rounded " onerror='this.src="{{asset('img/imagen_producto.png')}}"'></a>
                        </div>
                   
 
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10 text-center">
                                 <div class="products-font15 products-colorGray products-type-font-regular text-center">
                                    <span>@{{product_related.sku}}</span>
                                </div>
                                <div class="products-font15 products-colorGray products-type-font-regular">
                                    <span>@{{product_related.name.substring(0,20)+'..'}}</span>
                                </div>
                                <div>
                                     <span class="products-font15 products-colorGray products-type-font-regular">@{{product_related.description.substring(0,5)+".."}}.
                                        <a class='cursor-pointer underline'  v-on:click ="product.method.getDetailProduct(product_related.product_id)">
                                        {{trans('welcome.common.read_more')}}</a></span>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div class="prod-values">
                                        <p class="products-font25 products-colorViolet "><b>$@{{product_related.price}}</b></p>
                                        <p v-if='visible_points' class="prod-points"><b>PTS:@{{product_related.points}}</b></p>
                                    </div>
                                    <button type="button" name="addToCart" class="btn boton_omni products-font16 boton_lg product-carrusel-items-button addProduct"><b><h4>{{ trans('welcome.home.add_cart') }}</h4></b></button>
                 <p class="product" hidden>@{{ product_related }}</p>
                                                <button type="button" name="addToCart" class="fondo-morado letra-blanca btn btn-secondary w-100 height30  addProduct"><b><h4>{{ trans('welcome.home.add_cart') }}</h4></b></button>
                                <p class="product" hidden>@{{ product_related }}</p>
                                    <button  v-on:click="addProduct(product_related)"  type="button" name="addToCart" class="fondo-morado letra-blanca btn btn-secondary w-100 height30 "><b><h4>{{ trans('welcome.home.add_cart') }}</h4></b></button>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>
               </div>
        </div>
                </figure>
            </div>
        </div>
    </section>-->
    
    
    <section class="products" v-if="is_visible">
  <h2 class="products-title morado"><b>{{ trans('welcome.products.complementary_products') }}</b></h2>
  <div  id="detailcarousel" class="products-slider slide_detailProduct">
    <div v-for="product_related in product.prop.product.detail_product.products_related" class="prod-item main-category">
     <figure class="figure">
      <div class="col-md-10">
        <div class="products-container">
         <div class="text-center">
           <div class="prod-image">
              <a class='cursor-pointer'  v-on:click ="product.method.getDetailProduct(product_related.product_id)">
                         <img v-bind:src="path_image+'/'+product_related.sku+'.png'" class="slide-img rounded " onerror='this.src="{{asset('img/imagen_producto.png')}}"'></a>
                
          </div>   

          <div class="form-group m-top_closer15">
           <div class="col-md-12 text-center m-left30">
            <div class="products-font15 products-colorGray products-type-font-regular text-center">
              <span>@{{product_related.sku}}</span>
            </div>
            <div class="products-font15 products-colorGray products-type-font-regular">
                <span>@{{ product_related.name.substring(0,18) }} <span  v-if='product_related.name.length<18' >..</span> </span>             
            </div>
            <div>
              <span class="products-font15 products-colorGray products-type-font-regular">
               @{{ product_related.description.substring(0,10)}}..                               
               <a class='cursor-pointer underline products-uppercase'  v-on:click ="product.method.getDetailProduct(product_related.product_id)">
                  {{trans('welcome.common.read_more')}}</a></span>                                   
             </div> 
           </div>    
         </div>
       </div>
       <div class="col-md-12 m-left30">    
        <div class="prod-values product-carrusel-items">
          <p class="prod-price product-price"><b>$@{{ product_related.price }}</b></p>
             <p v-if='visible_points' class="prod-points"><b>{{trans('welcome.products.points')}}:  @{{product_related.points}}</b></p>
          <div align="center">
             <button  v-on:click="addProduct(product_related)"  type="button" name="addToCart" class="products-font14 fondo-morado letra-blanca btn btn-secondary w-100 height30  products-uppercase"><b><h4>{{ trans('welcome.home.add_cart') }}</h4></b></button>
          </div>
          <div>
          </div>

        </div>     
      </div>
    </div>    
  </div>
  <div class="col-md-1"></div>
  
</figure>
</div>
</div>
</section>

</div>
    
   
    
    
  
