@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.order.bc_home")</a></li>
        <li class="active"><i class="fa fa-star" aria-hidden="true"></i> @lang("support.order.bc_order")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">

            <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.order.detail')</h3>
            <div slot="body">

                <!--Invoice details-->



                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-shopping-cart"></i> #{{$order['order_number']}} {{ $order['shop_type'] == 'INSCRIPCION' ? "({$order['shop_type']})" : '' }}

                                <small class="pull-right"> {{trans('support.order.ord_date')}}: {{$order['created_at']}} </small>
                            </h2>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong><i class="fa fa-user"></i> {{$order['eo_number']}}</strong><br>
                                {{trans('support.order.phone')}} : {{$order['ship_telephone']}}<br>
                                {{trans('support.order.email')}} : {{$order['ship_email']}}<br>
                                @if($order['shop_type'] == 'INSCRIPCION')
                                    <b>{{trans('support.order.sponsor')}} :</b> {{$order['ship_sponsor'] or ''}}<br>
                                    <b>{{trans('support.order.sponsor_name')}} :</b> {{$order['ship_sponsor_name'] or ''}}<br>
                                @endif
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong><i class="fa fa-truck"></i> {{$order['ship_type']}}</strong><br>
                                {{$order['ship_address']}}, {{$order['ship_number']}} (<small>{{$order['ship_complement']}}</small>)<br>
                                {{$order['ship_colonia']}}, CEP {{$order['ship_zip_code']}}<br>
                                {{$order['ship_city_name']}} ({{$order['ship_city']}})<br>
                                {{$order['ship_state']}} ({{$order['ship_country']}})<br>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>{{trans('support.order.order_corbiz')}} #{{$order['corbiz_order_number']}}</b><br>
                            <br>
                            <b>{{trans('support.order.order_id')}} :</b> {{$order['order_id']}}<br>
                            <b>{{trans('support.order.estatus')}} :</b> {{$order['estatus']}}<br>
                            <b>{{trans('support.order.points')}} :</b>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>{{trans('support.order.date')}}</th>
                                    <th>{{trans('support.order.estatus')}}</th>
                                    <th>{{trans('support.order.hecho')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs_detail as $detail)
                                    <tr>
                                        <td>{{$detail['id']}}</td>
                                        <td>{{$detail['created_at']}}</td>
                                        <td>{{$detail['estatus']}}</td>
                                        <td>
                                            @if((int)$detail['last_modifier']!==0)
                                                {{$detail['last_modifier_name']}}
                                            @else
                                                {{trans('support.order.system')}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- /.row -->
                </section>



                <!--Final invoice details-->


            </div>








        </div>
    </div>


@stop

@section('js')

    <


@endsection
