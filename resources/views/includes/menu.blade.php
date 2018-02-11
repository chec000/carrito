@include('partial_views.login_modal')
<header id="nav1" class="fixed-top">
    <div class="top">
        <div class="row">
            <div class="col-md-5 hidden-sm-down">
                <p class="top-info contacto list-inline">1 (888) 326 1188</p>
            </div>
            <div class="col-md-7">
                <ul class="top-info list-inline float-md-right">
                    <li class="list-inline-item"><a href="javascript:void(0)" onclick="openNav()"><img src="{{ asset('img/Buscador.png')}}"></a></li>
                    <div id="myNav" style="display:none" class="overlay m-top">
                            <div class="card-block">     
                                <div class="row">   
                                    <div class="col-2"></div>
                                    <div class="col-8">        
                                        <a href="javascript:void(0)" class="closebtn icon-close-products-search" onclick="closeNav()">&times;</a>
                                        <!--                <div class="container">-->
                                        <h1 class="m-top25 azult">{{ trans('welcome.menu.producto_benefit_ingredient') }}</h1>
                                        <!--                  <div class="line-down">-->
                                        <form  class="form-inline" action="{{ url('products/searchProducts') }}" method="GET" id="searchProductsForm">                   
                                            <i class="fa fa-search fa-3x icon-products-search" aria-hidden="true"></i>                                
                                            <div class="form-control">
                                                <input  type="search" id="name" name="name" class=" form-group text-left m-top25 w-75 bottom-line placeholder morado" placeholder="{{ trans('welcome.menu.general_search') }}">
                                            </div>
                                        </form>                     
                                        <!--                  </div>                 -->
                                        <div class="col-lg-6 m-top25">
                                            <h4 class="morado"><b>{{ trans('welcome.common.categories') }}</b></h4>
                                            <li class="categories" v-for = "category_list in main.list_categories">
                                                <span class="products-font13 products-type-font-regular products-uppercase">
                                                    <a style="padding-left:0px" class="custom-control custom-radio products-colorBlu_Viol" v-bind:href="main.server+category_list.category_id">@{{category_list.category}}</a>
                                                </span>

                                            </li>
                                        </div>
                                        <div class="overlay-content">
                                            <div class="col-lg-12">
                                            </div>
                                        </div>
                                        <!--                </div>-->
                                    </div>
                                    <div class="col-2"></div>


                                </div>

                            </div>
     
                    </div>
                    <li class="list-inline-item dropdown">
                        <a href="" onclick="return false;">{{ trans('welcome.menu.language') }}</a>
                        <div class="dropdown-content w-70 text-center">
                            <div class="menu-button">
                                
                                <a href="{{ route('lang.switch', 'en') }}" class="li-a">{{ trans('welcome.menu.en') }}</a>
                            </div>
                            <div class="menu-button">
                                <a href="{{ route('lang.switch', 'es') }}" class="li-a">{{ trans('welcome.menu.es') }}</a>
                            </div>    
<!--                                <li > </li>
                                <li ></li>                   -->
                        </div>
                    </li>
                    <!-- <li class="list-inline-item dropdown" data-toggle="modal" data-target="#loginModal"><a href="">{{ trans('welcome.menu.select_zip') }}</a>-->
                    <li class="list-inline-item dropdown"><a href="" onclick="return false;">{{ trans('welcome.menu.select_zip') }}</a>
                        <div class="dropdown-content w-100">
                            <form id="zipChange" @submit.prevent="menu.method.zipChanged(sessions.all.zip.zip)">
                            <input v-model="sessions.all.zip.zip" class="form-control" type="input" name="zip" placeholder="{{ trans('welcome.menu.select_zip') }}" autocomplete="nope" autocorrect="off">
                            <p v-if="showZipError" class="generalError">{{ trans('welcome.menu.zip_error') }}</p>
                            <button @click="menu.method.zipChanged(sessions.all.zip.zip)" class="menu-button" type="submit">{{ trans('welcome.menu.confirm') }}</button>
                               
                            </form>
                        </div>
                    </li>
                    <li v-if="sessions.user.id === null" id="drop-login" class="list-inline-item dropdown"><a href="" onclick="return false;">{{ trans('welcome.menu.login') }}</a>
                        <div class="dropdown-content">
<!--                            <form @submit.prevent='login' id='form-login'>
                            <input v-model="menu.prop.user" class="form-control" type="input" name="user" placeholder="{{ trans('welcome.menu.user') }}" autocomplete="off">
                            <input v-model="menu.prop.password" class="form-control" type="password" name="password" placeholder="{{ trans('welcome.menu.password') }}">
                            <p class="error"></p>
                            <button v-on:click="menu.method.login" class="menu-button" type="button">{{ trans('welcome.menu.login') }}</button>
                                
                            </form>-->
                              <form id="target" @submit.prevent='menu.method.login' autocomplete="off">
                            <input v-model="menu.prop.user" class="userInput form-control" type="input" name="user" placeholder="{{ trans('welcome.menu.user') }}">
                             <input v-model="menu.prop.password" class="userPassword form-control" type="password" name="password" placeholder="{{ trans('welcome.menu.password') }}">
                             <p class="error"></p>
                         <input type="submit" v-on:click="menu.method.login" class="menu-button" value="{{ trans('welcome.menu.login') }}">
                              </form>
                            
<div v-if="!sessions.all.selected_kit.sku" class="affiliate-div" >
                                <a class="menu-link" :href="registerUrl">{{ trans('welcome.menu.affiliate') }}</a>                      
                            </div>
                            <div>
                                     <!--<a href="pathUrl+'/inscription/register'">{{trans('welcome.menu.affiliate')}}</a>-->
                                         <!--<a href="pathUrl+'/inscription/register'">{{trans('welcome.menu.affiliate')}}</a>-->
                                <a class="forgotPassword text-center btn" :href="pathUrl+'authentication/resetPassword'">{{ trans('login.modal.forgot_password_label') }}</a>
                            </div>
                        </div>
                    </li>´
                    <li v-else data-toggle="modal" id="drop-login" class="list-inline-item dropdown"><a href="">{{ Session::get('userName')  }}</a>
                        <div class="dropdown-content">
                            <button @click="logout" class="menu-button">{{ trans('welcome.menu.logout') }}</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-toggleable-md navbar-light">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="col-md-1 hidden-sm-down">
            <a class="navbar-brand" href="{{url('/')}}"><img src="{{ asset('img/omnilife.png')}}"></a>
        </div>
        <div class="col-md-11 collapse navbar-collapse navbar-right" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <ul>
                    <li class="dropdown drop-carrito">
                        <div class="imageContainer">
                            <p>@{{ menu.prop.quantityProductsCart }}</p>
                        </div>
                        <div class="dropdown-content carrito productsCart">
                            <a class="closeProductsCart m-top10" ref="">{{ trans('welcome.common.close') }}<i class="fa fa-times fa-2x" aria-hidden="true"></i></a>
                            <div class="col-md-12">
                                <div class="producto-carrito" v-for="(product, index) in menu.prop.productsCart">
                                    <div class="col-md-4">
                                        <img :src="path_image + product.sku +'.png'" onerror='this.src="{{asset('img/imagen_producto.png')}}"'>
                                    </div>
                                    <div class="col-md-8">
                                        <table>
                                            <tr>
                                                <td>
                                                    <div>@{{ product.name }}</div>
                                                    <div v-if="product.isPromotion">{{trans('welcome.menu.promotion_product')}}</div>
                                                </td>
                                                <td v-if="(!product.isPromotion && product.is_kit == 0) || product.isCombo"><a v-on:click="menu.method.subtractProduct(index)" class="deleteProductCart" ref=""><i class="fa fa-times-circle fa-2x" aria-hidden="true"></i></a></td>
                                            </tr>
                                            <tr>
                                                <td class="precio">
                                                    <i v-if="(!product.isPromotion && product.is_kit == 0) || product.isCombo" v-on:click="menu.method.subtractOneProductCart(index)" class="fa fa-minus-circle fa-lg" aria-hidden="true"></i>
                                                    <i v-if="(!product.isPromotion && product.is_kit == 0) || product.isCombo" v-on:click="menu.method.plusOneProductCart(index)" class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
                                                    <label>@{{ product.quantity}}</label>
                                                    <label> x $ </label>
                                                    <label>@{{ product.price}}</label>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="subtotal">
                                <table>
                                    <tr>
                                        <td>{{ trans('welcome.common.subtotal') }}</td>
                                        <td class="calculo">$@{{ currency(menu.prop.subTotalProductsCart, 2, [',', "'", '.'])}}</td>
                                    </tr>
                                </table>
                            </div>
                            <a><button v-on:click="menu.method.goCheckout" class="carrito-button">{{ trans('welcome.menu.finalized_purchase') }}</button></a>
                        </div>
                    </li>
                    <li v-for = "category_list in main.list_categories">
                        <a class="products-font13 products-type-font-regular products-uppercase"  v-bind:href="main.server+category_list.category_id">
                            @{{category_list.category}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<nav id="nav-movil" class="navbar navbar-toggleable-md navbar-light bg-faded">
    <div class="container">
        <div class="row">
            <div class="col">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation" id="menu-movil">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="col">
                <img src="{{ asset('img/omnilife.png')}}" class="img-fluid">
            </div>
            <div id="menu-movil-login" class="col">
                <i class="fa fa-user-circle-o fa-2x azult" aria-hidden="true"></i>
            </div>
            <div id="menu-movil-settings" class="col">
                <i class="fa fa-cogs fa-2x azult" aria-hidden="true"></i>
            </div>
            <div id="menu-movil-cart" class="col carrito imageContainer">
                <i class="fa fa-shopping-cart fa-2x azult" aria-hidden="true"></i>
                <p>@{{ menu.prop.quantityProductsCart }}</p>
            </div>
        </div>
    </div>
    <div class="collapse navbar-collapse" id='menu-movil-general'>
        <ul class="navbar-nav">
            <li class="nav-item buscador">
                <form action="{{ url('products/searchProducts') }}" method="GET">
                    <div class="boder-line w-100">
                        <i class="fa fa-search fa-2x" aria-hidden="true"></i>
                        <input type="search" name="name"  class="" placeholder="{{trans('welcome.common.find')}}">
                    </div>
                </form>
            </li>
            <li v-for = "category_list in main.list_categories" class="nav-item dropdown">
                <a class="nav-item nav-link" v-bind:href="main.server+category_list.category_id">@{{category_list.category}}</a>
            </li>
        </ul>
    </div>
    <div class="collapse navbar-collapse" id="box-movil-login">
        <ul class="navbar-nav">
            <div class="login-movil">
                <div class="col-md-12">
                    <form v-if="sessions.user.id === null" autocomplete="off">
                        <input v-model="menu.prop.user" class="userInput form-control" type="input" name="user" placeholder="{{ trans('welcome.menu.user') }}" >
                        <input v-model="menu.prop.password" class="userPassword form-control" type="password" name="password" placeholder="{{ trans('welcome.menu.password') }}">
                        <p class="error"></p>
                        <button v-on:click="menu.method.login" class="menu-button" type="button">{{ trans('welcome.menu.login') }}</button>
                        <div>
                            <a class="menu-link" :href="registerUrl">{{ trans('welcome.menu.affiliate') }}</a>
                        </div>
                        <a class="forgotPassword" href="/authentication/resetPassword">{{ trans('login.modal.forgot_password_label') }}</a>
                    </form>

                        <a href="">{{ Session::get('userName')  }}</a>
                        <button v-on:click="logout" class="menu-button">{{ trans('welcome.menu.logout') }}</button>
                </div>
            </div>
        </ul>
    </div>
    <div class="collapse navbar-collapse" id="box-movil-settings">
        <div class="col-md-12">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a id="idioma-movil" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ trans('welcome.menu.language') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a href="{{ route('lang.switch', 'en') }}" class="dropdown-item">{{ trans('welcome.menu.en') }}</a>
                        <a href="{{ route('lang.switch', 'es') }}" class="dropdown-item">{{ trans('welcome.menu.es') }}</a>
                    </div>
                </li>
                <li class="nav-item buscador">
                    <div class="col-md-12">
                        <input v-model="sessions.all.zip.zip" class="form-control" type="input" placeholder="{{ trans('welcome.menu.select_zip') }}">
                        <p v-if="showZipError" class="generalError">{{ trans('welcome.menu.zip_error') }}</p>
                        <button @click="menu.method.zipChanged(sessions.all.zip.zip)" class="menu-button">{{ trans('welcome.menu.select_zip') }}</button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="collapse navbar-collapse" id="box-movil-cart">
        <div class="col-md-12">
            <div class="carrito">
                <div class="col-md-12">
                    <div class="producto-carrito" v-for="(product, index) in menu.prop.productsCart">
                        <div class="col-md-4">
                            <img :src="path_image + product.sku +'.png'" onerror='this.src="{{asset('img/imagen_producto.png')}}"'>
                        </div>
                        <div class="col-md-8">
                            <table>
                                <tr>
                                    <td>
                                        <div>@{{ product.name }}</div>
                                        <div v-if="product.isPromotion">{{trans('welcome.menu.promotion_product')}}</div>
                                    </td>
                                    <td v-if="(!product.isPromotion && product.is_kit == 0) || product.isCombo"><a v-on:click="menu.method.subtractProduct(index)" class="" ref=""><i class="fa fa-times-circle fa-2x" aria-hidden="true"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="precio">
                                        <i v-if="(!product.isPromotion && product.is_kit == 0) || product.isCombo" v-on:click="menu.method.subtractOneProductCart(index)" class="fa fa-minus-circle fa-lg" aria-hidden="true"></i>
                                        <i v-if="(!product.isPromotion && product.is_kit == 0) || product.isCombo" v-on:click="menu.method.plusOneProductCart(index)" class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
                                        <label>@{{ product.quantity}}</label>
                                        <label> x $ </label>
                                        <label>@{{ product.price }}</label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="subtotal">
                    <table>
                        <tr class="subtotal-movil">
                            <td>{{ trans('welcome.common.subtotal') }}</td>
                            <td class="calculo">$@{{ currency(menu.prop.subTotalProductsCart, 2, [',', "'", '.']) }}</td>
                        </tr>
                    </table>
                </div>
                <button v-on:click="menu.method.goCheckout" class="carrito-button">{{ trans('welcome.menu.finalized_purchase') }}</button>
            </div>
        </div>
    </div>
</nav>
<modal v-if="showModal" @close="showModal=false">
    <h4 slot="header">{{trans('welcome.message_cart_login.message_detect_products')}}</h4  >
    <p>{{trans('welcome.message_cart_login.message_choose_option')}}</p>
</modal>

<script type="text/x-template" id="modal-cartProducts">
    <transition name="modal-cartProducts">
    <div class="modal-mask">
    <div class="modal-wrapper">
    <div class="modal-container">
    <div class="modal-header">
    <slot name="header">
    default header
    </slot>
    </div>
    <div class="modal-body">
    <slot name="body">
    <div class="row">
    <div class="col-md-4">
    <button class="modal-default-button" @click="$root.menu.method.mergeSessionProductsCart(1)">
    {{trans('welcome.message_cart_login.message_choose_current_cart')}}
    </button>
    </div>
    <div class="col-md-4">
    <button class="modal-default-button" @click="$root.menu.method.mergeSessionProductsCart(2)">
    {{trans('welcome.message_cart_login.message_choose_login_cart')}}
    </button>
    </div>
    <div class="col-md-4">
    <button class="modal-default-button" @click="$root.menu.method.mergeSessionProductsCart(3)">
    {{trans('welcome.message_cart_login.message_choose_combine')}}
    </button>
    </div>

    </div>                        
    </slot>
    </div>
    </div>
    </div>
    </div>
    </transition>
</script>
