<div class="modal" id="sponsorModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog margenes_modal" role="document">
    <div class="modal-content bordes_modal wh70 mleftmodal">
      <div class="container m-top">
      <h2 class="text-center">{{ trans('welcome.register.sponsor') }}</h2>
      <div class="text-center">
        <div class="col-md-12">
          <form class="text-center">
            <div class="form-check">
              <label>
                <input type="radio" name="radioSpons" checked value="1"> <span class="label-text">{{ trans('welcome.register.yes') }}</span>
              </label>
              <label class="m-left">
                <input type="radio" name="radioSpons" value="2"> <span class="label-text">{{ trans('welcome.register.no') }}</span>
              </label>
            </div>
          </form>
        </div>
        <div id="" class="row">
          <div class="col-md-12">
            <input type="text" v-model="register.prop.regForm.sponsor_val" name="sponsor-code" class="form-control m-bottom bottom-line line-down empty col-md-12" placeholder="{{ trans('welcome.register.insert_sponsor') }}" id="sponsorCode" v-on:click='fillSelectState.method.fillCounty(register.prop.regForm.zip_code)'>
          </div>
        </div>
        <div class="mleft2">
          <div class="">
            <button id="searchSponsorModal" type="button"  v-on:click="register.method.searchSponsor" class="border-button menu-button btn btn-secondary btn-lg btn-block">{{ trans('welcome.common.next') }} <i class="fa fa-chevron-right" aria-hidden="true" ></i></button>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
