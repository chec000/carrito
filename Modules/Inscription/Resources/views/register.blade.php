@extends('layout.layout')
@section('content')
	<div class="container m-top" id="profile-view">
		<div id="nav-reg" class="text-center" v-if="!sessions.user.id">
			<div class="boxItem">
				<i  id='information' class="fa fa-user fa-4x azult" aria-hidden="true"></i>
				<p>{{trans('welcome.register.personal_info')}}</p>
			</div>
			<div class="boxItem">
				<i id='kit' class="fa fa-shopping-bag fa-4x azult" aria-hidden="true"></i>
				<p>{{trans('welcome.register.select_kit')}}</p>
			</div>
			<div class="boxItem">
				<i id='payment' class="fa fa-money fa-4x azult" aria-hidden="true"></i>
				<p>{{trans('welcome.shipp.payment_method')}}</p>
			</div>
			<div class="boxItem">
				<i id='confirmation' class="fa fa-check-circle fa-4x azult" aria-hidden="true"></i>
				<p>{{trans('welcome.menu.confirm')}}</p>
			</div>
		</div>
		<input type="hidden" id='subMenu' value="1">
		<h1 id="form-title" class="m-top25 products-title morado"><b>{{ trans('welcome.register.personal_info') }}</b></h1>
		<div id="form-reg">
			<form id="form" @submit.prevent="register.method.addFormReg">
				<div class="form-group row">
					<!--<div class="col">
						<select class="form-control m-bottom bottom-line line-down" name="country" v-model="register.prop.regForm.country" required>
							<option value="" disabled selected>{{ trans('welcome.register.select_a_country') }}</option>
							<option v-for="country in fillSelectCountry.prop.countries" :value="country.short_name" >@{{country.name}}</option>
						</select>
					</div>-->
					<div class="col"> <br>
						<h4>{{ trans('welcome.register.your_sponsor') }}: @{{sessions.sponsor.eo_name}}</h4>
					</div>
					<div class="col"></div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col">
							<input type="text"  v-model="register.prop.regForm.name" name="name" class="form-control m-bottom bottom-line line-down letters" placeholder="{{ trans('welcome.register.name') }}" v-on:blur='fillSelectState.method.fillCounty(register.prop.regForm.zip_code)' required>
						</div>
						<div class="col">
							<input type="text" v-model="register.prop.regForm.last_name" name="last_name" class="form-control m-bottom bottom-line line-down letters" placeholder="{{ trans('welcome.register.last_name') }}" required>
						</div>
						<!--<div class="col">
                            <input type="text" name="mothers_last_name" class="form-control m-bottom bottom-line line-down" placeholder="*Apeliido2">
                        </div>-->
						<div class="col"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-3">
							<p class="medium-din">*{{ trans('welcome.register.gender') }}</p>
							<select v-model="register.prop.regForm.gender" class="form-control m-bottom bottom-line line-down height30" name="gender" required>
								<option selected disabled>{{ trans('welcome.register.gender') }}</option>
								<option value="M">{{ trans('welcome.register.male') }}</option>
								<option value="F">{{ trans('welcome.register.female') }}</option>
							</select>
						</div>
					</div>
				</div><br>
				<div class="form-group">
					<div class="row">
						<p class="medium-din col-lg-12">*{{trans('welcome.register.born_day')}}</p>
						<div class="col">
							<select class="col form-control m-bottom bottom-line line-down" name="month" v-model="register.prop.regForm.month" required id="month-reg">
								<option value="" selected disabled>{{ trans('welcome.register.month') }}</option>
								<option value="1">{{ trans('welcome.month.JANUARY') }}</option>
								<option value="2">{{ trans('welcome.month.FEBRUARY') }}</option>
								<option value="3">{{ trans('welcome.month.MARCH') }}</option>
								<option value="4">{{ trans('welcome.month.APRIL') }}</option>
								<option value="5">{{ trans('welcome.month.MAY') }}</option>
								<option value="6">{{ trans('welcome.month.JUNE') }}</option>
								<option value="7">{{ trans('welcome.month.JULY') }}</option>
								<option value="8">{{ trans('welcome.month.AUGUST') }}</option>
								<option value="9">{{ trans('welcome.month.SEPTEMBER') }}</option>
								<option value="10">{{ trans('welcome.month.OCTOBER') }}</option>
								<option value="11">{{ trans('welcome.month.NOVEMBER') }}</option>
								<option value="12">{{ trans('welcome.month.DECEMBER') }}</option>
							</select>
						</div>
						<div class="col">
							<select class="col form-control m-bottom bottom-line line-down" name="day" v-model="register.prop.regForm.day" required id="day-reg">
								<option value="" selected disabled>{{ trans('welcome.register.day') }}</option>
								@for ($i = 1; $i <= 31; $i++)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
						</div>
						<div class="col">
							<select class="col form-control m-bottom bottom-line line-down" name="year" required v-model="register.prop.regForm.year" id="year-reg">
								<option value="" selected disabled>{{ trans('welcome.register.year') }}</option>
								@for ($i = 2002; $i >= 1900; $i--)
									<option value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
						</div>
						<div class="col"></div>
					</div>
					<div class="container">
						<div class="row">
							<div id="d-val" class="col-lg-3">
								<p id="email-valid">{{ trans('welcome.register.date_format') }}</p>
							</div>
							<div id="d-val2" class="col-lg-3">
								<p id="email-valid">{{ trans('welcome.register.age_format') }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col">
							<input type="text" name="address" class="form-control m-bottom bottom-line line-down" placeholder="{{ trans('welcome.register.address').trans('welcome.register.street_number') }}" required v-model="register.prop.regForm.address">
						</div>
						<!--<div class="col">
                            <input type="text" name="between_streets" class="form-control m-bottom bottom-line line-down" placeholder="Entre que calles?">
                        </div>-->
						<div class="col"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<!--<div class="col">
							<input type="text" name="district" class="form-control m-bottom bottom-line line-down" placeholder="{{ trans('welcome.register.district') }}" required v-model="register.prop.regForm.district" v-on:blur='fillSelectState.method.fillCounty(register.prop.regForm.zip_code)'>
						</div>-->
						<div class="col">
							<input type="number" name="zip_code" class="form-control m-bottom bottom-line line-down" placeholder="{{ trans('welcome.register.zip_code') }}" required v-model="register.prop.regForm.zip_code" v-on:blur='fillSelectState.method.fillCounty(register.prop.regForm.zip_code)' min="3">
							 <p v-if="showZipError" class="generalError">Codigo postal no encontrado</p>
						</div>
						<div class="col">
							<select name="county" class="form-control m-bottom bottom-line line-down m-top6 height30" required class="footer" v-model="register.prop.regForm.county">
								<option value="" selected disabled>{{ trans('welcome.register.county') }}</option>
								<option v-for="county in fillSelectState.prop.counties"
										:value="county.county" >@{{county.county}}</option>
							</select>
						</div>
						<div class="col"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col">
							<select name="state" class="form-control m-bottom bottom-line line-down" required v-model="register.prop.regForm.state">
								<option value="" selected disabled>{{ trans('welcome.register.state') }}</option>
								<option v-for="state in fillSelectState.prop.states" :value="state.state_key" >@{{state.state}}</option>
							</select>
						</div>
						<div class="col">
							<select name="federal_entities" class="form-control m-bottom bottom-line line-down" required class="footer" v-model="register.prop.regForm.federal_entities" v-on:change='fillSelectState.method.fillSelectShip(register.prop.regForm.federal_entities)'>
								<option value="" selected disabled>{{ trans('welcome.register.town') }}</option>
								<option v-for="city in fillSelectState.prop.federal_entities" :value="city.city" >@{{city.city}}</option>
							</select>
						</div>
						<div class="col">
							<select name="ship_company" class="form-control m-bottom bottom-line line-down" required class="footer" v-model="register.prop.regForm.ship_company">
								<option value="" selected disabled>{{ trans('welcome.shipp.service_delivery') }}</option>
								<option v-for="ship in fillSelectState.prop.ship_companies"
										:value="ship.value" >@{{ship.text}}</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col">
							<input id="email-1" v-model="register.prop.regForm.email" type="email" name="e_mail" class="form-control m-bottom bottom-line line-down " placeholder="{{ trans('welcome.register.e_mail') }}" required>
						</div>
						<div class="col">
							<input id="email-2" type="email" name="e_mail_confirmation" class="form-control m-bottom bottom-line line-down " placeholder="{{ trans('welcome.register.e_mail_confirmation') }}" required>
						</div>
						<div class="col"></div>
					</div>
					<div id="e-val" class="col-lg-3">
						<p id="email-valid">{{ trans('welcome.register.e_mail_match') }}</p>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-lg-4">
							<input type="number" v-model="register.prop.regForm.phone_number" name="phone_number" class="form-control m-bottom bottom-line line-down" placeholder="{{ trans('welcome.register.phone_number') }}" required min="100000000" max="9999999999">
						</div>
						<!--<div class="col-lg-8">
                            <div class="col-lg-6">
                            <label id="file-button" for="upload-photo" class="form-control file-button fondo-morado letra-blanca"><b>Selecciona foto de perfil</b></label>
                            </div>
                            <div class="col-lg-6">
                            <input id="upload-photo" type="file" name="profile_picture" class="form-control m-bottom fondo-morado letra-blanca height30">
                            </div>
                        </div>-->
					</div>
				</div>
				<div class="form-group m-top5">
					<div class="row">
						<div class="col">
							<select class="form-control m-bottom bottom-line line-down register-select height30 m-top6" v-model="register.prop.regForm.security_question" name="security_question" required>
								<option value="" selected disabled>{{ trans('welcome.register.security_question') }}</option>
								<option v-for="question in fillSecurityQuestions.prop.questions" :value="question.security_question_id" >@{{question.question}}</option>
							</select>
						</div>
						<div class="col">
							<input type="text" v-model="register.prop.regForm.answer" name="answer" class="form-control m-bottom bottom-line line-down" placeholder="{{ trans('welcome.register.answer') }}" required>
						</div>
						<div class="col"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="row" id="check-box">
						<div class="col-lg-12 medium-din">
							<h4>*{{ trans('welcome.register.required_data') }}</h4>
						</div>
						<div class="col-lg-12">
							<div class="">
								<input data-toggle="modal" v-model="register.prop.regForm.payment_condition" data-target="#myModal" id="checkbox-1" class="checkbox-custom" name="checkbox-1" type="checkbox" required value="1">
								<label for="checkbox-1" class="checkbox-custom-label"><b>{{ trans('welcome.register.terms_conditions') }}</b></label>
								<label id="check1"></label>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="">
								<input id="checkbox-2" class="checkbox-custom" name="checkbox-2" type="checkbox" required value="2">
								<label for="checkbox-2" class="checkbox-custom-label"><b>{{ trans('welcome.register.payment_condition') }}</b></label>
								<label id="check2"></label>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="">
								<input id="checkbox-3" class="checkbox-custom" name="checkbox-3" type="checkbox" required value="3">
								<label for="checkbox-3" class="checkbox-custom-label"><b>{!! trans('welcome.register.privacy_statement') !!}</b></label>
								<label id="check3"></label>
							</div>
						</div>
                </div>
            </div>
            <div class="form-group" id="form-buttons">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="col-lg-6">
                            <button data-toggle="modal" data-target="#sponsorModal" id="form-prev" type="button" class="border-button menu-button btn btn-secondary btn-lg btn-block" ><i class="fa fa-chevron-left" aria-hidden="true"></i> {{ trans('welcome.common.previous') }}</button>
                        </div>
                    </div>
                    <div id="div-next" class="col-lg-6">
                        <div class="col-lg-6">
                            <button id="form-next" type="submit" class="border-button menu-button btn btn-secondary btn-lg btn-block" disabled>{{ trans('welcome.common.next') }}  <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="invisible">
            </div>
        </form>
    </div>
    @include('partial_views.terms')
    @include('partial_views.sponsor_modal')
    <div id="kit-part" class="container">
        <div class="row">
            <p class="medium-din text-center m-left">{{ trans('welcome.register.kit_title') }}
                    </p>
        </div>
        <div id="radios" class="row">
            <div class="col-lg-4 m-top10 kit-checked" v-for="kits in fillkit.prop.kits">
                <input class="radnone" type="radio" name="radio_kit" v-model="kit.prop.saveKit.radio_kit" :value="kits.product_id" :id="kits.product_id" />
                <label class="kit m-top25" :for="kits.product_id">
                    <div class="">
                        <i class="fa fa-check-circle fa-2x check-icon"></i>
                        <div class="border-img text-center">

                            <img :src="path_image+kits.sku+'.png'" onerror='this.src="{{asset('img/imagen_producto.png')}}"'>
                        </div>
                        <center><h2 class="orange-font"><b>{{ trans('welcome.register.kit_price') }} $@{{kits.price.toLocaleString(undefined, {'maximumFractionDigits':2}) }}</b></h2></center>
                        <div class="col-lg-11 azult">
                            <p>{{trans('welcome.register.select_kit')}}:</p>
                            <p>@{{kits.name}}</p>
                            <p>Sku: @{{kits.sku}}</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-lg-12">
                            <button type="button" name="addToCart" class="fondo-morado letra-blanca btn btn-secondary w-100 height30"  v-on:click="kit.method.saveKit(kits)"><h4>{{ trans('welcome.register.select') }}</h4></button>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>
@stop