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
            <v-client-table :columns="columns" :data="data" :options="options">
                @if(Auth::user()->hasPermission("orders.status"))
                <div slot="activate"  slot-scope="props" class="text-center">

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Activate"
                       @click = "getModalOn(props.row.order_id,'1')"
                       v-if="props.row.orderstatus.order_status_id == '11'"></i>

                    <i class="optIcon fa fa-check fa-2x" style="color: #259d6d;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Activated"
                       v-if="props.row.orderstatus.order_status_id == '4'"></i>


                </div>
                @endif
                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">



                    <a v-bind:href="'orders/view/'+ props.row.order_id" type="button" title="Consultar Complemento" class="btn btn-default btn-xs" id="ord_26039">
                        <i class="fa fa-search fa-2x" aria-hidden="true"
                        ></i>
                    </a>


                    <!-- i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.order_id,'3')"></i -->

                </div>
            </v-client-table>





            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.order.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.order.dialog_enable")<small> <br />@lang("support.order.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        @lang("support.order.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        @lang("support.order.button.yes")
                    </button>
                </div>
            </modal>


        </div>
    </div>

    {{-- Template Modal --}}
    <script type="text/x-template" id="modal-template">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container" style="width: 1100px !important;">
                        <a class="close-modal" @click="$emit('close')" ></a>
                        <div class="modal-header">
                            <slot name="header">
                            </slot>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                            </slot>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>
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
                newItem: {'order': '','eo_number':'','order_number': '','amount':'','shop_type':'','attempts':'','created_at':'', 'order_status_id': '','':''},
                columns: ['order_id', 'eo_number', 'order_number','corbiz_transaction','amount','shop_type','attempts','created_at','order_status_id','activate','option'],
                data: [],
                dlang: [],
                order: [],
                options: {
                    headings: {
                        order_id: 'Id',
                        eo_number: '@lang("support.order.input.orders")',
                        order_number: '@lang("support.order.input.order_num")',
                        corbiz_transaction : '#',
                        amount:'Total',
                        shop_type:'@lang("support.order.input.type")',
                        attempts:'@lang("support.order.input.attempts")',
                        created_at: '@lang("support.date_created")',
                        order_status_id:'@lang("support.order.estatus")',
                        activate: '@lang("support.order.input.activar")',

                        option: '@lang("support.order.input.actions")'
                    },
                    sortable: ['order_id', 'eo_number','corbiz_transaction','order_status_id','created_at'],
                    filterable: ['order_id', 'eo_number','corbiz_transaction','order_status_id','created_at']
                }
            },

            created() {
                this.orderId = $('#app').attr( "rel" );
                this.getListItems(this.orderId);

            },

            methods: {

                sendForm(order_id)
                {
                    if (order_id == 1){
                        $("#crear").click();
                    }else if(order_id == 2){
                        $("#editar").click();
                    }
                },

                getModalOn(order_id,tipo){
                    this.idData = order_id;
                    if(tipo == '1'){
                        this.enableModal = true;
                    }else if(tipo == '2'){
                        this.disableModal = true;
                    }else if(tipo == '3'){
                        this.deleteModal = true;
                    }else if(tipo == '4'){
                        this.getDataEdit();
                        this.updateModal = true;

                    }
                },
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

                getListItems() {
                    axios.get('orders/1').then(response => {

                        //this.dlang = response.data.language;
                        this.getNameId(response.data.order);

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

                    axios.post('orders/delete/'+id).then(response => {
                        this.getListItems(this.orderId);
                        toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        this.validaItemsDelete();
                    });
                },
                getDataEdit()
                {

                    axios.get('orders/'+this.idData+'/edit').then(response =>
                    {

                        this.order = response.data.order;
                        this.orderProducts = response.data.order_detail;
                        this.products      = response.data.productos;
                        this.validaItemsDelete();
                        console.log(response.data);
                        /*this.newItem.language_id = response.data.order.language_id;
                        this.newItem.is_main_order = response.data.order.is_main_order;
                        this.newItem.estatus = response.data.order.estatus;
                        this.newItem.list_order = response.data.order.list_order;*/

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
                    axios.get('orders/changestatus/'+id)
                        .then(response => {
                            this.getListItems(this.orderId);
                            toastr.success('Item update Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        });
                },
                enviaCostos(){
                    $('.actPre').show();
                    $('.actPreBtn').attr('disabled', 'disabled');
                    $('.cargaEspera').show();
                    axios.post('orders/enviacostos', { order: this.order, productos_nuevos: this.addProducts })
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
                    axios.post('orders/guardaorden', { order: this.order, orderProducts: this.orderProducts, productos_nuevos: this.addProducts })
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

                getCleanForm(order_id)
                {
                    this.newItem = {'order': '','is_main_order':'','language_id': '', 'estatus': '','list_order':''};
                    if(order_id == 1){
                        this.createModal = false;
                    }else if(order_id == 2){
                        this.updateModal = false;
                    }
                },

                createItem() {
                    axios.post('orders', this.$data.newItem)
                        .then(response => {
                        this.newItem = {'order': '','is_main_order':'','language_id': '', 'estatus': '','list_order':''};
                        this.getListItems();
                        this.createModal = false;
                        toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                    });
                },

                updateItem (){
                    axios.put('orders/'+this.idData, this.$data.newItem)
                        .then(response => {
                        this.newItem = {'order': '','is_main_order':'','language_id': '', 'estatus': '','list_order':''};
                        this.getListItems();
                        this.updateModal = false;
                        toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                            this.errors.record(error.response.data.errors);
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
