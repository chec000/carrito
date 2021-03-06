@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.state.bc_home")</a></li>
        <li class="active"><i class="fa fa-map" aria-hidden="true"></i> @lang("support.state.bc_state")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-map" aria-hidden="true"></i> @lang("support.state.title") <small>@lang("support.state.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("states.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.state.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                        <h3 slot="header"><i class="fa fa-map" aria-hidden="true"></i> @lang('support.state.btn_add')</h3>
                        <div slot="body">
                            <form method="POST" id="createForm"
                                  @submit.prevent="createItem"
                                  @keydown="errors.clear($event.target.name)">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="state">@lang("support.state.input.state")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-map"></span></div>
                                        <input type="text" name="state" class="form-control input-crud" id="state"
                                               placeholder="@lang("support.state.input.state")" v-model="newItem.state" autofocus>
                                    </div>
                                    <span v-text="errors.get('state')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="country_id">@lang("support.state.input.country_id")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><<i class="fa fa-globe" aria-hidden="true"></i></div>
                                        <select name="country_id" class="form-control input-crud-select" id="country_id" v-model="newItem.country_id" >
                                            <option value="">@lang("support.state.input.country_id")</option>
                                            <option :value="dL.country_id" v-for="dL in dCountry">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('country_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="estatus">@lang("support.state.input.estatus")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-power-off" aria-hidden="true"></i></div>
                                        <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                            <option value="">@lang("support.state.input.estatus")</option>
                                            <option value="1">@lang("support.state.input.enable")</option>
                                            <option value="0">@lang("support.state.input.disable")</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <button id="crear" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.state.button.save")</button>
                            </form>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.state.button.save")</button>
                            <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.state.button.cancel")</button>
                        </div>
                    </modal>
                </div>
                <div class="col-md-12">
                    <hr style="margin-top: 0"/>
                </div>
            </div>

            <v-client-table :columns="columns" :data="data" :options="options">
                <div slot="activate"  slot-scope="props" class="text-center">

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #0d8406;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Activo"
                       @if(Auth::user()->hasPermission("states.update"))
                       @click = "getModalOn(props.row.state_id,'2')"
                       @endif
                       v-if="props.row.estatus == '1'"></i>


                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("states.update"))
                       @click = "getModalOn(props.row.state_id,'1')"
                       @endif
                       v-if="props.row.estatus == '0'"></i>


                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    @if(Auth::user()->hasPermission("states.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.state_id,'4')"></i>
                    @endif
                        @if(Auth::user()->hasPermission("states.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.state_id,'3')"></i>
                    @endif

                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
                <h3 slot="header"><i class="fa fa-map" aria-hidden="true"></i> @lang('support.state.btn_add')</h3>
                <div slot="body">
                    <form method="POST" id="createForm"
                          @submit.prevent="updateItem"
                          @keydown="errors.clear($event.target.name)">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="state">@lang("support.state.input.state")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-map"></span></div>
                                <input type="text" name="state" class="form-control input-crud" id="state"
                                       placeholder="@lang("support.state.input.state")" v-model="newItem.state" autofocus>
                            </div>
                            <span v-text="errors.get('state')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="country_id">@lang("support.state.input.country_id")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><<i class="fa fa-globe" aria-hidden="true"></i></div>
                                <select name="country_id" class="form-control input-crud-select" id="country_id" v-model="newItem.country_id" >
                                    <option value="">@lang("support.state.input.country_id")</option>
                                    <option :value="dL.country_id" v-for="dL in dCountry">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                </select>
                            </div>
                            <span v-text="errors.get('country_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="estatus">@lang("support.state.input.estatus")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-power-off" aria-hidden="true"></i></div>
                                <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                    <option value="">@lang("support.state.input.estatus")</option>
                                    <option value="1">@lang("support.state.input.enable")</option>
                                    <option value="0">@lang("support.state.input.disable")</option>
                                </select>
                            </div>
                            <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <button id="editar" type="submit" class="btn btn-crud pull-right" style="display: none">@lang("support.state.button.save")</button>
                    </form>
                </div>
                <div slot="footer">
                    <button class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.state.button.save")</button>
                    <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.state.button.cancel")</button>
                </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-map" aria-hidden="true"></i> @lang("support.state.tit_delete")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.state.dialog_delete")<small> <br />@lang("support.state.subdialog_delete")</small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                        @lang("support.state.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.state.button.yes")</button>
                </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-map" aria-hidden="true"></i> @lang("support.state.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.state.dialog_enable")<small> <br />@lang("support.state.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        @lang("support.state.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        @lang("support.state.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-map" aria-hidden="true"></i> @lang("support.state.tit_disable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.state.dialog_disable")<small> <br />@lang("support.state.subdialog_disable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                        @lang("support.state.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                        @lang("support.state.button.yes")
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

    <script type="text/javascript">

        $(function() {
            $( ".VueTables__search label" ).text('@lang("support.state.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.state.table.search")');

            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.state.table.placeholder")' );
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
                newItem: {'state': '', 'country_id': '', 'estatus': ''},
                columns: ['state_id', 'country_id', 'state','created_at','activate','option'],
                data: [],
                dCountry: [],
                options: {
                    headings: {
                        state_id: 'Id',
                        country_id: '@lang("support.state.input.country_id")',
                        state: '@lang("support.state.input.state")',
                        created_at: '@lang("support.date_created")',
                        activate: '@lang("support.state.input.enable")/@lang("support.state.input.disable")',
                        option: '@lang("support.state.input.actions")'
                    },
                    sortable: ['state_id', 'country_id','state','created_at'],
                    filterable: ['state_id', 'country_id','state','created_at']
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
                    axios.get('states/1').then(response => {
                        this.dCountry = response.data.country;

                        if(response.data.state.length == 0){
                            this.data = [];
                        }else {
                            this.getNameId(response.data.state);
                        }
                    });
                },

                getNameId(items)
                {
                    for (var i=0; i<items.length; i++) {
                        items[i].country_id = items[i].country.short_name;
                        this.data = items;
                    }
                },

                getDataEdit()
                {
                    axios.get('states/'+this.idData+'/edit').then(response =>
                    {
                        this.newItem.state = response.data.state;
                        this.newItem.country_id = response.data.country_id;
                        this.newItem.estatus = response.data.estatus;

                    });
                },

                getCleanForm(id)
                {
                    this.newItem = {'state': '', 'country_id': '', 'estatus': ''};
                    if(id == 1){
                        this.createModal = false;
                    }else if(id == 2){
                        this.updateModal = false;
                    }
                    this.errors =  new Errors()
                },

                createItem() {
                    axios.post('states', this.$data.newItem)
                        .then(response => {
                            this.newItem = {'state': '', 'country_id': '', 'estatus': ''};
                            this.getListItems();
                            this.createModal = false;
                            toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error => {
                            this.errors.record(error.response.data.errors);
                        });
                },

                updateItem (){
                    axios.put('states/'+this.idData, this.$data.newItem)
                        .then(response => {
                            this.newItem = {'state': '', 'country_id': '', 'estatus': ''};
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
                    axios.delete('states/'+id).then(response => {
                        this.getListItems();
                        toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                onItem(id) {
                    this.enableModal = false;
                    axios.get('states/'+id+'/on').then(response => {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                offItem(id) {
                    this.disableModal = false;
                    axios.get('states/'+id+'/off').then(response => {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                }
            }
        });

    </script>


@endsection
