@extends('layout.layout')

@section('content')
<div class="row m-top">
  <div class="container reset">
    <div class="resetPassword">
      <div v-if="resetPassword.prop.pages.distributorNumber">
        <h1>{{trans('auth.resetPassword.title')}}</h1>
        <h3>{{trans('auth.resetPassword.dist_instruction')}}</h3>
        <input v-model="resetPassword.prop.sessionResetPassword.eoId" type="text" class="form-control m-bottom bottom-line line-down" id="dist_num" name="dist_num" placeholder="{{trans('auth.resetPassword.dist_num')}}" maxlength="15" minlength="9">
        <p v-if="resetPassword.prop.showEoValidation" class="generalError">@{{ resetPassword.prop.sessionResetPassword.message }}</p>
        <p>{{trans('auth.resetPassword.support')}} <a href="mailto:creousa@omnilife.com">{{trans('auth.resetPassword.contact')}}</a>.</p>
        <button class="continue boton_omni"@click="resetPassword.method.nextResetPage('resetOption')">{{trans('auth.resetPassword.continue')}}</button>
      </div>
      <div v-if="resetPassword.prop.pages.resetOption">
        <h1>{{trans('auth.resetPassword.choose_method_instruction')}}</h1>
        <h3>{{trans('auth.resetPassword.option')}}</h3>
        <div class="container2">
          <div>
            <input @click="resetPassword.method.checkResetOption('mail')" type="radio" v-model="resetPassword.prop.resetOption" value="mail"><span>{{trans('auth.resetPassword.receive_email_title')}}</span>
            <p>{{trans('auth.resetPassword.receive_email')}} o*******.com</p>
            <input @click="resetPassword.method.checkResetOption('question')" type="radio" v-model="resetPassword.prop.resetOption" value="question"><span>{{trans('auth.resetPassword.secret_question_title')}}</span>
            <p>{{trans('auth.resetPassword.secret_question')}}</p>
            <div class="secretQuestion" v-if="resetPassword.prop.showQuestion">
              <p><strong>{{trans('auth.resetPassword.birthdate_instruction')}}</strong></p>
              <input class="form-control m-bottom bottom-line line-down" type="text" id="datepicker">
              <p><strong>@{{ resetPassword.prop.sessionResetPassword.question }}</strong></p>
              <p v-if="resetPassword.prop.showBirthdayValidation" class="generalError">{{trans('auth.resetPassword.errors.birthday')}}</p>
              <input v-model="resetPassword.prop.confirmAnswerQuestion" type="text" class="form-control m-bottom bottom-line line-down">
              <p v-if="resetPassword.prop.showQuestionValidation" class="generalError">{{trans('auth.resetPassword.errors.wrongAnswer')}}</p>
            </div>
          </div>
        </div>
        <button class="cancel" @click="resetPassword.method.cancelReset">{{trans('auth.resetPassword.cancel')}}</button>
        <button v-if="!resetPassword.prop.showQuestion" class="continue boton_omni" @click="resetPassword.method.nextResetPage('emailSent')">{{trans('auth.resetPassword.continue')}}</button>
        <button v-else class="continue boton_omni" @click="resetPassword.method.nextResetPage('confirmResetPassword')">{{trans('auth.resetPassword.continue')}}</button>
      </div>
      <div id="emailOption">
        <div v-if="resetPassword.prop.pages.emailSent">
          <p align="center"><i class="fa fa-check-circle fa-5x chckt-colorGreen" aria-hidden="true"></i></p>
          <h1>{{trans('auth.resetPassword.title')}}</h1>
          <h3>{{trans('auth.resetPassword.email_sent')}}</h3>
        </div>
      </div>
      <div id="confirmResetPassword">
        <div v-if="resetPassword.prop.pages.confirmResetPassword">
          <h1>{{trans('auth.resetPassword.title')}}</h1>
          <h3>{{trans('auth.resetPassword.enter_password')}} @{{ resetPassword.prop.sessionResetPassword.email }}</h3>
          <input v-model="resetPassword.prop.newPassword" type="password" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode < 31' class="form-control m-bottom bottom-line line-down" placeholder="{{trans('auth.resetPassword.new_password')}}" maxlength="4" minlength="4">
          <p v-if="resetPassword.prop.showPasswordValidation" class="generalError">{{trans('auth.resetPassword.errors.passwordLength')}}</p>
          <input v-model="resetPassword.prop.newMatchPassword" type="password" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode < 31' class="form-control m-bottom bottom-line line-down" placeholder="{{trans('auth.resetPassword.confirm_password')}}" maxlength="4" minlength="4">
           <p v-if="resetPassword.prop.showMatchPasswordValidation" class="generalError">{{trans('auth.resetPassword.errors.passwordMatch')}}</p>
          <button @click="resetPassword.method.cancelReset">{{trans('auth.resetPassword.cancel')}}</button>
          <button class="btn boton_omni products-font16 boton_lg" @click="resetPassword.method.nextResetPage('successReset')">{{trans('auth.resetPassword.continue')}}</button>
        </div>
      </div>
      <div id="successReset" v-if="resetPassword.prop.pages.successReset">
        <p align="center"><i class="fa fa-check-circle fa-5x chckt-colorGreen" aria-hidden="true"></i></p>
        <h1>{{trans('auth.resetPassword.password_changed')}}</h1>
        <h3>{{trans('auth.resetPassword.login_disclaimer')}}</h3>
        <button class="btn boton_omni products-font16 boton_lg" onclick="$('#loginModal').modal('show')">{{trans('auth.resetPassword.login')}}</button>
      </div>
      <div id="rejectReset" v-if="resetPassword.prop.pages.rejectReset">
        <p align="center"><i class="fa fa-times-circle fa-5x chckt-colorOrange" aria-hidden="true"></i></p>
        <h1>{{trans('auth.resetPassword.errors.code')}}</h1>
      </div>
    </div>
  </div>
</div>
@stop
