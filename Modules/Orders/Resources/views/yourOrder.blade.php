@extends('layout.layout')

@section('content')
    <div id="yourOrders-content" class="container-fluid">
        <div id="youOrders-tittle" class="row">
            <div class="col-12" align="center">
                <span class="chckt-colorViolet chckt-font32">
                    {{trans('welcome.orders_finished.your_orders')}}
                </span>
            </div>
        </div>


        <div id="yourOrders-products" class="mt-5">
            <div id="yourOrders-titles" class="row col-12">
                <div id="yo-titleProduct" class="col-2" align="center">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.orders_finished.order_number')}}</span>
                </div>
                <div id="yo-titleDate" class="col-3 chckt-hideMobile" align="center">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.common.date')}}</span>
                </div>
                <div id="yo-titlePoints" class="col-1 chckt-hideMobile" align="center">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.products.points')}}</span>
                </div>
                <div id="yo-titleTotal" class="col-1 chckt-hideMobile" align="center">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.common.total')}}</span>
                </div>
                <div id="yo-titleDiscount" class="col-2 chckt-hideMobile" align="center">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.common.discount')}}</span>
                </div>
                <div id="yo-titleStatus" class="col-1 chckt-hideMobile" >
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.orders_finished.status')}}</span>
                </div>
                <div id="yo-titleDetails" class="col-2 chckt-hideMobile" align="center">
                    <span class="chckt-colorViolet chckt-font20">{{ trans('welcome.shipp.details')}}</span>
                </div>
            </div>
            <hr class="chckt-hrBlue">
            @foreach($dataOrders as $order)
            <div class="row col-12">
                <div class="col-2" align="center">
                    <span class="chckt-colorGray chckt-font15">
                    {{ $order->order_number }}
                    </span>
                </div>
                <div class="col-3" align="center">
                    <span class="chckt-colorGray chckt-font15">
                    {{ $order->created_at }}
                    </span>
                </div>
                <div class="col-1" align="center">
                    <span class="chckt-colorGray chckt-font15">
                    {{ $order->points }}
                    </span>
                </div>
                <div class="col-1" align="center">
                    <span class="chckt-colorGray chckt-font15">
                    ${{ $order->amount }}
                    </span>
                </div>
                <div class="col-2" align="center">
                    <span class="chckt-colorGray chckt-font15">
                    {{ $order->discount }}%
                    </span>
                </div>
                <div class="col-1">
                    <span class="chckt-colorGray chckt-font15">
                    {{trans('welcome.orders_finished.status')}}: {{$order->order_status_id }}
                    </span>
                </div>
                <div class="col-2" align="center">
                    <a type="button" href="getDataOrderWithDetail/{{$order->order_id }}" class="boton_omni boton boton_small chckt-font15 p-0">{{trans('welcome.shipp.details')}}</a>
                </div>
            </div>
            <hr class="chckt-hrBlue">
            @endforeach
        </div>
        <div id="yourOrders-buttonsActions">
            <div class="row">
                <div class="col-lg-4 col-sm-12 mt-3">
                    <button class="btn boton_omni chckt-font12 p-3 yourOrders-btnsOptions">
                        <a v-bind:href='productsUrl' style="color:white">
                            <b>{{trans('welcome.orders_finished.back_store')}}</b>
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop