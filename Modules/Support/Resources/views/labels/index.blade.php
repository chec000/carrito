@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.label.bc_home")</a></li>
        <li class="active"><i class="fa fa-tags" aria-hidden="true"></i> @lang("support.label.bc_label")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
                <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-tags" aria-hidden="true"></i> @lang("support.label.title") <small>@lang("support.label.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("labels.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.label.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                        <h3 slot="header"><i class="fa fa-tags" aria-hidden="true"></i> @lang('support.label.btn_add')</h3>
                        <div slot="body">
                            <form method="POST" id="createForm"
                                  @submit.prevent="createItem"
                                  @keydown="errors.clear($event.target.name)"
                                  @change="errors.clear($event.target.name)">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name">@lang("support.label.input.name")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-tags"></span></div>
                                        <input type="text" name="name" class="form-control input-crud" id="name"
                                               placeholder="@lang("support.label.input.name")" v-model="newItem.name" autofocus>
                                    </div>
                                    <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="language_id">@lang("support.label.input.language_id")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><<i class="fa fa-language" aria-hidden="true"></i></div>
                                        <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                            <option value="">@lang("support.label.input.language_id")</option>
                                            <option :value="d.language_id" v-for="d in dSelect">@{{ d.name }} - @{{ d.short_name }}</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="estatus">@lang("support.label.input.estatus")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                            <option value="">@lang("support.label.input.estatus")</option>
                                            <option value="1">@lang("support.label.input.enable")</option>
                                            <option value="0">@lang("support.label.input.disable")</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <button id="crear" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.label.button.save")</button>
                            </form>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-crud pull-right" @click="sendForm(1)">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> @lang("support.label.button.save")
                            </button>
                            <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">
                                <i class="fa fa-times" aria-hidden="true"></i> @lang("support.label.button.cancel")
                            </button>
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
                       @if(Auth::user()->hasPermission("labels.update"))
                       @click = "getModalOn(props.row.labels_language_id,'2')"
                       v-if="props.row.estatus == '1'"></i>
                       @endif

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("labels.update"))
                       @click = "getModalOn(props.row.labels_language_id,'1')"
                       v-if="props.row.estatus == '0'"></i>
                       @endif

                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    @if(Auth::user()->hasPermission("labels.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.labels_language_id,'4')"></i>
                    @endif
                        @if(Auth::user()->hasPermission("labels.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.labels_language_id,'3')"></i>
                            @endif

                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
                <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.label.btn_add')</h3>
                <div slot="body">
                    <form method="POST" id="createForm"
                          @submit.prevent="updateItem"
                          @keydown="errors.clear($event.target.name)">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">@lang("support.label.input.name")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                <input type="text" name="name" class="form-control input-crud" id="name"
                                       placeholder="@lang("support.label.input.name")" v-model="newItem.name" autofocus>
                            </div>
                            <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="language_id">@lang("support.label.input.language_id")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><<i class="fa fa-language" aria-hidden="true"></i></div>
                                <select name="language_id" class="form-control input-crud-select" id="language_id"
                                        v-model="newItem.language_id" >
                                    <option value="">@lang("support.label.input.language_id")</option>
                                    <option :value="d.language_id" v-for="d in dSelect">@{{ d.name }} - @{{ d.short_name }}</option>
                                </select>
                            </div>
                            <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="estatus">@lang("support.label.input.estatus")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                    <option value="">@lang("support.label.input.estatus")</option>
                                    <option value="1">@lang("support.label.input.enable")</option>
                                    <option value="0">@lang("support.label.input.disable")</option>
                                </select>
                            </div>
                            <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <button id="editar" type="submit" class="btn btn-crud pull-right" style="display: none">@lang("support.label.button.save")</button>
                    </form>
                </div>
                <div slot="footer">
                    <button class="btn btn-crud pull-right" @click="sendForm(2)">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> @lang("support.label.button.save")
                    </button>
                    <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.label.button.cancel")
                    </button>
                </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.label.tit_delete")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.label.dialog_delete")<small> <br />@lang("support.label.subdialog_delete")</small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.label.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">
                        <i class="fa fa-check" aria-hidden="true"></i> @lang("support.label.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.label.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.label.dialog_enable")<small> <br />@lang("support.label.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.label.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        <i class="fa fa-check" aria-hidden="true"></i> @lang("support.label.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.label.tit_disable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.label.dialog_disable")<small> <br />@lang("support.label.subdialog_disable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.label.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                        <i class="fa fa-check" aria-hidden="true"></i> @lang("support.label.button.yes")
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

    <script type="text/javascript">

        $(function() {
            $( ".VueTables__search label" ).text('@lang("support.label.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.label.table.search")');

            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.label.table.placeholder")' );
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
                newItem: {
                    'name': '',
                    'language_id': '',
                    'estatus': ''
                },
                columns: [
                    'labels_language_id',
                    'language_id',
                    'name',
                    'created_at',
                    'activate',
                    'option'
                ],
                data: [],
                dSelect: [],
                options: {
                    headings: {
                        labels_language_id: '@lang("support.label.input.id")',
                        language_id: '@lang("support.label.input.language_id")',
                        name: '@lang("support.label.input.name")',
                        created_at: '@lang("support.label.input.created_at")',
                        activate: '@lang("support.label.input.activate")',
                        option: '@lang("support.label.input.option")'
                    },
                    sortable: ['labels_language_id', 'language_id','name','created_at'],
                    filterable: ['labels_language_id', 'language_id','name','created_at']
                }
            },

            created() {
                this.getListItems();
            },

            methods: {

                sendForm(id)
                {
                    if (id == 1)
                    {
                        $("#crear").click();
                    }
                    else if(id == 2)
                    {
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
                    axios.get('labels/1').then(response =>
                    {
                        this.dSelect = response.data.select;

                        if(response.data.label.length == 0)
                        {
                            this.data = [];
                        }
                        else
                        {
                            this.getNameId(response.data.label);
                        }
                    });
                },

                getNameId(items)
                {
                    for (var i=0; i<items.length; i++)
                    {
                        items[i].language_id = items[i].language.short_name;
                        this.data = items;
                    }
                },

                getDataEdit()
                {
                    axios.get('labels/'+this.idData+'/edit').then(response =>
                    {
                        this.newItem.name = response.data.name;
                        this.newItem.language_id = response.data.language_id;
                        this.newItem.estatus = response.data.estatus;

                    });
                },

                getCleanForm(id)
                {
                    this.newItem = {'name': '', 'language_id': '', 'estatus': ''};
                    this.errors = new Errors();
                    if(id == 1)
                    {
                        this.createModal = false;
                    }
                    else if(id == 2)
                    {
                        this.updateModal = false;
                    }
                },

                createItem()
                {
                    axios.post('labels', this.$data.newItem)
                        .then(response =>
                        {
                            this.newItem = {'name': '', 'language_id': '', 'estatus': ''};
                            this.getListItems();
                            this.createModal = false;
                            toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error =>
                        {
                            this.errors.record(error.response.data.errors);
                        });
                },

                updateItem ()
                {
                    axios.put('labels/'+this.idData, this.$data.newItem)
                        .then(response =>
                        {
                            this.newItem = {'name': '', 'language_id': '', 'estatus': ''};
                            this.getListItems();
                            this.updateModal = false;
                            toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error =>
                        {
                            this.errors.record(error.response.data.errors);
                        });
                },

                deleteItem(id)
                {
                    this.deleteModal = false;
                    axios.delete('labels/'+id).then(response =>
                    {
                        this.getListItems();
                        toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                onItem(id)
                {
                    this.enableModal = false;
                    axios.get('labels/'+id+'/on').then(response =>
                    {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                offItem(id)
                {
                    this.disableModal = false;
                    axios.get('labels/'+id+'/off').then(response =>
                    {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                }
            }
        });

    </script>


@endsection
