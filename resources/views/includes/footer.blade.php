<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <nav class="col-md-2 col-sm-6 col-xs-12 light-line-right">
                    <a class="Omnilife" href="https://www.omnilife.com/"></a>
                </nav>
                <nav class="col-md-3 col-sm-6 col-xs-12 light-line-right">
                    <h4><span>{{trans('welcome.footer.business_services')}}</span></h4>
                    <ul>
                        <li>
                            <a href="https://www.omnilife.com/zona-de-empresarios/">{{trans('welcome.footer.employerszone')}}</a>
                        </li>
                        <li>
                            <a href="https://www.seytu.com">Seytu.com</a>
                        </li>
                    </ul>   
                </nav>
                <nav class="col-md-2 col-sm-6 col-xs-12 light-line-right">
                    <h4><span>{{trans('welcome.footer.company')}}</span></h4>
                    <ul>
                        <li>
                            <a href="https://www.omnilife.com/{{(session()->get('applocale') != null ? session()->get('applocale') : "es")}}/somos-omnilife/"
                               target="_blank">{{trans('welcome.footer.history')}}</a>
                        </li>
                        <li>
                            <a href="pathUrl+'/inscription/register'">{{trans('welcome.menu.affiliate')}}</a>
                        </li>
                    <!-- <li>
                            <a href="http://www.chivasdecorazon.com.mx/presitio">Chivas</a>
                        </li>
                        <li>
                            <a href="http://www.educare.edu.mx/">{{trans('welcome.footer.educare')}}</a>
                        </li> -->
                    </ul>
                </nav>
                <nav class="col-md-2 col-sm-6 col-xs-12 light-line-right">
                    <h4><span>NFUERZA</span></h4>
                    <ul>
                        <!--<li>
                            <a href="https://www.nfuerza.com/ES/simulador_.html">{{trans('welcome.footer.retail_simulator')}}</a>
                        </li> -->
                        <li>
                            <a href="https://www.nfuerza.com/ES/calendario_.html">{{trans('welcome.footer.calendar')}}</a>
                        </li>
                        <li>
                            <a v-bind:href='productsUrl'>{{trans('welcome.footer.catalogue')}}</a>
                        </li>
                        <li>
                            <a href="https://www.nfuerza.com/ES/testimonios_.html">{{trans('welcome.footer.testimony')}}</a>
                        </li>
                    </ul>
                </nav>
                <nav class="col-md-4 col-sm-6 col-xs-12">
                    <h4><span>{{trans('welcome.footer.contact')}}</span></h4>
                    <ul>
                        <li>
                            <a v-bind:href='productsUrl'>{{trans('welcome.footer.omnilife_store')}}</a>
                        </li>
                        <li>
                            <a href="https://maps.google.fr/maps?q={{trans('welcome.footer.omnilife_address')}}" target="_blank">{{trans('welcome.footer.omnilife_address')}}</a>
                        </li>
                        <li>
                            <a href="mailto:creousa@omnilife.com">creousa@omnilife.com</a>
                        </li>
                         <li>
                            <a href="tel:(972)378-0854"> (972)378-0854</a>
                        </li>
                    </ul>
                </nav>
                <nav class="col-md-1 col-sm-6 col-xs-12">
                    <ul>
                        <li>
                            <a target="_blank" href="https://www.facebook.com/NFuerzabyOmnilife/" class="Facebook"></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://twitter.com/NFuerza_" class="Twitter"></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://www.youtube.com/channel/UCvGk_C8Lk0u01_d0s-Iy76g" class="Youtube"></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://www.instagram.com/nfuerza_/" class="Instagram"></a>
                        </li>
                    </ul>
                </nav>
            </div> <!--/.row-->
        </div> <!--/.container-->
    </div> <!--/.footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <nav class="col-md-4 col-sm-6 col-xs-12">
                    <span class="pull-right">© @{{ (new Date()).getFullYear() }} Omnilife</span>
                </nav>
                <nav class="col-md-4 col-sm-6 col-xs-12 text-center">
                    <a href="" data-toggle="modal" data-target="#modalPrivacyPolicy">
                        <span>{{trans('welcome.footer.notice_privacy')}}</span>
                    </a>
                </nav>
                <nav class="col-md-4 col-sm-6 col-xs-12">
                    <a href="" data-toggle="modal" data-target="#modalTermsConditions">
                        <span class="pull-left">{{trans('welcome.footer.termns_conditions')}}</span>
                    </a>
                </nav>
            </div> <!--/.row-->
        </div> <!--/.container-->
    </div> <!--/.footer-bottom-->
</footer>

@include('partial_views.modalPrivacyPolicy')
@include('partial_views.modalTermsConditios')