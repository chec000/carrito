@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.country.bc_home")</a></li>
        <li class="active"><i class="fa fa-globe" aria-hidden="true"></i> @lang("support.country.bc_countrys")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-globe" aria-hidden="true"></i> @lang("support.country.title") <small>@lang("support.country.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("countries.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.country.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                    <h3 slot="header"><i class="fa fa-globe" aria-hidden="true"></i> @lang('support.country.btn_add')</h3>
                    <div slot="body">
                        <form method="POST" id="createForm"
                              @submit.prevent="createItem"
                              @keydown="errors.clear($event.target.name)">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="nombre">@lang("support.country.input.name")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-globe"></span></div>
                                    <input type="text" name="nombre" class="form-control input-crud" id="nombre"
                                           placeholder="@lang("support.country.input.name")" v-model="newItem.nombre" autofocus>
                                </div>
                                <span v-text="errors.get('nombre')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="short_name">@lang("support.country.input.short_name")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-users"></span></div>
                                    <input type="text" name="short_name" class="form-control input-crud" id="short_name"
                                           placeholder="@lang("support.country.input.short_name")" v-model="newItem.short_name" autofocus>
                                </div>
                                <span v-text="errors.get('short_name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                           
                           
                            <div class="form-group">
                                <label for="estatus">@lang("support.country.input.estatus")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-power-off" aria-hidden="true"></i></div>
                                    <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                        <option value="">@lang("support.country.input.estatus")</option>
                                        <option value="1">@lang("support.country.input.enable")</option>
                                        <option value="0">@lang("support.country.input.disable")</option>
                                    </select>
                                </div>
                                <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <button id="agregar" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.country.button.save")</button>
                        </form>
                    </div>
                    <div slot="footer">
                        <button type="submit" class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.country.button.save")</button>
                        <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.country.button.cancel")</button>
                    </div>
                    </modal>
                </div>
                <div class="col-md-12">
                    <hr style="margin-top: 0"/>
                </div>
            </div>

            <v-client-table :columns="columns" :data="data" :options="options">
                <div slot="activate"  slot-scope="props" class="text-center">

                    <i class="optIcon fa fa-power-off fa-2x" style="color: green;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Activo"
                       @if(Auth::user()->hasPermission("countries.update"))
                       @click = "getModalOn(props.row.country_id,'2')"
                       @endif
                       v-if="props.row.estatus == '1'"></i>


                    <i class="optIcon fa fa-power-off fa-2x" style="color: red;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("countries.update"))
                       @click = "getModalOn(props.row.country_id,'1')"
                       @endif
                       v-if="props.row.estatus == '0'"></i>


                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center">
                    @if(Auth::user()->hasPermission("countries.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.country_id,'4')"></i>
                    @endif
                    @if(Auth::user()->hasPermission("countries.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.country_id,'3')"></i>
                    @endif
                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
            <h3 slot="header"><i class="fa fa-globe" aria-hidden="true"></i> @lang('support.country.upd_country')</h3>
            <div slot="body">
                <form method="POST" id="createForm"
                      @submit.prevent="updateItem"
                      @keydown="errors.clear($event.target.name)">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="nombre">@lang("support.country.input.name")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-globe"></span></div>
                            <input type="text" name="nombre" class="form-control input-crud" id="nombre"
                                   placeholder="@lang("support.country.input.name")" v-model="newItem.nombre" autofocus>
                        </div>
                        <span v-text="errors.get('nombre')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="short_name">@lang("support.country.input.short_name")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-users"></span></div>
                            <input type="text" name="short_name" class="form-control input-crud" id="short_name"
                                   placeholder="@lang("support.country.input.short_name")" v-model="newItem.short_name" autofocus>
                        </div>
                        <span v-text="errors.get('short_name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>


                    <div class="form-group">
                        <label for="estatus">@lang("support.country.input.estatus")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-power-off" aria-hidden="true"></i></div>
                            <select name="estatus" class="form-control input-crud-select" id="estatus" v-model="newItem.estatus">
                                <option value="">@lang("support.country.input.estatus")</option>
                                <option value="1">@lang("support.country.input.enable")</option>
                                <option value="0">@lang("support.country.input.disable")</option>
                            </select>
                        </div>
                        <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <button id="editar" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.country.button.save")</button>
                </form>
            </div>
            <div slot="footer">
                <button type="submit" class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.country.button.save")</button>
                <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.country.button.cancel")</button>
            </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
            <h3 slot="header" class="text-left">
                <i class="fa fa-globe" aria-hidden="true"></i> @lang("support.country.tit_delete")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.country.dialog_delete")<small> <br />@lang("support.country.subdialog_delete")</small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                    @lang("support.country.button.no")
                </button>
                <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.country.button.yes")</button>
            </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

            <h3 slot="header" class="text-left">
                <i class="fa fa-globe" aria-hidden="true"></i> @lang("support.country.tit_enable")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.country.dialog_enable")<small> <br />@lang("support.country.subdialog_enable") </small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                    @lang("support.country.button.no")
                </button>
                <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                    @lang("support.country.button.yes")
                </button>
            </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
            <h3 slot="header" class="text-left">
                <i class="fa fa-globe" aria-hidden="true"></i> @lang("support.country.tit_disable")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.country.dialog_disable")<small> <br />@lang("support.country.subdialog_disable") </small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                    @lang("support.country.button.no")
                </button>
                <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                    @lang("support.country.button.yes")
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
                        {{-- <a class="close-modal" @click="$emit('close')" ></a> --}}
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
            $( ".VueTables__search label" ).text('@lang("support.country.table.search")');
            $( ".VueTables__limit label" ).text('@lang("support.country.table.records")');
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
                errors: new Errors(),
                newItem: {'nombre': '','short_name': '', 'estatus': ''},
                columns: ['country_id','name','short_name','created_at','activate','option'],
                data: [],
                dlang: [],
                options: {
                    headings: {

                        country_id: 'Id',
                        name: '@lang("support.country.input.name")',
                        short_name:'@lang("support.country.input.short_name")',
                        created_at: '@lang("support.date_created")',
                        activate: '@lang("support.country.input.enable") / @lang("support.country.input.disable")',
                        option: '@lang("support.country.input.actions")'
                    },
                    sortable: ['country_id','name','created_at'],
                    filterable: ['country_id','name','created_at']
                }
            },
            created() {
                this.getListItems();
            },

            methods: {
                getModalOn(country_id,tipo){

                    this.idData = country_id;
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

                getListItems() {
                    axios.get('countries/1').then(response => {
                        this.dlang = response.data.country;
                        //console.log(response.data);
                        this.getNameId(response.data.country);
                });
                },
                getNameId(items){

                    for (var i=0; i<items.length; i++) {
                        //items[i].country_id = items[i].short_name;
                        this.data = items;
                    }
                },

                getDataEdit(){
                    axios.get('countries/'+this.idData+'/edit').then(response => {

                    this.newItem.nombre = response.data.name;
                    this.newItem.short_name = response.data.short_name;
                    this.newItem.estatus = response.data.estatus;

                });
                },

                getCleanForm(country_id){
                    this.newItem = {'nombre': '','short_name': '','estatus': ''};
                    if(country_id == 1){
                        this.createModal = false;
                    }else if(country_id == 2){
                        this.updateModal = false;
                    }

                    this.errors = new Errors();

                },

                createItem() {
                    axios.post('countries', this.$data.newItem)
                        .then(response => {
                        this.newItem = {'nombre': '','short_name':'', 'estatus': ''};
                    this.getListItems();
                    this.createModal = false;
                    toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                })
                .catch(error => {
                        this.errors.record(error.response.data.errors);
                });
                },

                updateItem (){
                    axios.put('countries/'+this.idData, this.$data.newItem)
                        .then(response => {
                        this.newItem = {'nombre': '','short_name':'', 'estatus': ''};
                    this.getListItems();
                    this.updateModal = false;
                    toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                })
                .catch(error => {
                        this.errors.record(error.response.data.errors);
                });
                },

                deleteItem(country_id) {
                    this.deleteModal = false;
                    axios.delete('countries/'+country_id).then(response => {
                        this.getListItems();
                    toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                });
                },
                onItem(country_id) {

                    this.enableModal = false;
                    axios.get('countries/'+country_id+'/on').then(response => {
                        this.getListItems();
                    toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                });
                },
                offItem(country_id) {

                    this.disableModal = false;
                    axios.get('countries/'+country_id+'/off').then(response => {
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
                    }

                    ;                }
            }
        });



    </script>


@endsection