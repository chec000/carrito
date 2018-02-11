<div class="modal fade" id="modalPrivacyPolicy" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="modalHeaderMessage" class="modal-header-info">
                <span id="modalPrivacyPolicyTitle" class="products-colorViolet products-font25 whiteColor"><b>{{trans('privacyPolicy.title')}}</b></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times fa-2x products-colorWhite" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body product-scroll_v_lg">
                <div class="container">
                    {!! trans('privacyPolicy.part1') !!}
                    {!! trans('privacyPolicy.part2') !!}
                    {!! trans('privacyPolicy.part3') !!}
                    {!! trans('privacyPolicy.part4') !!}
                    {!! trans('privacyPolicy.part5') !!}
                    {!! trans('privacyPolicy.part6') !!}
                    {!! trans('privacyPolicy.part7') !!}
                    {!! trans('privacyPolicy.part8') !!}
                    {!! trans('privacyPolicy.part9') !!}
                    {!! trans('privacyPolicy.part10') !!}
                    {!! trans('privacyPolicy.part11') !!}

                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <a id="download_arco" role="button" class="btn boton_omni3 boton_lg" href="{{asset('pdf/ARCO_Rights_'.(session()->get('applocale') != null ? session()->get('applocale') : "es").'.pdf')}}"
                           target="_blank">
                            <span>{{trans('welcome.footer.download_arco')}}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>