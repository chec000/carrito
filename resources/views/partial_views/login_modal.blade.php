<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog margenes_modal" role="document">
    <div class="modal-content bordes_modal">
      <div class="row">
        <div class="col-md-6 line-right">
          <div class="col-md-12">
            <h3 class="title1">{{ trans('login.modal.to_finish_buy_title') }}</h3>
          </div>
          <div class="col-md-12 text-center">
            <h3 class="title2">{{ trans('login.modal.inscription_title') }}</h3>
          </div>
          <div class="col-md-12">
            <h5>{{ trans('login.modal.affiliation_benefits_title') }}</h5>
            <p class="text-justify">{{ trans('login.modal.affiliation_benefits') }}</p>
          </div>
          <div class="col-md-12 text-center button1">
            <a v-bind:href="urlCheckout+'checkout'"><button class="button-modal border-none" type="button">{{ trans('login.modal.affiliation') }}</button></a>
          </div>
        </div>
        <div class="col-md-6">
       <form id="target2" @submit.prevent='menu.method.login' >                 
          <div class="col-md-12 text-center">
            <h3 class="title1">{{ trans('login.modal.member_title') }}</h3>
          </div>
          <div class="col-md-12 login">                          
                  <input v-model="menu.prop.user" class="form-control" type="input" name="user" placeholder="{{ trans('welcome.menu.user') }}">
            <input v-model="menu.prop.password" class="form-control" type="password" name="password" placeholder="{{ trans('welcome.menu.password') }}">
            <p class="error"></p>
            <a class="login-link" href="/authentication/resetPassword">{{ trans('login.modal.forgot_password_label') }}</a>
          </div>
          <div class="col-md-12 text-center button1">  
             <input type="submit" v-on:click="menu.method.login" class="button-modal modal-login" value="{{ trans('login.modal.login') }}">
                    
          </div>
              </form>     
        </div>
    
            
            
        <div class="col-md-12 text-center">
          <button class="modal-link" onclick="main.menu.prop.goCheckout = false" data-dismiss="modal">{{ trans('login.modal.cancel') }}</button>
        </div>
      </div>
    </div>
  </div>
</div>
