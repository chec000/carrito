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
        <div class="marco-crud" id="app" rel="<?php echo $id; ?>">

            <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.order.detail')</h3>
            <div slot="body">

                <!--Invoice details-->



                <section class="invoice">
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">

                                <i class="fa fa-shopping-cart"></i>
                                #@{{ order.order_number }}


                                <span v-if="order.shop_type == 'INSCRIPCION'">(Inscription)</span>
                                {{-- $order['shop_type'] == 'INSCRIPCION' ? "({$order['shop_type']})" : '' --}}
                                <small class="pull-right"> {{trans('support.order.ord_date')}}: @{{ order.created_at }} </small>

                            </h2>
                        </div>
                    </div>
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong><i class="fa fa-user"></i> @{{ order.eo_number }}</strong><br>
                                {{trans('support.order.phone')}}: @{{ order.ship_telephone }}<br>
                                {{trans('support.order.email')}}: @{{ order.ship_email }}<br>
                                <div v-if="order.shop_type == 'INSCRIPCION'">
                                    <b>{{trans('support.order.sponsor')}}: </b> @{{ order.ship_sponsor }} {{--$order['ship_sponsor'] or ''--}}<br>
                                    <b>{{trans('support.order.sponsor_name')}}: </b> @{{ order.ship_sponsor_name }} {{--$order['ship_sponsor_name'] or ''--}}<br>
                                </div>
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <strong><i class="fa fa-truck"></i><span> {{trans('support.order.shipping_info')}}</span>
                                    {{trans('support.order.type_address')}}: @{{ order.ship_type }} {{--$order['ship_type']--}} </strong><br>
                                {{trans('support.order.address')}}: @{{ order.ship_address }}, @{{ order.ship_number }} <small> @{{ order.ship_complement }} </small><br>
                                {{trans('support.order.suburb')}}: @{{ order.ship_colonia }}, {{trans('support.order.zip')}} @{{ order.ship_zip_code }}<br>
                                {{trans('support.order.city')}}: @{{ order.ship_city_name }}  (@{{ order.ship_city }})<br>
                                {{trans('support.order.state')}}: @{{ order.ship_state }}
                                {{trans('support.order.country')}}: (@{{ order.ship_country }})<br>
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>Cobiz Order#@{{ order.corbiz_order_number }} {{--$order['corbiz_order']--}}</b><br>
                            <!-- <br> -->

                            <b>{{trans('support.order.order_id')}}:</b> @{{ order.order_id }} {{--$order['id_order']--}}<br>
                            <b>{{trans('support.order.estatus')}}:</b> @{{ order.estatus }} {{--$order['estatus']--}}<br>
                            <b>{{trans('support.order.points')}}:</b> @{{ order.points }} {{--$order['points']--}}<br />
                            <b>{{trans('support.order.corbiz_transaction')}}:</b> @{{ order.corbiz_transaction }} {{--$order['corbiz_transaction']--}} <br />
                            <b>{{trans('support.order.transaction')}}:</b> @{{ order.bank_transaction }} {{--$order['bank_transaction']--}}
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{trans('support.order.qty')}}</th>
                                    <th>{{trans('support.order.product')}}</th>
                                    <th>{{trans('support.order.sku')}} #</th>
                                    <th>{{trans('support.order.description')}}</th>
                                    <th>{{trans('support.order.points')}}</th>
                                    <th>{{trans('support.order.subtotal')}}</th>
                                    <th v-if="order.order_status_id == '11'">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="detail in orderProducts"
                                    :class="[
                                    detail.active == 1 ? 'prodAgregado' : '',
                                    detail.active == -2 ? 'prodEliminado deleteProduct' : '',
                                    detail.active == -1 ? 'deleteProduct' : '']"
                                >

                                    <td>@{{detail.quantity}} </td>
                                    <td>@{{ (detail.is_promo!==1)?detail.prod_name:'Promo' }}</td>

                                    <td v-if="detail.is_promo === 0">@{{detail.prod_code}}</td>
                                    <td v-if="detail.is_promo === 1">@{{detail.product_id}}</td>

                                    <td>@{{ (detail.is_promo!==1)?detail.prod_description:(detail.prod_description!==null?detail.prod_description:detail.promo_product_name) }}</td>
                                    <td>@{{detail.points}}</td>
                                    <td>$@{{detail.final_price}}</td>
                                    <td v-if="order.order_status_id == '11' && detail.active != -1 && detail.product_id != '9910207' && detail.is_promo==0 && detail.iskit==0">
                                        <button type="button" class="btn btn-danger" style="padding: 0 5px" @click="deleteItem(detail.order_detail_id)">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                        </button>
                                    </td>
                                    <td v-if="order.order_status_id == '11' && detail.active == -1 ">
                                        <button type="button" class="btn btn-warning" style="padding: 0 5px" @click="activeProduct(detail.order_detail_id)">
                                            <i class="fa fa-undo" aria-hidden="true"></i> Reactivate
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="order.order_status_id == '11' && addProductsVal" style="background-color: #b9b9b9;">
                                    <td colspan="7">{{trans('support.order.change_products')}}<i class="fa fa-arrow-down" aria-hidden="true"></i></td>
                                </tr>
                                <tr  v-for="ap in addProducts">
                                    <td>@{{ ap.quantity }} </td>
                                    <td>@{{ ap.name }}</td>
                                    <td>@{{ ap.sku }}</td>
                                    <td>@{{ ap.short_description }}</td>
                                    <td>@{{ ap.points }}</td>
                                    <td>$@{{ ap.subtotal }}</td>
                                    <td v-if="order.estatus == 'Corbiz Error'">
                                        <span class="label label-success">{{trans('support.order.order_added')}}</span>
                                        <button type="button" class="btn btn-danger" style="padding: 0 5px" @click="removeProductList(ap.product_code)">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="order.order_status_id == '11' && addProductsVal">
                                    <td>Qty: </td>
                                    <td><input type="number" style="width: 50px" v-model="newProduct.cantidad" required=""></td>
                                    <td>Product: </td>
                                    <td colspan="4">
                                        <select v-model="newProduct.products" required="">
                                            <option  :value="pro.sku" v-for="pro in products"> @{{ pro.sku }} - @{{ pro.name }} </option>
                                        </select>
                                        <button type="button" class="btn btn-success" style="padding: 0 12px" @click="addListProduct()">
                                            <i class="fa fa-plus" aria-hidden="true"></i> Add Product
                                        </button>
                                        {{--
                                            <button type="button" class="actPreBtn btn btn-warning" style="padding: 0 12px"
                                                disabled="disabled" @click="enviaCostos()" >
                                                <i class="fa fa-pencil" aria-hidden="true"></i> Actualizar Precios
                                                <i class="actPre fa fa-spinner fa-pulse fa-fw" style="display: none;"></i>
                                            </button>
                                        --}}
                                        <button type="button" id="actOrdBtn" class="actOrdBtn btn btn-primary" style="padding: 0 12px"
                                                disabled="disabled" @click="guardarOrden()">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> {{trans('support.order.save_changes')}}
                                            <i class="guardaOrderBtn fa fa-spinner fa-pulse fa-fw" style="display: none;"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6">
                            <span class="lead">Payment Methods:</span><br>
                            <strong>@{{ order.payment_bank}} </strong><br>
                            <i class="fa fa-credit-card"></i> @{{ order.payment_type}}

                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                <strong>Corbiz Error :</strong>@{{ order.error_corbiz }}
                            </p>
                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                <strong>{{trans('support.order.last_modifier')}}:</strong>
                                <span v-if="order.last_modifier != 0"> @{{ order.last_modifier_name }}</span>
                                <span v-else>{{trans('support.system')}}</span>
                                <small class="pull-right"> {{trans('support.order.last_date')}}: @{{ order.updated_at }} </small>

                            </p>
                            <a class="btn btn-info btn-sm" v-bind:href="'logs/'+ order.order_id" >
                                <i class="fa-calendar-o fa"></i> {{trans('support.order.log')}}
                            </a>
                            <a class="btn btn-default" href="{{asset('support/orders/')}}">
                                <i class="fa fa-angle-left"></i> {{trans('support.order.back')}}
                            </a>

                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody><tr>
                                        <th style="width:50%">{{trans('support.order.subtotal')}}:</th>
                                        <td>$@{{ order.amount - order.tax_amount }} </td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('support.order.tax')}} </th>
                                        <td>$@{{ order.tax_amount }} </td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('support.order.points')}}:</th>
                                        <td>@{{ order.points }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{trans('support.order.total')}}:</th>
                                        <td>$@{{ order.amount }}</td>
                                    </tr>
                                    </tbody></table>
                            </div>
                        </div>
                    </div>


                </section>



                <!--Final invoice details-->


            </div>








        </div>
    </div>


@stop

@section('js')

    <script type="text/javascript">

        $(function() {
            $( ".VueTables__search label" ).text('@lang("support.order.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.order.table.search")');

            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.order.table.placeholder")' );
        });

        Vue.use(VueTables.ClientTable);

        Vue.component('modal', {
            template: '#modal-template'
        });

        class Errors {
            constructor() {
                this.errors = {};
            }
            has(field) {
                return this.errors.hasOwnProperty(field);
            }
            any() {
                return Object.keys(this.errors).length > 0;
            }
            get(field){
                if(this.errors[field]){
                    return this.errors[field][0];
                }
            }
            record(errors){
                this.errors = errors;
            }
            clear(field){
                delete this.errors[field];
            }
        };

        new Vue({
            el: "#app",
            data: {
                idData: 0,
                createModal: false,
                updateModal: false,
                disableModal: false,
                enableModal: false,
                deleteModal: false,
                orderProducts: [],
                products: [],
                addProducts: [],
                newProduct: {'cantidad': '', 'products':''},
                orderId: '',
                addProductsVal: false,
                valDisabled: false,
                selectTrStyle: '',
                errors: new Errors(),
                newItem: {'order': '','eo_number':'','order_number': '','amount':'','attempts':'','created_at':'', 'order_status_id': '','':''},
                columns: ['order_id', 'eo_number', 'order_number','amount','attempts','created_at','order_status_id','activate','option'],
                data: [],
                dlang: [],
                order: [],
                options: {
                    headings: {
                        order_id: 'Id',
                        eo_number: 'Numero empresario',
                        order_number: 'Numero de orden',
                        amount:'Total',
                        attempts:'Intentos',
                        created_at: 'Fecha de Creación',
                        order_status_id:'Estatus del pedido',
                        activate: 'Activar Reintentos',

                        option: 'Acciones'
                    },
                    sortable: ['order_id', 'eo_number','order_status_id','created_at'],
                    filterable: ['order_id', 'eo_number','order_status_id','created_at']
                }
            },

            created() {
                this.orderId = $('#app').attr( "rel" );
                this.getListItems(this.orderId);

            },

            methods: {

                selectCss(id) {


                    if (id == 1)
                    { this.selectTrStyle = 'prodAgregado' }
                    else if(id == -2)
                    { this.selectTrStyle = 'prodEliminado' }
                    else if(id == -1)
                    { this.selectTrStyle = 'deleteProduct' }
                    else
                    { this.selectTrStyle = '' }
                },
                validaItemsDelete(){
                    this.addProductsVal = false;
                    for (var i = 0; i < this.orderProducts.length; i++) {
                        if(this.orderProducts[i].active == -1){
                            this.addProductsVal = true;

                        }
                    }

                },

                getListItems(id) {

                    axios.get('list/'+id).then(response => {

                        this.order = response.data.order;
                        this.orderProducts = response.data.order_detail;
                        this.products      = response.data.productos;
                        this.validaItemsDelete();
                        console.log(response.data);

                    });
                },

                getNameId(items)
                {

                    for (var i=0; i<items.length; i++) {

                        items[i].order_status_id = items[i].orderstatus.status;
                        this.data = items;
                    }
                },
                activeProduct(id){
                    axios.get('update/'+id)
                        .then(response => {
                            this.getListItems(this.orderId);
                            this.validaItemsDelete();
                            this.addProducts = [];
                            toastr.success('Item active Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});

                        });
                    $('.actOrdBtn').attr('disabled', 'disabled')
                },
                deleteItem(id) {

                    axios.post('delete/'+id).then(response => {
                        this.getListItems(this.orderId);
                        toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        this.validaItemsDelete();
                    });
                },
                addListProduct(){
                    if(this.newProduct.cantidad != "" && this.newProduct.products != "" && this.newProduct.cantidad > 0){
                        for (var i = 0; i < this.products.length; i++) {
                            if(this.products[i].sku == this.newProduct.products){
                                this.products[i].quantity = this.newProduct.cantidad;
                                this.products[i].subtotal = this.newProduct.cantidad * this.products[i].price;
                                this.addProducts.push(this.products[i]);
                                Vue.delete(this.products, i);
                                if (this.addProducts.length > 0) { $('.actOrdBtn').removeAttr('disabled'); }
                                //if (this.addProducts.length > 0) { $('.actPreBtn').removeAttr('disabled');  }
                            }
                        }
                        // $('.actOrdBtn').attr('disabled', 'disabled')
                    }else{
                        alert('Es necesario ingresar el producto y cantidad');
                    }
                },
                removeProductList(prodCode){
                    for (var i = 0; i < this.addProducts.length; i++) {
                        if(this.addProducts[i].product_code == prodCode){
                            Vue.delete(this.addProducts[i], 'quantity');
                            this.products.push(this.addProducts[i]);
                            Vue.delete(this.addProducts, i);
                            if (this.addProducts.length == '0') { $('.actPreBtn').attr('disabled', 'disabled'); }
                        }
                    }
                    $('.actOrdBtn').attr('disabled', 'disabled');
                },
                actualizaEstado(id){
                    axios.get('changestatus/'+id)
                        .then(response => {
                            this.getListItems(this.orderId);
                            toastr.success('Item update Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        });
                },
                enviaCostos(){
                    $('.actPre').show();
                    $('.actPreBtn').attr('disabled', 'disabled');
                    $('.cargaEspera').show();
                    axios.post('enviacostos/', { order: this.order, productos_nuevos: this.addProducts })
                        .then(response => {
                            if (response.data.datos.status) {
                                this.guardaCotizacion(response.data.datos.result);
                                this.guardaCotizacionProductos(response.data.item);
                                toastr.success('Respuesta correcta.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                                $('.actOrdBtn').removeAttr('disabled');
                            }else{
                                toastr.error('No se pudo procesar.', 'Error Alert', {"closeButton": true, timeOut: 5000});
                            }
                            $('.actPre').hide();
                            $('.actPreBtn').removeAttr('disabled');
                            $('.cargaEspera').hide();
                        });
                },
                guardaCotizacion(costos){
                    this.order.tax_amount = costos.pod_impuestos;
                    this.order.pod_subtotal = costos.pod_subtotal;
                    this.order.amount = costos.pod_total;
                    this.order.points = costos.poi_puntos;
                    this.valDisabled = false;
                },
                guardaCotizacionProductos(costos){
                    for (var i = 0; i < costos.item.length; i++) {
                        for (var a = 0; a < this.addProducts.length; a++) {
                            if(this.addProducts[a].product_code == costos.item[i].codigo){
                                this.addProducts[a].points = costos.item[i].puntos;
                                this.addProducts[a].price = costos.item[i].precio;
                                this.addProducts[a].quantity = costos.item[i].cant;
                            }
                        }
                        for (var b = 0; b < this.orderProducts.length; b++) {
                            if(this.orderProducts[b].prod_code == costos.item[i].codigo){
                                this.orderProducts[b].points = costos.item[i].puntos;
                                this.orderProducts[b].final_price = costos.item[i].precio;
                                this.orderProducts[b].quantity = costos.item[i].cant;
                            }
                        }
                    }
                },
                guardarOrden(){
                    $('.actOrdBtn').attr('disabled', 'disabled');
                    $('.guardaOrderBtn').show();
                    $('.cargaEspera').show();
                    axios.post('guardaorden', { order: this.order, orderProducts: this.orderProducts, productos_nuevos: this.addProducts })
                        .then(response => {
                            console.log(response.data.respuesta);
                            this.getListItems(this.orderId);
                            this.validaItemsDelete();
                            this.addProducts = [];
                            toastr.success('Order Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                            $('.guardaOrderBtn').hide();
                            $('.cargaEspera').hide();
                        });
                },
                onItem(order_id) {
                    this.enableModal = false;
                    axios.get('orders/'+order_id+'/on').then(response => {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                offItem(order_id) {
                    this.disableModal = false;
                    axios.get('categories/'+order_id+'/off').then(response => {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                }
            }
        });

    </script>


@endsection
