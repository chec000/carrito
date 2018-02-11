@extends('layout.layout')

@section('content')
    <div id="businessman-content" class="container-fluid">
    @include('businessman::navbarBusinessman')
        <div class="row">
            @include('businessman::sidebarBusinessman')
            @include('businessman::purchaseSummary')
        </div>
    </div>
@stop
