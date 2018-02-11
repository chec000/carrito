@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> {{trans('support.inventorie.bc_home')}} </a></li>
        <li class="active"><i class="fa fa-star" aria-hidden="true"></i> {{trans('support.prod_warehouse')}}</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">

            <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> {{trans('support.inventorie.detail')}}</h3>
            <div slot="body">

                <!--products wharehouse details-->
                <div class="box-header with-border row">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="box-title">
                                Producto SKU : <?php echo $products->sku ?>
                            </h3>
                        </div>
                        <div class="col-md-8">

                                <form method="POST" class="form-inline pull-right"
                                      @submit.prevent="createItem"
                                      @keydown="errors.clear($event.target.name)">
                                    <div class="form-group">
                                        <label for="almacen">{{ trans('support.prod_warehouse') }}:</label>
                                        <select name="almacen" class="form-control input-sm" v-model="newItem.almacen">
                                            <option value="">{{ trans('support.prod_warehouse_sel') }}</option>
                                            <option :value="item.wharehouse_id" v-for="item in items.almacenes">@{{ item.name }}</option>
                                        </select>
                                        <br />
                                        <span v-text="errors.get('almacen')" class="error text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-xs">{{trans('support.prod_add_warehouse')}}</button>
                                    </div>

                                </form>

                        </div>
                    </div> <br>

                <div  class="box-body row">
                    <span id="idProduct" alt="<?php echo $products->product_id ?>"></span>
                    <table class="table table-bordered">
                        <tr>

                            <th>{{ trans('support.prod_warehouse') }}</th>
                            <th class="text-center">{{ trans('support.estatus') }}</th>
                            <th class="text-center">{{ trans('support.options') }}</th>
                        </tr>
                        <tr v-for="item in items.inventario">
                            <td>@{{ item.almacenes.name }}</td>
                            <td class="text-center">
                                <i class="fa fa-toggle-off"
                                   aria-hidden="true"
                                   data-toggle="tooltip"
                                   data-placement="left"
                                   title="Inactivo"
                                   v-if="item.estatus != '1'"
                                   @click="onItem(item)"
                                   style="color:red;cursor: pointer"></i>
                                <i class='fa fa-toggle-on'
                                   aria-hidden="true"
                                   data-toggle="tooltip"
                                   data-placement="left"
                                   title="Activo"
                                   v-if="item.estatus == '1'"
                                   @click="offItem(item)"
                                   style="color:green;cursor: pointer"></i>
                            </td>
                            <td id="actionList" class="text-center">
                                &nbsp;&nbsp;
                                <span class="glyphicon glyphicon-trash"
                                      aria-hidden="true"
                                      data-toggle="tooltip"
                                      data-placement="left"
                                      title="Eliminar"
                                      v-if="item.estatus != '-1'"
                                      @click="deleteItem(item)"
                                ></span>
                            </td>
                        </tr>
                    </table>
                </div>
                    <a href="{{asset('/support/products')}}"><button type="button" class="btn btn-success btn-xs">{{trans('support.prod_goback')}}</button></a>



                <!--Final productswarehouse details-->


            </div>








        </div>
    </div>


@stop

@section('js')

            <script type="text/javascript">
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
                }

                var app = new Vue({
                    el: '#app',
                    data: {
                        items: [],
                        idProduct: '',
                        errors: new Errors(),
                        newItem: {'almacen': ''}
                    },

                    created() {

                        this.idProduct = $( "#idProduct" ).attr( "alt" );
                        this.getListItems(this.idProduct);

                    },

                    methods: {

                        getListItems(idProduct) {
                            axios.get('../inventories', { params: { id: idProduct } })
                                .then(response => {
                                    this.items =  response.data;
                                });
                        },

                        createItem() {
                            this.$data.newItem.product_id = this.$data.idProduct
                            axios.post('../inventories', this.$data.newItem)
                                .then(response => {
                                    this.newItem = {'almacen': ''}
                                    this.getListItems(this.idProduct);
                                    $("#create-item").modal('hide');
                                    toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                                })
                                .catch(error => {
                                    this.errors.record(error.response.data);
                                });
                        },

                        deleteItem(item) {
                            //if (confirm('Seguro que quieres eliminar este almacen')) {
                            axios.delete('../inventories/'+item.product_wharehouse_id).then(response => {
                                this.getListItems(this.idProduct);
                                toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                            });
                            //}
                        },

                        onItem(item) {
                            //if (confirm('Seguro que quieres encender este almacen')) {
                            //almacenes/{id}/off
                            axios.get('../inventories/'+item.product_wharehouse_id+'/on').then(response => {
                                this.getListItems(this.idProduct);
                                toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                            });
                            //}
                        },

                        offItem(item) {
                            //if (confirm('Seguro que quieres apagar este almacen')) {
                            axios.get('../inventories/'+item.product_wharehouse_id+'/off').then(response => {
                                this.getListItems(this.idProduct);
                                toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                            });
                            //}
                        }

                    }

                });

            </script>


@endsection
