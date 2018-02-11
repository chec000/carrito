@extends('layout.layout')
@section('content')
  <div class="container m-top">
    <h2>PDF</h2>
    <form action="/inscription/pdf" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="sel1">{{trans('welcome.register.select_kit')}}:</label>
        <select class="form-control" id="sel1" name="kit">
          <option value="1">Nutricional</option>
          <option value="2">Seytú</option>
        </select>
      </div>
      <div class="form-group">
        <label for="name">{{trans('welcome.register.name')}}:</label>
        <input type="text" class="form-control" id="name" placeholder="{{trans('welcome.register.name')}}" name="name" value="MAGANA PEREZ ANDREA">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.address')}}:</label>
        <input type="text" class="form-control" id="address" placeholder="{{trans('welcome.register.address')}}" name="direccion" value="Av Minerva 2895 Vallarta Norte 44110">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.town')}}:</label>
        <input type="text" class="form-control" id="ciudad" placeholder="{{trans('welcome.register.town')}}" name="ciudad" value="GUADALAJARA">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.state')}}:</label>
        <input type="text" class="form-control" id="estado" placeholder="{{trans('welcome.register.state')}}" name="estado" value="CA">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.zip_code')}}:</label>
        <input type="text" class="form-control" id="cp" placeholder="{{trans('welcome.register.zip_code')}}" name="cp" value="44100">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.born_day')}}:</label>
        <input type="text" class="form-control" id="fecha_nac" placeholder="{{trans('welcome.register.born_day')}}" name="fecha_nac" value="03/15/1992">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.e_mail')}}:</label>
        <input type="text" class="form-control" id="email" placeholder="{{trans('welcome.register.e_mail')}}" name="email" value="correoGdl@corroe.com">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.phone_number_home')}}:</label>
        <input type="text" class="form-control" id="telc" placeholder="{{trans('welcome.register.phone_number_home')}}" name="telc" value="3305898762">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.phone_number')}}:</label>
        <input type="text" class="form-control" id="telp" placeholder="{{trans('welcome.register.phone_number')}}" name="telp" value="3364521234">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.other_phone_number')}}:</label>
        <input type="text" class="form-control" id="telo" placeholder="{{trans('welcome.register.other_phone_number')}}" name="telo" value="3398746378">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.codistributor')}}:</label>
        <input type="text" class="form-control" id="codis" placeholder="{{trans('welcome.register.codistributor')}}" name="codis" value="JOAQUIN CARRILLO GARCIA">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.phone_number')}}:</label>
        <input type="text" class="form-control" id="telcod" placeholder="{{trans('welcome.register.phone_number')}}" name="telcod" value="3367987651">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.born_day')}}:</label>
        <input type="text" class="form-control" id="fecha_nac_cod" placeholder="{{trans('welcome.register.born_day')}}" name="fecha_nac_cod" value="02/19/1990">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.address').', '.trans('welcome.register.town').', '.trans('welcome.register.state').', '.trans('welcome.register.zip_code')}}:</label>
        <input type="text" class="form-control" id="direccion2"
               placeholder="{{trans('welcome.register.address').', '.trans('welcome.register.town').', '.trans('welcome.register.state').', '.trans('welcome.register.zip_code')}}"
               name="direccion2" value="Av Inglaterra 3089 Vallarta Poniente">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.sponsor_pdf')}}:</label>
        <input type="text" class="form-control" id="patro" placeholder="{{trans('welcome.register.sponsor_pdf')}}" name="patro" value="JAVIER HERNANDEZ">
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.distributor_number')}}:</label>
        <input type="text" class="form-control" id="no_dist" placeholder="{{trans('welcome.register.distributor_number')}}" name="no_dist" value="123456789"
      </div>
      <div class="form-group">
        <label for="">{{trans('welcome.register.e_mail_sponsor')}}:</label>
        <input type="text" class="form-control" id="email_patrocinador" placeholder="{{trans('welcome.register.e_mail_sponsor')}}" name="email_patrocinador" value="patrocinador@correo.com">
      </div>
      <button type="submit" class="btn btn-default">Enviar</button>
    </form>
  </div>
@stop