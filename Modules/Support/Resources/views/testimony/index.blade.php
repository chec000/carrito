@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.testimony.bc_home")</a></li>
        <li class="active"><i class="fa fa-star" aria-hidden="true"></i> @lang("support.testimony.bc_benefit")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-star" aria-hidden="true"></i> @lang("support.testimony.title") <small>@lang("support.testimony.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("testimony.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.testimony.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                        <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.testimony.btn_add')</h3>
                        <div slot="body">
                            <form method="POST" id="createForm"
                                  @submit.prevent="createItem"
                                  @keydown="errors.clear($event.target.name)">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="main_image">@lang("support.testimony.input.photo")</label>
                                    <input type="file" name="photo" id="photo" v-model="newItem.photo">
                                    <span v-text="errors.get('photo')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="name">@lang("support.testimony.input.name")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                        <input type="text" name="name" class="form-control input-crud" id="name"
                                               placeholder="@lang("support.testimony.input.name")" v-model="newItem.name" autofocus>
                                    </div>
                                    <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="language_id">@lang("support.testimony.input.language_id")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                                        <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                            <option value="">@lang("support.testimony.input.language_id")</option>
                                            <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="language_id">@lang("support.testimony.input.product_id")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star" aria-hidden="true"></i></div>
                                        <select name="product_id" class="form-control input-crud-select" id="product_id" v-model="newItem.product_id" >
                                            <option value="">@lang("support.testimony.input.product_id")</option>
                                            <option :value="dP.product_id" v-for="dP in dprod">[@{{ dP.sku }}] @{{ dP.short_description }}</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('product_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="estatus">@lang("support.testimony.input.estatus")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                            <option value="">@lang("support.testimony.input.estatus")</option>
                                            <option value="1">@lang("support.testimony.input.enable")</option>
                                            <option value="0">@lang("support.testimony.input.disable")</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="testimony">@lang("support.testimony.input.testimony")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-star" aria-hidden="true"></i></div>
                                        <textarea name="testimony" id="testimony" placeholder="@lang("support.testimony.input.testimony")" autofocus="autofocus" class="form-control input-crud"  v-model="newItem.testimony"></textarea>
                                    </div>
                                    <span v-text="errors.get('testimony')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <button id="crear" type="submit" class="btn btn-crud pull-right" style="display: none">@lang("support.testimony.button.save")</button>
                            </form>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.testimony.button.save")</button>
                            <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.testimony.button.cancel")</button>
                        </div>
                    </modal>
                </div>
                <div class="col-md-12">
                    <hr style="margin-top: 0"/>
                </div>
            </div>

            <v-client-table :columns="columns" :data="data" :options="options">
                <div slot="photo" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    <a :href="props.row.photo" target="_blank"><img :src="props.row.photo" style="max-width: 100px;  max-height: 25px;"/></a>
                </div>

                <div slot="activate"  slot-scope="props" class="text-center">
                    <i class="optIcon fa fa-power-off fa-2x" style="color: #0d8406;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Activo"
                       @if(Auth::user()->hasPermission("testimony.update"))
                       @click = "getModalOn(props.row.testimony_id,'2')"
                       @endif
                       v-if="props.row.estatus == '1'"></i>


                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("testimony.update"))
                       @click = "getModalOn(props.row.testimony_id,'1')"
                       @endif
                       v-if="props.row.estatus == '0'"></i>

                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    @if(Auth::user()->hasPermission("testimony.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.testimony_id,'4')"></i>
                    @endif
                        @if(Auth::user()->hasPermission("testimony.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.testimony_id,'3')"></i>
                    @endif
                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
                <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.testimony.btn_edit')</h3>
                <div slot="body">
                    <form method="POST" id="createForm"
                          @submit.prevent="updateItem"
                          @keydown="errors.clear($event.target.name)">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="main_image">@lang("support.testimony.input.photo")</label>
                            <br>
                            <a :href="newItem.testimony_img" target="_blank">
                                <img v-bind:src="newItem.testimony_img" style="max-width: 100px;max-height: 25px;" />
                            </a><br><br>
                            <input type="file" name="photo" id="photo" v-model="newItem.photo">
                            <span v-text="errors.get('photo')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="name">@lang("support.testimony.input.name")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                <input type="text" name="name" class="form-control input-crud" id="name"
                                       placeholder="@lang("support.testimony.input.name")" v-model="newItem.name" autofocus>
                            </div>
                            <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="language_id">@lang("support.testimony.input.language_id")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                                <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                    <option value="">@lang("support.testimony.input.language_id")</option>
                                    <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                </select>
                            </div>
                            <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="language_id">@lang("support.testimony.input.product_id")</label>
                            <br>
                            <a :href="newItem.product_img" target="_blank">
                                <img v-bind:src="newItem.product_img" style="max-width: 120px;max-height: 40px;" />
                            </a><br><br>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-star" aria-hidden="true"></i></div>
                                <select name="product_id" class="form-control input-crud-select" id="product_id" v-model="newItem.product_id" disabled="disabled" >
                                    <option value="">@lang("support.testimony.input.product_id")</option>
                                    <option :value="dP.product_id" v-for="dP in dprod">[@{{ dP.sku }}] @{{ dP.short_description }}</option>
                                </select>
                            </div>
                            <span v-text="errors.get('product_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="estatus">@lang("support.testimony.input.estatus")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                    <option value="">@lang("support.testimony.input.estatus")</option>
                                    <option value="1">@lang("support.testimony.input.enable")</option>
                                    <option value="0">@lang("support.testimony.input.disable")</option>
                                </select>
                            </div>
                            <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="testimony">@lang("support.testimony.input.testimony")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-star" aria-hidden="true"></i></div>
                                <textarea name="testimony" id="testimony" placeholder="@lang("support.testimony.input.testimony")" autofocus="autofocus" class="form-control input-crud"  v-model="newItem.testimony"></textarea>
                            </div>
                            <span v-text="errors.get('testimony')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <button id="editar" type="submit" class="btn btn-crud pull-right" style="display: none">@lang("support.testimony.button.save")</button>
                    </form>
                </div>
                <div slot="footer">
                    <button class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.testimony.button.save")</button>
                    <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.testimony.button.cancel")</button>
                </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.testimony.tit_delete")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.testimony.dialog_delete")<small> <br />@lang("support.testimony.subdialog_delete")</small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                        @lang("support.testimony.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.testimony.button.yes")</button>
                </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.testimony.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.testimony.dialog_enable")<small> <br />@lang("support.testimony.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        @lang("support.testimony.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        @lang("support.testimony.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.testimony.tit_disable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.testimony.dialog_disable")<small> <br />@lang("support.testimony.subdialog_disable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                        @lang("support.testimony.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                        @lang("support.testimony.button.yes")
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
            $( ".VueTables__search label" ).text('@lang("support.testimony.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.testimony.table.search")');

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
                newItem: {'testimony_id': '', 'name': '', 'language_id': '', 'estatus': '', 'product_id': '', 'testimony': ''},
                columns: ['testimony_id', 'language_id', 'product_id', 'name', 'photo', 'testimony', 'created_at', 'activate', 'option'],
                data: [],
                dlang: [],
                options: {
                    headings: {
                        testimony_id: 'Id',
                        language_id: '@lang("support.testimony.input.language_id")',
                        product_id: '@lang("support.testimony.input.product_id")',
                        name: '@lang("support.testimony.input.name")',
                        photo: '@lang("support.testimony.input.photo")',
                        testimony: '@lang("support.testimony.input.testimony")',
                        created_at: '@lang("support.testimony.test_date")',
                        activate: '@lang("support.testimony.input.enable") / @lang("support.testimony.input.disable")',
                        option: '@lang("support.testimony.input.actions")'
                    },
                    sortable: ['testimony_id', 'language_id', 'product_id', 'name','created_at', 'testimony'],
                    filterable: ['testimony_id', 'language_id', 'product_id', 'name', 'created_at', 'testimony']
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
                    axios.get('testimony/1').then(response => {
                        this.dlang = response.data.language;
                        this.dprod = response.data.product;
                        this.getNameId(response.data.testimony);
                    });
                },

                getNameId(items)
                {
                    if(items.length > 0) {
                        for (var i = 0; i < items.length; i++) {
                            items[i].language_id = items[i].language.short_name;
                            items[i].product_id = items[i].product_language.short_description;
                            this.data = items;
                        }
                    }
                    else
                        this.data = [];
                },

                getDataEdit()
                {
                    axios.get('testimony/'+this.idData+'/edit').then(response =>
                    {
                        this.newItem.name = response.data.name;
                        this.newItem.language_id = response.data.language_id;
                        this.newItem.estatus = response.data.estatus;
                        this.newItem.testimony_img = response.data.photo;
                        this.newItem.product_id = response.data.product_id;
                        this.newItem.testimony = response.data.testimony;
                        this.newItem.product_img = response.data.product_img;
                    });
                },

                getCleanForm(id)
                {
                    this.newItem = {'photo': '', 'name': '', 'language_id': '', 'estatus': '', 'testimony_img': '', 'product_id': '', 'testimony': ''};
                    this.errors = new Errors();
                    if(id == 1){
                        this.createModal = false;
                    }else if(id == 2){
                        this.updateModal = false;
                    }
                },

                createItem() {
                    var formData = new FormData();
                    formData.append( 'name', this.$data.newItem.name );
                    if(document.getElementById('photo').files[0] !=  undefined)
                        formData.append( 'photo', document.getElementById('photo').files[0]);
                    formData.append( 'estatus', this.$data.newItem.estatus );
                    formData.append( 'language_id', this.$data.newItem.language_id );
                    formData.append( 'testimony', this.$data.newItem.testimony );
                    formData.append( 'product_id', this.$data.newItem.product_id );

                    axios.post('testimony', formData)
                        .then(response => {
                            this.newItem = {'photo': '', 'name': '', 'language_id': '', 'estatus': '', 'testimony': '', 'product_id': ''};
                        this.getListItems();
                        this.createModal = false;

                        toastr.success('@lang("support.testimony.item_saved")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                    });
                },

                updateItem (){
                    var formData = new FormData();
                    formData.append( 'name', this.$data.newItem.name );
                    if(document.getElementById('photo').files[0] !=  undefined)
                        formData.append( 'photo', document.getElementById('photo').files[0]);
                    formData.append( 'estatus', this.$data.newItem.estatus );
                    formData.append( 'language_id', this.$data.newItem.language_id );
                    formData.append( 'testimony', this.$data.newItem.testimony );
                    formData.append( 'product_id', this.$data.newItem.product_id );
                    formData.append( 'id', this.idData);

                    axios.post('testimony/'+this.idData, formData)
                        .then(response => {
                        this.newItem = {'photo': '', 'name': '', 'language_id': '', 'estatus': '', 'testimony': '', 'product_id': ''};
                        this.getListItems();
                        this.updateModal = false;
                        toastr.success('@lang("support.testimony.item_updated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                            this.errors.record(error.response.data.errors);
                    });
                },

                deleteItem(id) {
                    this.deleteModal = false;
                    axios.delete('testimony/'+id).then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.testimony.item_deleted")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                onItem(id) {
                    this.enableModal = false;
                    axios.get('testimony/'+id+'/on').then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.testimony.item_activated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                offItem(id) {
                    this.disableModal = false;
                    axios.get('testimony/'+id+'/off').then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.testimony.item_deactivated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                }
            }
        });

    </script>


@endsection
