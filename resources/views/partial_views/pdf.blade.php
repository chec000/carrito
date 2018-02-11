<div class="modal " id="pdfModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog margenes_modal" role="document">
    <div class="modal-content bordes_modal">
      <div class="container m-top">
      <h2 class="text-center">{{ trans('welcome.payment.download_contract') }}</h2>
      <div class="text-center">
        <div class="col-lg-12">
          <object id="framePdf" class="w-100" data="{{URL::to('/inscription/pdf')}}" type="application/pdf" download allowfullscreen>
            <p>{{ trans('welcome.payment.pdf_view') }}</p>
          </object>
        </div>
        <div id="chckt-pdfContractDownload" class="col-12" align="center">
          <a onclick="contract()"><button class="btn boton_omni chckt-font14 p-3 font-italic">
              {{trans('welcome.payment.download_contract')}}
          </button></a>
        </div>
        <div class="col-lg-12">
          <button id="closepdf" type="button" class="border-button menu-button btn btn-secondary btn-lg btn-block" data-dismiss="modal">{{trans('welcome.common.close')}}</button>
        </div>  
      </div>
      </div>
    </div>
  </div>
</div>
