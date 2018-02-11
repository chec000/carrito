@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.restrictions.bc_home")</a></li>
        <li class="active"><i class="fa fa-cube" aria-hidden="true"></i> @lang("support.restrictions.bc_restrictions")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
                <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-cube" aria-hidden="true"></i> @lang("support.restrictions.title") <small>@lang("support.restrictions.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.restrictions.btn_add')
                    </button>
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                        <h3 slot="header"><i class="fa fa-cube" aria-hidden="true"></i> @lang('support.restrictions.btn_add')</h3>
                        <div slot="body">
                            <form method="POST" id="createForm"
                                  @submit.prevent="createItem"
                                  @keydown="errors.clear($event.target.name)"
                                  @change="errors.clear($event.target.name)">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="estatus">@lang("support.restrictions.input.product_id")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <select name="product_id" class="form-control input-crud-select"
                                                id="product_id" v-model="newItem.product_id"
                                                style="text-transform: capitalize;">
                                            <option value="">@lang("support.restrictions.input.product_id")</option>
                                            <option :class="'product_'+d.product_id" :value="d.product_id" v-for="d in dataController.product_id">
                                                @{{ d.name }} - @{{ d.sku }}
                                            </option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('product_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="state">@lang("support.restrictions.input.state_id")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <select name="state_id" class="form-control input-crud-select"
                                                id="state_id" v-model="newItem.state_id"
                                                style="text-transform: capitalize;">
                                            <option value="">@lang("support.restrictions.input.state_id")</option>
                                            <option :class="'state_'+d.state_id" :value="d.state_id" v-for="d in dataController.state_id">
                                                @{{ d.state }} - @{{ d.state_key }}
                                            </option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('state_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="estatus">@lang("support.restrictions.input.estatus")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                            <option value="">@lang("support.restrictions.input.estatus")</option>
                                            <option value="1">@lang("support.restrictions.input.enable")</option>
                                            <option value="0">@lang("support.restrictions.input.disable")</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <button id="crear" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.restrictions.button.save")</button>
                            </form>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-crud pull-right" @click="sendForm(1)">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> @lang("support.restrictions.button.save")
                            </button>
                            <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">
                                <i class="fa fa-times" aria-hidden="true"></i> @lang("support.restrictions.button.cancel")
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
                       @click = "getModalOn(props.row.product_state_restriction_id,'2')"
                       v-if="props.row.estatus == '1'"></i>

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @click = "getModalOn(props.row.product_state_restriction_id,'1')"
                       v-if="props.row.estatus == '0'"></i>

                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">

                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.product_state_restriction_id,'3')"></i>

                </div>
            </v-client-table>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.restrictions.tit_delete")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.restrictions.dialog_delete")<small> <br />@lang("support.restrictions.subdialog_delete")</small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.restrictions.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">
                        <i class="fa fa-check" aria-hidden="true"></i> @lang("support.restrictions.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.restrictions.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.restrictions.dialog_enable")<small> <br />@lang("support.restrictions.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.restrictions.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        <i class="fa fa-check" aria-hidden="true"></i> @lang("support.restrictions.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.restrictions.tit_disable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.restrictions.dialog_disable")<small> <br />@lang("support.restrictions.subdialog_disable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.restrictions.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                        <i class="fa fa-check" aria-hidden="true"></i> @lang("support.restrictions.button.yes")
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
            $( ".VueTables__search label" ).text('@lang("support.restrictions.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.restrictions.table.search")');

            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.restrictions.table.placeholder")' );
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
                    'product_id': '',
                    'state_id': '',
                    'estatus': ''
                },
                dataController: {
                    'product_id': [],
                    'state_id': []
                },
                columns: [
                    'product_state_restriction_id',
                    'product_id',
                    'state_id',
                    'created_at',
                    'updated_at',
                    'activate',
                    'option'
                ],
                data: [],
                options: {
                    headings: {
                        product_state_restriction_id: '@lang("support.restrictions.input.id")',
                        product_id: '@lang("support.restrictions.input.product_id")',
                        state_id: '@lang("support.restrictions.input.state_id")',
                        created_at: '@lang("support.restrictions.input.created_at")',
                        updated_at: '@lang("support.restrictions.input.updated_at")',
                        activate: '@lang("support.restrictions.input.activate")',
                        option: '@lang("support.restrictions.input.option")'
                    },
                    sortable: ['product_state_restriction_id', 'product_id','state_id','created_at','updated_at'],
                    filterable: ['product_state_restriction_id', 'product_id','state_id','created_at','updated_at']
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
                    axios.get('restrictions/1').then(response =>
                    {
                        this.dataController.product_id = response.data.product;
                        this.dataController.state_id = response.data.state;

                        if(response.data.restrictions.length == 0)
                        {
                            this.data = [];
                        }
                        else
                        {

                            this.getNameId(response.data.restrictions);
                        }
                    });
                },

                getNameId(items)
                {
                    for (var i=0; i<items.length; i++)
                    {
                        items[i].product_id = items[i].product.sku;
                        items[i].state_id = items[i].state.state_key + ' - ' +items[i].state.state;
                        this.data = items;
                    }
                },

                getCleanForm(id)
                {
                    this.newItem = {'product_id': '', 'state_id': '', 'estatus': ''};
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
                    axios.post('restrictions', this.$data.newItem)
                        .then(response =>
                        {
                            this.newItem = {'product_id': '', 'state_id': '', 'estatus': ''};
                            this.getListItems();
                            this.createModal = false;
                            toastr.success('Se a creado correctamente el registro.', 'Registro Exitoso', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error =>
                        {
                            this.errors.record(error.response.data.errors);
                        });
                },

                updateItem ()
                {
                    axios.put('restrictions/'+this.idData, this.$data.newItem)
                        .then(response =>
                        {
                            this.newItem = {'ingredient': '', 'language_id': '', 'estatus': ''};
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
                    axios.delete('restrictions/'+id).then(response =>
                    {
                        this.getListItems();
                        toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                onItem(id)
                {
                    this.enableModal = false;
                    axios.get('restrictions/'+id+'/on').then(response =>
                    {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                offItem(id)
                {
                    this.disableModal = false;
                    axios.get('restrictions/'+id+'/off').then(response =>
                    {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                }
            }
        });

    </script>


@endsection
