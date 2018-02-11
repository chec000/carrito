@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.pool.bc_home")</a></li>
        <li class="active"><i class="fa fa-upload" aria-hidden="true"></i> @lang("support.pool.bc_pools")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-upload" aria-hidden="true"></i> @lang("support.pool.title") <small>@lang("support.pool.subtitle")</small></h2>
                </div>

                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("pools.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.pool.btn_add')
                    </button>
                    @endif
                        @if(Auth::user()->hasPermission("pools.loadcsv"))
                            <button class="btn btn-crud" id="show-modal" @click="loadModal = true">
                                <i class="fa fa-file" aria-hidden="true"></i> @lang('support.pool.btn_load')
                            </button>
                        @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                    <h3 slot="header"><i class="fa fa-upload" aria-hidden="true"></i> @lang('support.pool.btn_add')</h3>
                    <div slot="body">
                        <form method="POST" id="createForm"
                              @submit.prevent="createItem"
                              @keydown="errors.clear($event.target.name)">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="eo_number">@lang("support.pool.input.name")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-upload"></span></div>
                                    <input type="text" name="eo_number" class="form-control input-crud" id="eo_number"
                                           placeholder="@lang("support.pool.input.eo_number")" v-model="newItem.eo_number" autofocus>
                                </div>
                                <span v-text="errors.get('eo_number')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="eo_name">@lang("support.pool.input.eo_name")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-users"></span></div>
                                    <input type="text" name="eo_name" class="form-control input-crud" id="eo_name"
                                           placeholder="@lang("support.pool.input.eo_name")" v-model="newItem.eo_name" autofocus>
                                </div>
                                <span v-text="errors.get('eo_name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>


                            <div class="form-group">
                                <label for="eo_email">@lang("support.pool.input.eo_email")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-users"></span></div>
                                    <input type="email" name="eo_email" class="form-control input-crud" id="eo_email"
                                           placeholder="@lang("support.pool.input.eo_email")" v-model="newItem.eo_email" autofocus>
                                </div>
                                <span v-text="errors.get('eo_email')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                           
                           

                            <button id="agregar" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.pool.button.save")</button>
                        </form>
                    </div>
                    <div slot="footer">
                        <button type="submit" class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.pool.button.save")</button>
                        <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.pool.button.cancel")</button>
                    </div>
                    </modal>
                </div>
                <div class="col-md-12">
                    <hr style="margin-top: 0"/>
                </div>
            </div>

            <v-client-table :columns="columns" :data="data" :options="options">
                <div slot="activate"  slot-scope="props" class="text-center">

                    <i class="optIcon fa fa-check fa-2x" style="color: green;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Activo"
                       @if(Auth::user()->hasPermission("pools.update"))
                       @click = "getModalOn(props.row.id,'2')"
                       v-if="props.row.used == '1'"></i>
                       @endif
                    <i class="optIcon fa fa-close fa-2x" style="color: red;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("pools.update"))
                       @click = "getModalOn(props.row.id,'1')"
                       v-if="props.row.used == '0'"></i>
                       @endif

                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center">
                    @if(Auth::user()->hasPermission("pools.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.id,'4')"></i>
                    @endif
                        @if(Auth::user()->hasPermission("pools.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.id,'3')"></i>
                            @endif

                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
            <h3 slot="header"><i class="fa fa-upload" aria-hidden="true"></i> @lang('support.pool.upd_pool')</h3>
            <div slot="body">
                <form method="POST" id="createForm"
                      @submit.prevent="updateItem"
                      @keydown="errors.clear($event.target.name)">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="eo_number">@lang("support.pool.input.name")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-upload"></span></div>
                            <input type="text" name="eo_number" class="form-control input-crud" id="eo_number"
                                   placeholder="@lang("support.pool.input.name")" v-model="newItem.eo_number" autofocus>
                        </div>
                        <span v-text="errors.get('eo_number')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="eo_name">@lang("support.pool.input.eo_name")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-upload"></span></div>
                            <input type="text" name="eo_name" class="form-control input-crud" id="eo_name"
                                   placeholder="@lang("support.pool.input.eo_name")" v-model="newItem.eo_name" autofocus>
                        </div>
                        <span v-text="errors.get('eo_name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>

                    <div class="form-group">
                        <label for="eo_email">@lang("support.pool.input.eo_email")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-upload"></span></div>
                            <input type="email" name="eo_email" class="form-control input-crud" id="eo_email"
                                   placeholder="@lang("support.pool.input.eo_email")" v-model="newItem.eo_email" autofocus>
                        </div>
                        <span v-text="errors.get('eo_email')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    
                    <button id="editar" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.pool.button.save")</button>
                </form>
            </div>
            <div slot="footer">
                <button type="submit" class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.pool.button.save")</button>
                <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.pool.button.cancel")</button>
            </div>
            </modal>


            {{-- Modal Load CSV --}}
            <modal v-if="loadModal" @close="loadModal = false" class="text-left">
            <h3 slot="header"><i class="fa fa-upload" aria-hidden="true"></i> @lang('support.pool.load_pool')</h3>
            <div slot="body">
                <div id="message">

                </div>
                <form method="POST" id="createForm"
                      @submit.prevent="loadItem"
                      @keydown="errors.clear($event.target.name)">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="csvPool">@lang("support.pool.csvPool")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-upload"></span></div>
                            <input type="file" name="csvPool" class="form-control input-crud" id="csvPool"
                                   placeholder="@lang("support.pool.input.name")" v-model="newItem.csvPool" autofocus>
                        </div>
                        <span v-text="errors.get('csvPool')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>

                    <p class="help-block">
                    {{ trans('support.pool.indications_csv') }}
                    <ol>
                        <li>{{ trans('support.pool.indications_csv1') }} <a target="_blank" href="{{ asset('files/pool.csv') }}">{{ trans('support.pool.indications_csv_link') }}</a></li>
                        <li>{{ trans('support.pool.indications_csv2') }}</li>
                        <li>{{ trans('support.pool.indications_csv3') }}</li>
                    </ol>
                    </p>

                    <button id="load" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.pool.button.load")</button>
                </form>
            </div>
            <div slot="footer">
                <button type="submit" class="btn btn-crud pull-right" @click="sendForm(5)">@lang("support.pool.button.load")</button>
                <button type="button" @click="getCleanForm(5)" class="btn btn-crud-cancel pull-right">@lang("support.pool.button.cancel")</button>
            </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
            <h3 slot="header" class="text-left">
                <i class="fa fa-upload" aria-hidden="true"></i> @lang("support.pool.tit_delete")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.pool.dialog_delete")<small> <br />@lang("support.pool.subdialog_delete")</small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                    @lang("support.pool.button.no")
                </button>
                <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.pool.button.yes")</button>
            </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

            <h3 slot="header" class="text-left">
                <i class="fa fa-upload" aria-hidden="true"></i> @lang("support.pool.tit_enable")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.pool.dialog_enable")<small> <br />@lang("support.pool.subdialog_enable") </small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                    @lang("support.pool.button.no")
                </button>
                <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                    @lang("support.pool.button.yes")
                </button>
            </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
            <h3 slot="header" class="text-left">
                <i class="fa fa-upload" aria-hidden="true"></i> @lang("support.pool.tit_disable")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.pool.dialog_disable")<small> <br />@lang("support.pool.subdialog_disable") </small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                    @lang("support.pool.button.no")
                </button>
                <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                    @lang("support.pool.button.yes")
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
                    <div class="modal-container">
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

    <script>

        $(function() {
            $( ".VueTables__search label" ).text('@lang("support.pool.table.search")');
            $( ".VueTables__limit label" ).text('@lang("support.pool.table.records")');
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
                loadModal:false,
                errors: new Errors(),
                newItem: {'eo_number': '','eo_name': '', 'eo_email': ''},
                columns: ['id','eo_number','eo_name','eo_email','activate','option'],
                data: [],
                dlang: [],
                options: {
                    headings: {

                        id: 'Id',
                        eo_number: '@lang("support.pool.input.eo_number")',
                        eo_name:'@lang("support.pool.input.eo_name")',
                        eo_email: '@lang("support.pool.input.eo_email")',
                        activate: '@lang("support.pool.input.enable") / @lang("support.pool.input.disabled")',
                        option: '@lang("support.pool.input.actions")'
                    },
                    sortable: ['id','eo_number','eo_name'],
                    filterable: ['id','eo_number','eo_name']
                }
            },
            created() {
                this.getListItems();
            },

            methods: {
                getModalOn(id,tipo){

                    this.idData = id;
                    if(tipo == '1'){
                        this.enableModal = true;
                    }else if(tipo == '2'){
                        this.disableModal = true;
                    }else if(tipo == '3'){
                        this.deleteModal = true;
                    }else if(tipo == '4'){
                        this.getDataEdit();
                        this.updateModal = true;
                    }else if(tipo == '5'){
                        this.loadModal = true;
                    }
                },

                getListItems() {
                    axios.get('pools/1').then(response => {
                        this.dlang = response.data.pool;
                        //console.log(response.data);
                        this.getNameId(response.data.pool);
                });
                },
                getNameId(items){

                    for (var i=0; i<items.length; i++) {
                        //items[i].id = items[i].eo_name;
                        this.data = items;
                    }
                },

                getDataEdit(){
                    axios.get('pools/'+this.idData+'/edit').then(response => {

                    this.newItem.eo_number = response.data.eo_number;
                    this.newItem.eo_name = response.data.eo_name;
                    this.newItem.email = response.data.eo_email;

                });
                },

                getCleanForm(id){
                    this.newItem = {'eo_number': '','eo_name': '','estatus': ''};
                    if(id == 1){
                        this.createModal = false;
                    }else if(id == 2){
                        this.updateModal = false;
                    }else if(id == 5){
                        this.loadModal = false;
                    }

                },

                createItem() {
                    axios.post('pools', this.$data.newItem)
                        .then(response => {
                        this.newItem = {'eo_number': '','eo_name':'', 'eo_email': ''};
                    this.getListItems();
                    this.createModal = false;
                    toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                })
                .catch(error => {
                        this.errors.record(error.response.data.errors);
                });
                },

                updateItem (){
                    axios.put('pools/'+this.idData, this.$data.newItem)
                        .then(response => {
                        this.newItem = {'eo_number': '','eo_name':'', 'eo_email': ''};
                    this.getListItems();
                    this.updateModal = false;
                    toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                })
                .catch(error => {
                        this.errors.record(error.response.data.errors);
                });
                },
                loadItem(){

                    const formData = new FormData();


                    if(document.getElementById('csvPool').files[0] !=  undefined)
                        formData.append( 'csvPool', document.getElementById('csvPool').files[0]);

                       axios.post('pools/load', formData)
                        .then(response => {



                            if(response.data.success == false) {
                                this.getListItems();
                                $("#message").html(response.data.message);
                                toastr.error('The pool can not be loaded.', 'Error Alert', {
                                    "closeButton": true,
                                    timeOut: 5000
                                });

                            }else{
                                this.getListItems();
                                $("#message").html(response.data.message);
                                toastr.success('The pool loaded succesfully.', 'Error Alert', {
                                    "closeButton": true,
                                    timeOut: 5000
                                });
                            }
                        })
                        .catch(error => {
                            this.errors.record(error.response.data.errors);
                        });




                },

                deleteItem(id) {
                    this.deleteModal = false;
                    axios.delete('pools/'+id).then(response => {
                        this.getListItems();
                    toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                });
                },
                onItem(id) {

                    this.enableModal = false;
                    axios.get('pools/'+id+'/on').then(response => {
                        this.getListItems();
                    toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                });
                },
                offItem(id) {

                    this.disableModal = false;
                    axios.get('pools/'+id+'/off').then(response => {
                        this.getListItems();
                    toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                });
                },
                sendForm(tipo){
                    if(tipo == 1){
                        $("#agregar").click();
                    }
                    else if(tipo == 2){
                        $("#editar").click();
                    }else if(tipo == 5){
                        $("#load").click();

                    }

                }
            }
        });



    </script>


@endsection