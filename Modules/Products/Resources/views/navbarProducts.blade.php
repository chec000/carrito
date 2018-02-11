<div id="icon_show_sidebar">
    <nav class="navbar navbar-fixed-top navbar-light bg-faded">
      
        <button class="navbar-toggler pull-xs-right hidden-xs-down-up hidden-lg-up boton_omni4 boton_small" type="button" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="products-colorBlue"><b>{{ trans('welcome.common.filter') }}</b> <i class="fa fa-angle-down" aria-hidden="true"></i></span>
        </button>

        <div class="collapse navbar-toggleable-md" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="nav-item dropdown">
                    <div align="right">
                        <button class="btn btn small boton_icon" data-toggle="collapse" data-target="#navbar-collapse">{{ trans('welcome.common.close') }}<i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                </li>
                <li class="nav-item dropdown ">
                    <form @submit.prevent='product.method.searchProducts()'>
                           <div class="input-group p-1 products-colorBlue">
                               <input type="text" class="form-control products-borderBlue" autofocus="autofocus" id="producs-nav" placeholder="{{trans('welcome.products.search_products')}}"/>
                        <span class="input-group-addon boton_icon products-borderBlue" v-on:click="product.method.searchProducts()">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                    </form>
                 
                    <hr class="products-hrBlue">
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle products-borderWhite" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="products-colorWhite products-font14 products-uppercase">{{ trans('welcome.common.categories') }}</span></a>
                    <div class="dropdown-menu ">
                     <a class="dropdown-item" v-for = "category in product.prop.list_categories"  href="#">
                             <span class="products-colorBlu_Viol products-font13   products-type-font-regular products-uppercase"  v-on:click="product.method.getFilterByCategory(category.category_id)"> 
                      @{{category.category}}</span>
               </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle products-borderWhite" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="products-colorWhite products-font14 products-uppercase">{{ trans('welcome.common.filter') }}</span></a>
                    <div class="dropdown-menu ">
                         <a class="dropdown-item" v-for="benefit in product.prop.list_benefits"  href="#">
                             <span class="products-colorBlu_Viol products-font13  products-type-font-regular products-uppercase" v-on:click='product.method.getFilterByBenefit(benefit.benefit_id)'>
                      @{{benefit.benefit}}
                      </span></a>                    
                    </div>
                </li>
<!--                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle products-borderWhite" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="products-colorWhite products-font14">{{ trans('welcome.products.my_orders') }}</span></a></a>
                    <div class="dropdown-menu ">
                        <a class="dropdown-item" href="#"><span class="products-colorBlu_Viol products-font13  products-type-font-regular products-uppercase">{{ trans('welcome.shipp.shipped_express') }}</span></a>
                        <a class="dropdown-item" href="#"><span class="products-colorBlu_Viol products-font13  products-type-font-regular products-uppercase">{{ trans('welcome.common.orders_history') }}</span></a>
                        <a class="dropdown-item" href="#"><span class="products-colorBlu_Viol products-font13  products-type-font-regular products-uppercase">{{ trans('welcome.products.favourite_product') }}</span></a>
                    </div>
                </li>-->
                <hr class="products-hrBlue">
                <li class="nav-item dropdown ">
                    <div align="center">
                        <button id="findNavbarFltrs" class="btn btn-sm boton_omni products-font13" type="button">
                            <b>{{ trans('welcome.common.filter') }}</b>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
 </nav>
    <br>
</div>
