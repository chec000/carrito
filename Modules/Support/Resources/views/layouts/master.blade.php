<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/theme-default.css') }}"/>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    @section('css')

    @show
    <!--Archivo permisos en menu-->
    <title>Module Support</title>
</head>
<body>


    <div class="page-container">
        <!-- START PAGE SIDEBAR -->
        <div class="page-sidebar">
            <!-- START X-NAVIGATION -->
            <ul class="x-navigation">
                <li class="xn-logo">
                    <a href="index.html"><img src="{{ Module::asset('support:img/omnilogo-esp.svg') }}" class="logo-img" /></a>
                    <a href="#" class="x-navigation-control"></a>
                </li>
                <li class="xn-profile">

                    <div class="profile">
                        
                        <div class="profile-data">
                            <div class="profile-data-name">{{ Auth::user()->name }}</div>
                            <div class="profile-data-title">{{ Auth::user()->roles()->first()->description  }}</div>
                        </div>
                        <!-- div class="profile-controls">
                            <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                            <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                        </div -->
                    </div>
                </li>
                <li class="xn-title">{{trans('support.shopping_support')}}</li>
                <li class="active">
                    <a href="{{asset('/support')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
                </li>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">{{trans('support.menu_catalogs')}}</span></a>
                    <ul>
                        @if(Auth::user()->hasPermission(array("almacen.index")))
                            <li><a href="{{asset('/support/warehouses')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_warehouses')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("banks.index")))
                            <!-- li><a href="{{asset('/support/banks')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_banks')}}</a></li -->
                        @endif
                        @if(Auth::user()->hasPermission(array("banners.index")))
                            <li><a href="{{asset('/support/banner')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_banners')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("blacklists.index")))
                            <li><a href="{{asset('/support/blacklists')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_block_users')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("countries.index")))
                            <li><a href="{{asset('/support/countries')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_countries')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("pools.index")))
                            <li><a href="{{asset('/support/pools')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.pool_eo')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("states.index")))
                            <li><a href="{{asset('/support/states')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_states')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("questions.index")))
                            <li><a href="{{asset('/support/securityquestions')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_security_questions')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("testimony.index")))
                            <li><a href="{{asset('/support/testimony')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_testimonials')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("languages.index")))
                                <li><a href="{{asset('/support/languages')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_languages')}}</a></li>
                         @endif
                        <li class="xn-openable">
                            <a href="#"><span class="fa fa-arrow-circle-right"></span>{{trans('support.menu_products')}}</a>
                            <ul>


                                @if(Auth::user()->hasPermission(array("benefits.index")))
                                    <li><a href="{{asset('/support/product-benefit')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_products_benefits')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermission(array("categories.index")))
                                    <li><a href="{{asset('/support/categories')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_products_categories')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermission(array("ingredients.index")))
                                    <li><a href="{{asset('/support/ingredients')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_products_ingredients')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermission(array("labels.index")))
                                    <li><a href="{{asset('/support/labels')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_products_labels')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermission(array("packages.index")))
                                    <li><a href="{{asset('/support/packages')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_products_packages')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermission(array("restrictions.index")))
                                    <li><a href="{{asset('/support/restrictions')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_products_restrictions')}}</a></li>
                                @endif
                                @if(Auth::user()->hasPermission(array("products.index")))
                                    <li><a href="{{asset('/support/products')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_products')}}</a></li>
                                @endif


                            </ul>
                        </li>


                    </ul>
                </li>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-bullseye"></span> <span class="xn-text">{{trans('support.admin')}}</span></a>
                    <ul>
                        @if(Auth::user()->hasPermission(array("permissions.index")))
                            <li><a href="{{asset('/support/permissions')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_permissions')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("roles.index")))
                            <li><a href="{{asset('/support/roles')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_roles')}}</a></li>
                        @endif
                        @if(Auth::user()->hasPermission(array("users.index")))
                            <li><a href="{{asset('/support/users')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_users')}}</a></li>
                        @endif

                    </ul>
                </li>
                <li class="xn-openable">
                    <a href="#"><span class="fa fa-shopping-cart"></span> <span class="xn-text">{{trans('support.menu_orders')}}</span></a>
                    <ul>
                        @if(Auth::user()->hasPermission(array("orders.index")))
                            <li><a href="{{asset('/support/orders')}}"><span class="fa fa-arrow-circle-right"></span> {{trans('support.menu_orders')}}</a></li>
                        @endif



                    </ul>
                </li>
                <li class="">
                    <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">{{trans('support.menu_reports')}}</span></a>
                </li>
            </ul>
            <!-- END X-NAVIGATION -->
        </div>
        <!-- END PAGE SIDEBAR -->

        <div class="page-content">

            <!-- START X-NAVIGATION VERTICAL -->
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                <!-- TOGGLE NAVIGATION -->
                <li class="xn-icon-button">
                    <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                </li>
                <!-- END TOGGLE NAVIGATION -->
                <!-- SEARCH -->
                <!-- li class="xn-search">
                    <form role="form">
                        <input type="text" name="search" placeholder="Search..."/>
                    </form>
                </li -->
                <!-- END SEARCH -->
                <!-- SIGN OUT -->
                <li class="xn-icon-button pull-right">
                    <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
                </li>
                <!-- END SIGN OUT -->
                <!-- MESSAGES -->
            <!-- li class="xn-icon-button pull-right">
                            <a href="#"><span class="fa fa-comments"></span></a>
                            <div class="informer informer-danger">4</div>
                            <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span class="fa fa-comments"></span> Messages</h3>
                                    <div class="pull-right">
                                        <span class="label label-danger">4 new</span>
                                    </div>
                                </div>
                                <div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
                                    <a href="#" class="list-group-item">
                                        <div class="list-group-status status-online"></div>
                                        <img src="{{ Module::asset('support:img/users/user2.jpg') }}" class="pull-left" alt="John Doe"/>
                                        <span class="contacts-title">John Doe</span>
                                        <p>Praesent placerat tellus id augue condimentum</p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="list-group-status status-away"></div>
                                        <img src="{{ Module::asset('support:img/users/user.jpg') }}" class="pull-left" alt="Dmitry Ivaniuk"/>
                                        <span class="contacts-title">Dmitry Ivaniuk</span>
                                        <p>Donec risus sapien, sagittis et magna quis</p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="list-group-status status-away"></div>
                                        <img src="{{ Module::asset('support:img/users/user3.jpg') }}" class="pull-left" alt="Nadia Ali"/>
                                        <span class="contacts-title">Nadia Ali</span>
                                        <p>Mauris vel eros ut nunc rhoncus cursus sed</p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="list-group-status status-offline"></div>
                                        <img src="{{ Module::asset('support:img/users/user6.jpg') }}" class="pull-left" alt="Darth Vader"/>
                                        <span class="contacts-title">Darth Vader</span>
                                        <p>I want my money back!</p>
                                    </a>
                                </div>
                                <div class="panel-footer text-center">
                                    <a href="pages-messages.html">Show all messages</a>
                                </div>
                            </div>
                        </li -->
                <!-- END MESSAGES -->
                

            </ul>
            <!-- END X-NAVIGATION VERTICAL -->

            @yield('content')

        </div>
        <!-- END PAGE CONTENT -->

    </div>
    <!-- END PAGE CONTAINER -->

    <!-- MESSAGE BOX-->
    <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                <div class="mb-content">
                    <p>Are you sure you want to log out?</p>
                    <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <a href="{{ route('logout') }}" class="btn btn-success btn-lg"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            Yes
                        </a>
                        {{--<a href="pages-login.html" class="btn btn-success btn-lg">Yes</a>--}}
                        <button class="btn btn-default btn-lg mb-control-close">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('modal')
    @show


    <audio id="audio-alert" src="{{ Module::asset('support:audio/alert.mp3') }}" preload="auto"></audio>
    <audio id="audio-fail" src="{{ Module::asset('support:audio/fail.mp3') }}" preload="auto"></audio>

    <script type="text/javascript" src="{{ Module::asset('support:js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/bootstrap.min.js') }}"></script>

    <script type='text/javascript' src='{{ Module::asset('support:js/icheck.min.js') }}'></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/jquery.mCustomScrollbar.min.js') }}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/scrolltopcontrol.js') }}"></script>

    <script type="text/javascript" src="{{ Module::asset('support:js/raphael-min.js') }}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/morris.min.js') }}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/d3.v3.js') }}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/rickshaw.min.js') }}"></script>
    <script type='text/javascript' src='{{ Module::asset('support:js/jquery-jvectormap-1.2.2.min.js') }}'></script>
    <script type='text/javascript' src='{{ Module::asset('support:js/jquery-jvectormap-world-mill-en.js') }}'></script>
    <script type='text/javascript' src='{{ Module::asset('support:js/bootstrap-datepicker.js') }}'></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/owl.carousel.min.js') }}"></script>

    <script type="text/javascript" src="{{ Module::asset('support:js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/daterangepicker.js')}}"></script>


    <script type="text/javascript" src="{{ Module::asset('support:js/plugins.js') }}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/actions.js') }}"></script>

    {{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue"></script>--}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/vue.js') }}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/axios.min.js') }}"></script>
    <script type="text/javascript" src="{{ Module::asset('support:js/vue-tables-2.min.js') }}"></script>

    @section('js')
    @show
</body>
</html>
