@extends('layout.default')
@section('title')
	{{trans('support.errors.unavailable')}}
@stop

@section('content')

	<div class="error-container">

		<h1>503</h1>
		<h2> {{trans('support.errors.unavailable')}}</h2>
		<p class="return">{{trans('support.errors.return')}}<a href="javascript:history.back()">{{trans('support.errors.back')}}</a></p>
	</div>

@endsection
