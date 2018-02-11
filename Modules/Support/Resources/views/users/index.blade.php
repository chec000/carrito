@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.user.bc_home")</a></li>
        <li class="active"><i class="fa fa-id-card-o" aria-hidden="true"></i> @lang("support.user.bc_user")</li>
    </ul>

    <div id="app" class="page-content-wrap">
        <div class="marco-crud">
            <div class="row">
                <div class="col-xs-6">
                    <h2> <i class="fa fa-id-card-o" aria-hidden="true"></i> @lang("support.user.title") <small>@lang("support.user.subtitle")</small></h2>
                </div>
                <div class="col-xs-6">
                    @if(Auth::user()->hasPermission("users.create"))
                    <button class="btn btn-crud pull-right" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.user.btn_add')
                    </button>
                    @endif
                    {{-- Modal para crear usuario --}}
                    <modal v-if="createModal" @close="createModal = false">
                        <h3 slot="header"><i class="fa fa-id-card-o" aria-hidden="true"></i> @lang('support.user.btn_add')</h3>
                        <div slot="body">
                            <form method="POST" id="createForm" @submit.prevent="createItem"
                                  @keydown="errors.clear($event.target.name)">

                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="name">@lang("support.user.input.name")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                        <input type="text" name="name" class="form-control input-crud" id="name"
                                               placeholder="@lang("support.user.input.name")" v-model="newItem.name"  autofocus />
                                    </div>
                                    <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="email">@lang("support.user.input.email")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                                        <input type="email" name="email" class="form-control input-crud" id="email"
                                               placeholder="@lang("support.user.input.email")"  v-model="newItem.email" />
                                    </div>
                                    <span v-text="errors.get('email')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="username">@lang("support.user.input.username")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                        <input type="text" name="username" class="form-control input-crud" id="username"
                                               placeholder="@lang("support.user.input.username")"  v-model="newItem.username"  />
                                    </div>
                                    <span v-text="errors.get('username')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="password">@lang("support.user.input.password")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                        <input type="password" name="password" class="form-control input-crud" id="password"
                                               placeholder="@lang("support.user.input.password")"  v-model="newItem.password" >
                                    </div>
                                    <span v-text="errors.get('password')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm">@lang("support.user.input.password-confirm")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                        <input type="password" name="password_confirmation" class="form-control input-crud"
                                               id="password-confirm" placeholder="@lang("support.user.input.password-confirm")"  v-model="newItem.password_confirmation"  >
                                    </div>
                                    <span v-text="errors.get('password_confirmation')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="role_id">@lang("support.user.input.rol")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <select name="role_id" class="form-control input-crud-select" id="role_id" v-model="newItem.role_id">
                                            <option value="">@lang("support.user.input.rol")</option>
                                            <option :value="dR.id" v-for="dR in dRoles">@{{ dR.name }}</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('role_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="estatus">@lang("support.user.input.estatus")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <select name="estatus" class="form-control input-crud-select" id="estatus" v-model="newItem.estatus">
                                            <option value="">@lang("support.user.input.estatus")</option>
                                            <option value="1">@lang("support.user.input.enable")</option>
                                            <option value="0">@lang("support.user.input.disable")</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <button id="crear" type="submit" class="btn btn-crud pull-right" style="display: none">@lang("support.benefit.button.save")</button>

                            </form>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.benefit.button.save")</button>
                            <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.benefit.button.cancel")</button>
                        </div>
                    </modal>
                </div>
                <div class="col-md-12">
                    <hr style="margin-top: 0"/>
                </div>
            </div>

            <v-client-table :columns="columns" :data="data" :options="options">
                <div slot="activate"  slot-scope="props" class="text-center" >

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #0d8406;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Activo"
                       @if(Auth::user()->hasPermission("users.update"))
                       @click = "getModalOn(props.row.id,'2')"
                       @endif
                       v-if="props.row.estatus == '1'"></i>

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("users.update"))
                       @click = "getModalOn(props.row.id,'1')"
                       @endif
                       v-if="props.row.estatus == '0'"></i>

                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    @if(Auth::user()->hasPermission("users.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.id,'4')"></i>
                    @endif
                        @if(Auth::user()->hasPermission("users.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.id,'3')"></i>
                            @endif

                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
                <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.benefit.btn_add')</h3>
                <div slot="body">
                    <form method="POST" id="createForm"
                          @submit.prevent="updateItem"
                          @keydown="errors.clear($event.target.name)">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name">@lang("support.user.input.name")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                <input type="text" name="name" class="form-control input-crud" id="name"
                                       placeholder="@lang("support.user.input.name")" v-model="newItem.name"  autofocus />
                            </div>
                            <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>

                        <div class="form-group">
                            <label for="email">@lang("support.user.input.email")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                                <input type="email" name="email" class="form-control input-crud" id="email"
                                       placeholder="@lang("support.user.input.email")"  v-model="newItem.email" />
                            </div>
                            <span v-text="errors.get('email')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>

                        <div class="form-group">
                            <label for="username">@lang("support.user.input.username")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                <input type="text" name="username" class="form-control input-crud" id="username"
                                       placeholder="@lang("support.user.input.username")"  v-model="newItem.username"  />
                            </div>
                            <span v-text="errors.get('username')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>

                        <div class="form-group">
                            <label for="password">@lang("support.user.input.password")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                <input type="password" name="password" class="form-control input-crud" id="password"
                                       placeholder="@lang("support.user.input.password")"  v-model="newItem.password" >
                            </div>
                            <span v-text="errors.get('password')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">@lang("support.user.input.password-confirm")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></div>
                                <input type="password" name="password_confirmation" class="form-control input-crud"
                                       id="password-confirm" placeholder="@lang("support.user.input.password-confirm")"  v-model="newItem.password_confirmation"  >
                            </div>
                            <span v-text="errors.get('password_confirmation')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>

                        <div class="form-group">
                            <label for="role_id">@lang("support.user.input.rol")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                <select name="role_id" class="form-control input-crud-select" id="role_id" v-model="newItem.role_id">
                                    <option value="">@lang("support.user.input.rol")</option>
                                    <option :value="dR.id" v-for="dR in dRoles">@{{ dR.name }}</option>
                                </select>
                            </div>
                            <span v-text="errors.get('role_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>

                        <div class="form-group">
                            <label for="estatus">@lang("support.user.input.estatus")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                <select name="estatus" class="form-control input-crud-select" id="estatus" v-model="newItem.estatus">
                                    <option value="">@lang("support.user.input.estatus")</option>
                                    <option value="1">@lang("support.user.input.enable")</option>
                                    <option value="0">@lang("support.user.input.disable")</option>
                                </select>
                            </div>
                            <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <button id="editar" type="submit" class="btn btn-crud pull-right" style="display: none">@lang("support.benefit.button.save")</button>
                    </form>
                </div>
                <div slot="footer">
                    <button class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.benefit.button.save")</button>
                    <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.benefit.button.cancel")</button>
                </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.user.tit_delete")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.user.dialog_delete")<small> <br />@lang("support.user.subdialog_delete")</small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                        @lang("support.user.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.user.button.yes")</button>
                </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.user.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.user.dialog_enable")<small> <br />@lang("support.user.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        @lang("support.user.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        @lang("support.user.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.user.tit_disable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.user.dialog_disable")<small> <br />@lang("support.user.subdialog_disable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                        @lang("support.user.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                        @lang("support.user.button.yes")
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

    <script type="text/javascript">

        $(function() {
            $( ".VueTables__search label" ).text('@lang("support.benefit.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.benefit.table.search")');

            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.benefit.table.placeholder")' );
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
                newItem: {'name':'', 'email':'', 'username':'', 'password':'','password_confirmation':'', 'role_id': '', 'estatus': ''},
                columns: ['id', 'name', 'email','username','role_id','created_at','activate','option'],
                data: [],
                dRoles: [],
                options: {
                    headings: {
                        id: 'Id',
                        name: '@lang("support.user.input.name")',
                        email: '@lang("support.user.input.email")',
                        username: '@lang("support.user.input.username")',
                        role_id: '@lang("support.user.input.rol")',
                        created_at: '@lang("support.user.input.created_at")',
                        activate: 'Activar/Desactivar',
                        option: '@lang("support.user.input.actions")'
                    },
                    sortable: ['name', 'email','username','role_id'],
                    filterable: ['name', 'email','username','role_id']
                }
            },
            created() {
                this.getListItems();
            },

            methods: {
                sendForm(id)
                {
                    if (id == 1){
                        $("#crear").click();
                    }else if(id == 2){
                        $("#editar").click();
                    }
                },

                getModalOn(id,tipo)
                {
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

                getListItems()
                {
                    axios.get('users/1').then(response => {
                        this.dRoles = response.data.roles;
                        this.getNameId(response.data.usuarios);
                    });
                },

                getNameId(items)
                {

                    for (var i=0; i<items.length; i++) {
                        items[i].role_id = items[i].rol.name;
                        this.data = items;
                    }
                },

                getDataEdit()
                {
                    axios.get('users/'+this.idData+'/edit').then(response => {
                        this.newItem.name = response.data.name;
                        this.newItem.email = response.data.email;
                        this.newItem.username = response.data.username;
                        this.newItem.role_id = response.data.role_id;
                        this.newItem.estatus = response.data.estatus;
                    });
                },

                getCleanForm(id)
                {
                    this.newItem =  {'name':'', 'email':'', 'username':'', 'password':'','password_confirmation':'', 'role_id': '', 'estatus': ''};
                    this.errors = new Errors();
                    if(id == 1){
                        this.createModal = false;
                    }else if(id == 2){
                        this.updateModal = false;
                    }
                },

                createItem()
                {
                    axios.post('users', this.$data.newItem)
                        .then(response => {
                        this.getCleanForm(1);
                        this.getListItems();
                        toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                        toastr.error('No se genero el registro', 'Error Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                updateItem ()
                {
                    axios.put('users/'+this.idData, this.$data.newItem)
                        .then(response => {
                        this.newItem = {'benefit': '', 'language_id': '', 'estatus': ''};
                        this.getListItems();
                        this.updateModal = false;
                        toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                            this.errors.record(error.response.data.errors);
                    });
                },

                deleteItem(id)
                {
                    this.deleteModal = false;
                    axios.delete('users/'+id).then(response => {
                        this.getListItems();
                        toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                onItem(id)
                {
                    this.enableModal = false;
                    axios.get('users/'+id+'/on').then(response => {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                offItem(id)
                {
                    this.disableModal = false;
                    axios.get('users/'+id+'/off').then(response => {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                }
            }
        });

    </script>
@endsection
