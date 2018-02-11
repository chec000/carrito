@extends('layout.default')
@section('title')
    {{trans('support.errors.notfound')}}
@stop

@section('content')

    <div class="error-container">

        <h1>404</h1>
        <h2>{{trans('support.errors.notfound')}}</h2>
        <p class="return">{{trans('support.errors.return')}}<a href="javascript:history.back()">{{trans('support.errors.back')}}</a></p>
    </div>

@endsection
