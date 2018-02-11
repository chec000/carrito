<div id="products-content" class="container col-xl-9 col-lg-9 col-md-12">
    @include("products::navbarProducts")

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div id="icons_reorder" align="">
                <button id="btn_order_tbl" type="button" class="boton_icon boton_mid">
                    <i class="fa fa-th fa-2x" ></i>
                </button>
                &nbsp;
                <button id="btn_order_lst" type="button" class="boton_icon boton_mid">
                    <i class="fa fa-th-list fa-2x"></i>
                </button>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12" align="right">

            <div class="btn-group">
                <button class="btn btn-secondary btn-sm dropdown-toggle boton_icon products-font15" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{trans('welcome.products.sort_by')}}
                </button>
                <div class="dropdown-menu products-borderBlue">
                    <a v-on:click ="product.method.order(2)"  class="dropdown-item boton_icon products-font15 products-type-font-regular " href="#">{{trans('welcome.products.higher_points')}}</a>
                    <a v-on:click ="product.method.order(1)"class="dropdown-item boton_icon products-font15 products-type-font-regular" href="#">{{trans('welcome.home.beauty_products')}}</a>
                    <div class="dropdown-divider products-colorBlue"></div>
                    <a v-on:click ="product.method.order(3)" class="dropdown-item boton_icon products-font15 products-type-font-regular" href="#">A-Z</a>
                    <a v-on:click ="product.method.order(4)" class="dropdown-item boton_icon products-font15 products-type-font-regular" href="#">Z-A</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12" >
            <div>
                <span class="products-colorBlue products-font15 products-pagination-arrow">@{{product.prop.pagination_products.current_page}} - @{{product.prop.pagination_products.last_page}}</span>
                <a href="#"  v-if="product.prop.pagination_products.prev_page_url"  v-on:click="product.method.getFilter(product.prop.pagination_products.prev_page_url)"><i class="fa fa-angle-left products-arrow-left color_gray fa_border_blue  boton_icon"></i></a>
                <a href="#" v-if="product.prop.pagination_products.next_page_url"  v-on:click="product.method.getFilter(product.prop.pagination_products.next_page_url)"><i class="fa fa-angle-right color_gray fa_border_blue  boton_icon"></i></a>
            </div>
        </div>
    </div>

    <div id="tbl_products" class="row col-md-12" align="left">

        <div class="col-lg-4 col-md-6 col-xs-12 pt-3"  v-for = "productList in product.prop.list_products.data" align="center" style="position: relative; margin-top: 50px" >
            <figure class="figure" >
                <div class="products-container">
                    <div class="container product-icon-share">
                        <div class="row justify-content-end">
                            <div class="col-2 col-md-3 top_closer">
                                <a role="button" @click="product.method.genericSocialShare(productList.product_id, productList.name, 'fb')"><i class="Facebook cursor-pointer"></i></a>
                            </div>
                            <div class="col-2 col-md-5 m_left_closer8 top_closer">
                                <a role="button" @click="product.method.genericSocialShare(productList.product_id, productList.name, 'tw')"><i class="Twitter cursor-pointer"></i></a>
                            </div>
                        </div>
                    </div>
                    <a class='cursor-pointer'  v-on:click ="product.method.getDetailProduct(productList.product_id)">
                        <img :src="path_image + productList.sku +'.png'" onerror='this.src="{{asset('img/imagen_producto.png')}}"' class='figure-img img-fluid products-sizeProductTbl img-fluid' >
                    </a>                   
                    <div class="bottom-left" >
                        <figcaption class="figure-caption text-center">
                        </figcaption>
                    </div>
                    <div class="col-md-12 mleft55">
                        <div class="products-font15 products-colorGray products-type-font-regular">
                            <span>@{{productList.sku}}</span>
                        </div>
                        <a class='cursor-pointer' v-on:click ="product.method.getDetailProduct(productList.product_id)">
                            <span class="products-font15 products-colorGray products-type-font-regular" >
                                @{{productList.name.substring(0,18)}}...
                            </span>

                        </a>
                    </div>
                </div>    
                <div class="row" style="margin-top: 40px;">
                    <div class="col-lg-6">
                        <span       class="prod-price product-price products-font30 align-middle m-left">
                            <b>$@{{productList.price}}</b>
                        </span>
                    </div>
                    <div class="col-lg-6 pt-3">
                        <span  v-if='visible_points' class="prod-points product-points align-middle">{{trans('welcome.products.points')}}: @{{productList.points}}</span>
                    </div>
                </div>
                <div align="center">
                    <button type="button" v-on:click="addProduct(productList)" class="products-font14 btn boton_omni  boton_lg products-uppercase">
                        <b>{{trans("welcome.home.add_cart")}}</b></button>
                    <!--                    <button type="button" name="addToCart" class="btn boton_omni boton_lg products-font16 addProduct"><b>{{trans("welcome.home.add_cart")}}</b></button>
                                        <p class="product" hidden>@{{ productList }}</p>             -->
                </div>
            </figure>
        </div>
    </div>
    <div id="list_products" class="">
        <div class='row' align="center"  v-for = "productList in product.prop.list_products.data" align="center">
            <div class="col-md-3">
                <div class="text-center">
                    <a class='cursor-pointer'  v-on:click ="product.method.getDetailProduct(productList.product_id)">
                        <img class='figure-img img-fluid' :src="path_image + productList.sku +'.png'" onerror='this.src="{{asset('img/imagen_producto.png')}}"' >
                    </a>
                </div>               
            </div>
            <div class="col-md-6" align="left">
                <span class="products-colorViolet products-font20">{{trans("welcome.products.description_product")}}</span>
                <br>
                <a class='cursor-pointer' v-on:click ="product.method.getDetailProduct(productList.product_id)">
                    <span  class="products-font15 products-colorGray products-type-font-regular">
                        @{{productList.description.substring(0,191)+".."}}
                    </span>     
                    <div class="products-font15 products-colorGray products-type-font-regular">
                        <span>@{{productList.sku}}</span>
                    </div>
                </a>
                <br>
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-4">
                            <span class="products-colorBlue products-font16">{{trans('welcome.products.share')}}</span>
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-lg-2 col-2">
                            <a role="button" @click="product.method.genericSocialShare(productList.product_id, productList.name, 'fb')"><i class="Facebook cursor-pointer"></i></a>
                        </div>
                        <div class="col-lg-2 col-2">
                            <a role="button" @click="product.method.genericSocialShare(productList.product_id, productList.name, 'tw')"><i class="Twitter cursor-pointer"></i></a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3">
                <div class="list-price">
                    <span class="products-colorBlue  products-font22 col-sm-8"><b>$@{{productList.price}}</b></span>
                    <br>
                    <span v-if='visible_points' class="products-colorBlue  products-font15 col-sm-4"><b>{{trans('welcome.products.points')}}:@{{productList.points}}</b></span>
                </div>
                <div align="center">
                    <!--                      <button type="button" name="addToCart" class="btn boton_omni products-font16 boton_lg addProduct"><b>{{ trans("welcome.home.add_cart") }}</b></button>
                                          <p class="product" hidden>@{{ productList }}</p>-->
                    <button type="button" v-on:click="addProduct(productList)" class="products-font14 btn boton_omni boton_lg products-uppercase">
                        <b>{{trans("welcome.home.add_cart")}}</b></button>
                    <!--
                                        <button type="button" v-on:click="addProduct(productList)" class="btn boton_omni products-font16 boton_lg">
                                            <b>{{trans("welcome.home.add_cart")}}</b></button>-->
                </div>
            </div>
            <hr class="products-hrBlue">
        </div>
    </div>
    <div class="products-margin-paginacion" id="pagintacio-products">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8" align="center">

                <span class="page-item" v-if="product.prop.pagination_products.prev_page_url"  v-on:click="product.method.getFilter(product.prop.pagination_products.prev_page_url)">
                    <a class="" href="#" >
                        <span class="fa fa-chevron-circle-left fa-4x products-colorBlu_Viol products-pagination-arrow-botton"></span>
                    </a>
                </span>
                <span  v-for = "pages in product.prop.pagination_products.pagesArray" class="products-type-font-regular products-font25">
                    <a  style=" cursor: pointer" v-if="pages.from<=9"> 
                        <span v-bind:id="'page-'+pages.from"  class="products-pagination products-colorBlu_Viol "  v-on:click="product.method.getFilter(pages.current_number_page,pages.from)">                          
                            @{{pages.from}}          
                        </span>
                    </a>
                </span>
                <span  v-if="product.prop.pagination_products.next_page_url"  v-on:click="product.method.getFilter(product.prop.pagination_products.next_page_url)">
                    <a  href="#">
                        <span class="fa fa-chevron-circle-right fa-4x products-colorBlu_Viol products-pagination-arrow-botton"></span>
                    </a>
                </span>
            </div>
            <div class="col-md-2"></div>            
        </div>
    </div>
</div>