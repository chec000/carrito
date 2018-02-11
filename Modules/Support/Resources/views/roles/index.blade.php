@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.role.bc_home")</a></li>
        <li class="active"><i class="fa fa-star" aria-hidden="true"></i> @lang("support.role.bc_roles")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-star" aria-hidden="true"></i> @lang("support.role.title") <small>@lang("support.role.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("roles.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.role.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                    <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.role.btn_add')</h3>
                    <div slot="body">
                        <form method="POST" id="createForm"
                              @submit.prevent="createItem"
                              @keydown="errors.clear($event.target.name)">
                            {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 float-left">
                            <div class="form-group">
                                <label for="alias">@lang("support.role.input.alias")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-users"></span></div>
                                    <input type="text" name="alias" class="form-control input-crud" id="alias"
                                           placeholder="@lang("support.role.input.alias")" v-model="newItem.alias" autofocus>
                                </div>
                                <span v-text="errors.get('alias')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="name">@lang("support.role.input.name")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                    <input type="text" name="name" class="form-control input-crud" id="name"
                                           placeholder="@lang("support.role.input.name")" v-model="newItem.name" autofocus>
                                </div>
                                <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="description">@lang("support.role.input.description")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-users"></span></div>
                                    <textarea name="description" class="form-control input-crud" id="description"
                                              placeholder="@lang("support.role.input.description")" v-model="newItem.description" autofocus>
                                    </textarea>
                                </div>
                                <span v-text="errors.get('description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="language_id">@lang("support.role.input.language_id")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                                    <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                        <option value="">@lang("support.role.input.language_id")</option>
                                        <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                    </select>
                                </div>
                                <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="estatus">@lang("support.role.input.estatus")</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                    <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                        <option value="">@lang("support.role.input.estatus")</option>
                                        <option value="1">@lang("support.role.input.enable")</option>
                                        <option value="0">@lang("support.role.input.disable")</option>
                                    </select>
                                </div>
                                <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <button id="agregar" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.role.button.save")</button>
                            </div>

                            <div class="col-md-6 float-left">
                                <div class="form-group">
                                    <label for="permissions">@lang("support.role.input.permissions")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star" aria-hidden="true"></i></div>
                                        <select style="height: 350px" name="permissions" class="form-control input-crud-select"
                                                id="permissions" v-model="newItem.permissions" size="10" multiple >
                                            <optgroup v-for="(permissions, label) in permissions" v-bind:label="label">
                                                <option :value="per.id" v-for="per in permissions">@{{ per.title }}</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('permissions')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                        </div>
                        </form>
                    </div>
                    <div slot="footer">
                        <button type="submit" class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.role.button.save")</button>
                        <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.role.button.cancel")</button>
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
                       @if(Auth::user()->hasPermission("roles.update"))
                       @click = "getModalOn(props.row.id,'2')"
                       @endif
                       v-if="props.row.status == '1'"></i>


                    <i class="optIcon fa fa-power-off fa-2x" style="color: red;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("roles.update"))
                       @click = "getModalOn(props.row.id,'1')"
                       @endif
                       v-if="props.row.status == '0'"></i>


                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center">
                    @if(Auth::user()->hasPermission("roles.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.id,'4')"></i>
                    @endif
                    @if(Auth::user()->hasPermission("roles.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.id,'3')"></i>
                        @endif

                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
            <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.role.tit_edit')</h3>
            <div slot="body">
                <form method="POST" id="createForm"
                      @submit.prevent="updateItem"
                      @keydown="errors.clear($event.target.name)">
                    {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6 float-left">
                    <input type="hidden" name="id" id="id" v-model="newItem.id" />
                    <div class="form-group">
                        <label for="alias">@lang("support.role.input.alias")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-star"></span></div>
                            <input type="text" name="alias" class="form-control input-crud" id="alias"
                                   placeholder="@lang("support.role.input.alias")" v-model="newItem.alias" autofocus>
                        </div>
                        <span v-text="errors.get('alias')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang("support.role.input.name")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-star"></span></div>
                            <input type="text" name="name" class="form-control input-crud" id="name"
                                   placeholder="@lang("support.role.input.name")" v-model="newItem.name" autofocus>
                        </div>
                        <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="description">@lang("support.role.input.description")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-star"></span></div>
                            <textarea name="description" class="form-control input-crud" id="alias"
                                      placeholder="@lang("support.role.input.description")" v-model="newItem.description" autofocus>
                            </textarea>
                        </div>
                        <span v-text="errors.get('description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="language_id">@lang("support.role.input.language_id")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                            <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                <option value="">@lang("support.role.input.language_id")</option>
                                <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                            </select>
                        </div>
                        <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <div class="form-group">
                        <label for="estatus">@lang("support.role.input.estatus")</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                            <select name="estatus" class="form-control input-crud-select" id="estatus" v-model="newItem.estatus">
                                <option value="">@lang("support.role.input.estatus")</option>
                                <option value="1">@lang("support.role.input.enable")</option>
                                <option value="0">@lang("support.role.input.disable")</option>
                            </select>
                        </div>
                        <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                    </div>
                    <button id="editar" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.role.button.save")</button>

                        </div>


                    <div class="col-md-6 float-left">
                        <div class="form-group">
                            <label for="permissions">@lang("support.role.input.permissions")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-star" aria-hidden="true"></i></div>
                                <select style="height: 350px" name="permissions" class="form-control input-crud-select"
                                        id="permissions" v-model="newItem.permissions" size="10" multiple >
                                    <optgroup v-for="(permissions, label) in permissions" v-bind:label="label">
                                        <option :value="per.id" v-for="per in permissions">@{{ per.title }}</option>
                                    </optgroup>
                                </select>
                            </div>
                            <span v-text="errors.get('permissions')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                    </div>



                    </div>
                        </form>
            </div>
            <div slot="footer">
                <button type="submit" class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.role.button.save")</button>
                <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.role.button.cancel")</button>
            </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
            <h3 slot="header" class="text-left">
                <i class="fa fa-star" aria-hidden="true"></i> @lang("support.role.tit_delete")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.role.dialog_delete")<small> <br />@lang("support.role.subdialog_delete")</small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                    @lang("support.role.button.no")
                </button>
                <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.role.button.yes")</button>
            </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

            <h3 slot="header" class="text-left">
                <i class="fa fa-star" aria-hidden="true"></i> @lang("support.role.tit_enable")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.role.dialog_enable")<small> <br />@lang("support.role.subdialog_enable") </small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                    @lang("support.role.button.no")
                </button>
                <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                    @lang("support.role.button.yes")
                </button>
            </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
            <h3 slot="header" class="text-left">
                <i class="fa fa-star" aria-hidden="true"></i> @lang("support.role.tit_disable")
            </h3>
            <div slot="body" class="text-center">
                <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                <br /><br />
                <h2>@lang("support.role.dialog_disable")<small> <br />@lang("support.role.subdialog_disable") </small></h2>
            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                    @lang("support.role.button.no")
                </button>
                <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                    @lang("support.role.button.yes")
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
                        {{--<a class="close-modal" @click="$emit('close')" ></a>--}}
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
            $( ".VueTables__search label" ).text('@lang("support.role.table.search")');
            $( ".VueTables__limit label" ).text('@lang("support.role.table.records")');
            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.testimony.table.placeholder")' );
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
                newItem: {'name': '','alias': '','description':'','language_id': '', 'estatus': ''},
                columns: ['id', 'language_id', 'name', 'alias','description','activate','option'],
                data: [],
                dlang: [],
                permissions: [],
                options: {
                    headings: {
                        id: 'Id',
                        language_id: '@lang("support.role.input.language_id")',
                        name: '@lang("support.role.input.name")',
                        alias:'@lang("support.role.input.alias")',
                        description : '@lang("support.role.input.description")',
                        //created_at: 'Fecha de Creación',
                        activate: '@lang("support.role.input.enable") / @lang("support.role.input.disable")',
                        option: '@lang("support.role.input.actions")'
                    },
                    sortable: ['id', 'language_id','name'],
                    filterable: ['id', 'language_id','name']
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
                    axios.get('roles/1').then(response => {
                        this.dlang = response.data.language;
                        this.permissions = response.data.permission;
                        this.getNameId(response.data.role);
                    });
                },
                getNameId(items){
                    if(items.length > 0) {
                         for (var i=0; i<items.length; i++) {
                            items[i].language_id = items[i].language.short_name;
                            this.data = items;
                        }
                    }
                    else
                        this.data = [];
                },

                getDataEdit(){
                    axios.get('roles/'+this.idData+'/edit').then(response => {

                        this.newItem.name = response.data.role.name;
                        this.newItem.alias = response.data.role.alias;
                        this.newItem.description = response.data.role.description;
                        this.newItem.language_id = response.data.role.language_id;
                        this.newItem.estatus = response.data.role.status;
                        this.newItem.id = response.data.role.id;
                        this.newItem.permissions = response.data.permissions;
                    });
                },

                getCleanForm(id){
                    this.newItem = {'permissions': '', 'name': '','alias': '','description':'', 'language_id': '', 'status': ''};

                    this.errors = new Errors();

                    if(id == 1){
                        this.createModal = false;
                    }else if(id == 2){
                        this.updateModal = false;
                    }

                },

                createItem() {
                    axios.post('roles', this.$data.newItem)
                        .then(response => {
                            this.newItem = {'name': '','alias':'','description':'','language_id': '', 'status': ''};
                            this.getListItems();
                            this.createModal = false;
                            toastr.success('@lang("support.role.item_saved")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error => {
                            this.errors.record(error.response.data.errors);
                        });
                },

                updateItem (){
                    axios.put('roles/'+this.idData, this.$data.newItem)
                        .then(response => {
                            this.newItem = {'id': '', 'name': '','alias':'','description':'','language_id': '', 'estatus': ''};
                            this.getListItems();
                            this.updateModal = false;
                            toastr.success('@lang("support.role.item_updated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error => {
                            this.errors.record(error.response.data.errors);
                        });
                },

                deleteItem(id) {
                    this.deleteModal = false;
                    axios.delete('roles/'+id).then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.role.item_deleted")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                onItem(id) {
                    this.enableModal = false;
                    axios.get('roles/'+id+'/on').then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.role.item_activated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                offItem(id) {
                    this.disableModal = false;
                    axios.get('roles/'+id+'/off').then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.role.item_deactivated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
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