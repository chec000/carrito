@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.permission.bc_home")</a></li>
        <li class="active"><i class="fa fa-star" aria-hidden="true"></i> @lang("support.permission.bc_permissions")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-star" aria-hidden="true"></i> @lang("support.permission.title") <small>@lang("support.permission.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("permissions.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.permission.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                    <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.permission.btn_add')</h3>
                    <div slot="body">
                        <form method="POST" id="createForm"
                              @submit.prevent="createItem"
                              @keydown="errors.clear($event.target.name)">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="nombre">@lang("support.permission.input.name")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                    <input type="text" name="nombre" class="form-control input-crud" id="nombre"
                                           placeholder="@lang("support.permission.input.name")" v-model="newItem.nombre" autofocus>
                                </div>
                                <span v-text="errors.get('nombre')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="alias">@lang("support.permission.input.alias")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-users"></span></div>
                                    <input type="text" name="alias" class="form-control input-crud" id="alias"
                                           placeholder="@lang("support.permission.input.alias")" v-model="newItem.alias" autofocus>
                                </div>
                                <span v-text="errors.get('alias')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="description">@lang("support.permission.input.description")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-users"></span></div>
                                    <textarea name="description" class="form-control input-crud" id="description"
                                           placeholder="@lang("support.permission.input.description")" v-model="newItem.description" autofocus>
                                    </textarea>
                                </div>
                                <span v-text="errors.get('alias')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="language_id">@lang("support.permission.input.language_id")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><<i class="fa fa-language" aria-hidden="true"></i></div>
                                    <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                        <option value="">@lang("support.permission.input.language_id")</option>
                                        <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                    </select>
                                </div>
                                <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="estatus">@lang("support.permission.input.estatus")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                    <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                        <option value="">@lang("support.permission.input.estatus")</option>
                                        <option value="1">@lang("support.permission.input.enable")</option>
                                        <option value="0">@lang("support.permission.input.disable")</option>
                                    </select>
                                </div>
                                <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <button id="agregar" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.permission.button.save")</button>
                        </form>
                    </div>
                    <div slot="footer">
                        <button type="submit" class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.permission.button.save")</button>
                        <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.permission.button.cancel")</button>
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
                       @if(Auth::user()->hasPermission("permissions.status"))
                       @click = "getModalOn(props.row.id,'2')"
                       @endif
                       v-if="props.row.status == '1'"></i>


                    <i class="optIcon fa fa-power-off fa-2x" style="color: red;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("permissions.status"))
                       @click = "getModalOn(props.row.id,'1')"
                       @endif
                       v-if="props.row.status == '0'"></i>


                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center">
                    @if(Auth::user()->hasPermission("permissions.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.id,'4')"></i>
                    @endif
                        @if(Auth::user()->hasPermission("permissions.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.id,'3')"></i>
                            @endif

                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
            <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.permission.upd_permission')</h3>
            <div slot="body">
                <form method="POST" id="createForm"
                      @submit.prevent="updateItem"
                      @keydown="errors.clear($event.target.name)">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="nombre">@lang("support.permission.input.name")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-star"></span></div>
                            <input type="text" name="nombre" class="form-control input-crud" id="nombre"
                                   placeholder="@lang("support.permission.input.name")" v-model="newItem.nombre" autofocus>
                        </div>
                        <span v-text="errors.get('nombre')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="alias">@lang("support.permission.input.alias")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-star"></span></div>
                            <input type="text" name="alias" class="form-control input-crud" id="alias"
                                   placeholder="@lang("support.permission.input.alias")" v-model="newItem.alias" autofocus>
                        </div>
                        <span v-text="errors.get('alias')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="description">@lang("support.permission.input.description")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-star"></span></div>
                            <textarea name="description" class="form-control input-crud" id="alias"
                                   placeholder="@lang("support.permission.input.description")" v-model="newItem.description" autofocus>
                            </textarea>
                        </div>
                        <span v-text="errors.get('description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="language_id">@lang("support.permission.input.language_id")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><<i class="fa fa-language" aria-hidden="true"></i></div>
                            <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                <option value="">@lang("support.permission.input.language_id")</option>
                                <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                            </select>
                        </div>
                        <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="estatus">@lang("support.permission.input.estatus")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                            <select name="estatus" class="form-control input-crud-select" id="estatus" v-model="newItem.estatus">
                                <option value="">@lang("support.permission.input.estatus")</option>
                                <option value="1">@lang("support.permission.input.enable")</option>
                                <option value="0">@lang("support.permission.input.disable")</option>
                            </select>
                        </div>
                        <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <button id="editar" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.permission.button.save")</button>
                </form>
            </div>
            <div slot="footer">
                <button type="submit" class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.permission.button.save")</button>
                <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.permission.button.cancel")</button>
            </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
            <h3 slot="header" class="text-left">
                <i class="fa fa-star" aria-hidden="true"></i> @lang("support.permission.tit_delete")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.permission.dialog_delete")<small> <br />@lang("support.permission.subdialog_delete")</small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                    @lang("support.permission.button.no")
                </button>
                <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.permission.button.yes")</button>
            </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

            <h3 slot="header" class="text-left">
                <i class="fa fa-star" aria-hidden="true"></i> @lang("support.permission.tit_enable")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.permission.dialog_enable")<small> <br />@lang("support.permission.subdialog_enable") </small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                    @lang("support.permission.button.no")
                </button>
                <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                    @lang("support.permission.button.yes")
                </button>
            </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
            <h3 slot="header" class="text-left">
                <i class="fa fa-star" aria-hidden="true"></i> @lang("support.permission.tit_disable")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.permission.dialog_disable")<small> <br />@lang("support.permission.subdialog_disable") </small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                    @lang("support.permission.button.no")
                </button>
                <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                    @lang("support.permission.button.yes")
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
            $( ".VueTables__search label" ).text('@lang("support.permission.table.search")');
            $( ".VueTables__limit label" ).text('@lang("support.permission.table.records")');
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
                newItem: {'nombre': '','alias': '','description':'','language_id': '', 'estatus': ''},
                columns: ['id', 'language_id', 'title','alias','description','created_at','activate','option'],
                data: [],
                dlang: [],
                options: {
                    headings: {
                        id: 'Id',
                        language_id: '@lang("support.permission.input.language_id")',
                        title: '@lang("support.permission.input.name")',
                        alias:'@lang("support.permission.input.alias")',
                        description : '@lang("support.permission.input.description")',
                        created_at: '@lang("support.date_created")',
                        activate: '@lang("support.permission.input.enable") / @lang("support.permission.input.disable")',
                        option: '@lang("support.permission.input.actions")'
                    },
                    sortable: ['id', 'language_id','title','created_at'],
                    filterable: ['id', 'language_id','title','created_at']
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
                    }
                },

                getListItems() {
                    axios.get('permissions/1').then(response => {
                        this.dlang = response.data.language;
                        console.log(response.data);
                        this.getNameId(response.data.permission);
                });
                },
                getNameId(items){

                    for (var i=0; i<items.length; i++) {
                        items[i].language_id = items[i].language.short_name;
                        this.data = items;
                    }
                },

                getDataEdit(){
                    axios.get('permissions/'+this.idData+'/edit').then(response => {

                    this.newItem.nombre = response.data.title;
                    this.newItem.alias = response.data.alias;
                    this.newItem.description = response.data.description;
                    this.newItem.language_id = response.data.language_id;
                    this.newItem.estatus = response.data.status;

                });
                },

                getCleanForm(id){
                    this.newItem = {'nombre': '','alias': '','description':'', 'language_id': '', 'status': ''};
                    if(id == 1){
                        this.createModal = false;
                    }else if(id == 2){
                        this.updateModal = false;
                    }

                },

                createItem() {
                    axios.post('permissions', this.$data.newItem)
                        .then(response => {
                        this.newItem = {'nombre': '','alias':'','description':'','language_id': '', 'status': ''};
                    this.getListItems();
                    this.createModal = false;
                    toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                })
                .catch(error => {
                        this.errors.record(error.response.data.errors);
                });
                },

                updateItem (){
                    axios.put('permissions/'+this.idData, this.$data.newItem)
                        .then(response => {
                        this.newItem = {'nombre': '','alias':'','description':'','language_id': '', 'estatus': ''};
                    this.getListItems();
                    this.updateModal = false;
                    toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                })
                .catch(error => {
                        this.errors.record(error.response.data.errors);
                });
                },

                deleteItem(id) {
                    this.deleteModal = false;
                    axios.delete('permissions/'+id).then(response => {
                        this.getListItems();
                    toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                });
                },
                onItem(id) {
                    this.enableModal = false;
                    axios.get('permissions/'+id+'/on').then(response => {
                        this.getListItems();
                    toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                });
                },
                offItem(id) {
                    this.disableModal = false;
                    axios.get('permissions/'+id+'/off').then(response => {
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