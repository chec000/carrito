@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.banner.bc_home")</a></li>
        <li class="active"><i class="fa fa-star" aria-hidden="true"></i> @lang("support.banner.bc_benefit")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-star" aria-hidden="true"></i> @lang("support.banner.title") <small>@lang("support.banner.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("banners.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.banner.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                        <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.banner.btn_add')</h3>
                        <div slot="body">
                            <form method="POST" id="createForm"
                                  @submit.prevent="createItem"
                                  @keydown="errors.clear($event.target.name)">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="main_image">@lang("support.banner.input.main_image")</label>
                                    <input type="file" name="main_image" id="main_image" v-model="newItem.main_image">
                                    <span v-text="errors.get('main_image')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="name">@lang("support.banner.input.name")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                        <input type="text" name="name" class="form-control input-crud" id="name"
                                               placeholder="@lang("support.banner.input.name")" v-model="newItem.name" autofocus>
                                    </div>
                                    <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="language_id">@lang("support.banner.input.language_id")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                                        <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                            <option value="">@lang("support.banner.input.language_id")</option>
                                            <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="estatus">@lang("support.banner.input.estatus")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                            <option value="">@lang("support.banner.input.estatus")</option>
                                            <option value="1">@lang("support.banner.input.enable")</option>
                                            <option value="0">@lang("support.banner.input.disable")</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <button id="crear" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.banner.button.save")</button>
                            </form>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.banner.button.save")</button>
                            <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.banner.button.cancel")</button>
                        </div>
                    </modal>
                </div>
                <div class="col-md-12">
                    <hr style="margin-top: 0"/>
                </div>
            </div>

            <v-client-table :columns="columns" :data="data" :options="options">
                <div slot="main_image" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    <a :href="props.row.main_image" target="_blank"><img :src="props.row.main_image" style="max-width: 100px;  max-height: 25px;"/></a>
                </div>

                <div slot="activate"  slot-scope="props" class="text-center">

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #0d8406;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Activo"
                       @if(Auth::user()->hasPermission("banners.update"))
                       @click = "getModalOn(props.row.banner_language_id,'2')"
                       @endif
                       v-if="props.row.estatus == '1'"></i>

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("banners.update"))
                       @click = "getModalOn(props.row.banner_language_id,'1')"
                       @endif
                       v-if="props.row.estatus == '0'"></i>

                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    @if(Auth::user()->hasPermission("banners.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.banner_language_id,'4')"></i>
                    @endif
                    @if(Auth::user()->hasPermission("banners.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.banner_language_id,'3')"></i>
                    @endif

                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
                <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.banner.btn_edit')</h3>
                <div slot="body">
                    <form method="POST" id="createForm"
                          @submit.prevent="updateItem"
                          @keydown="errors.clear($event.target.name)">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="main_image">@lang("support.banner.input.main_image")</label>
                            <br>
                            <a :href="newItem.banner_img" target="_blank">
                                <img v-bind:src="newItem.banner_img" style="max-width: 100px;max-height: 25px;" />
                            </a><br><br>
                            <input type="file" name="main_image" id="main_image" v-model="newItem.main_image">
                            <span v-text="errors.get('main_image')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="name">@lang("support.banner.input.name")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                <input type="text" name="name" class="form-control input-crud" id="name"
                                       placeholder="@lang("support.banner.input.banner")" v-model="newItem.name" autofocus>
                            </div>
                            <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="language_id">@lang("support.banner.input.language_id")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><<i class="fa fa-language" aria-hidden="true"></i></div>
                                <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                    <option value="">@lang("support.banner.input.language_id")</option>
                                    <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                </select>
                            </div>
                            <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="estatus">@lang("support.banner.input.estatus")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                    <option value="">@lang("support.banner.input.estatus")</option>
                                    <option value="1">@lang("support.banner.input.enable")</option>
                                    <option value="0">@lang("support.banner.input.disable")</option>
                                </select>
                            </div>
                            <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <button id="editar" type="submit" class="btn btn-crud pull-right" style="display: none">@lang("support.banner.button.save")</button>
                    </form>
                </div>
                <div slot="footer">
                    <button class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.banner.button.save")</button>
                    <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.banner.button.cancel")</button>
                </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.banner.tit_delete")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.banner.dialog_delete")<small> <br />@lang("support.banner.subdialog_delete")</small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                        @lang("support.banner.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.banner.button.yes")</button>
                </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.banner.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.banner.dialog_enable")<small> <br />@lang("support.banner.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        @lang("support.banner.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        @lang("support.banner.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.banner.tit_disable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.banner.dialog_disable")<small> <br />@lang("support.banner.subdialog_disable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                        @lang("support.banner.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                        @lang("support.banner.button.yes")
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
            $( ".VueTables__search label" ).text('@lang("support.banner.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.banner.table.search")');

            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.banner.table.placeholder")' );
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
                newItem: {'main_image': '', 'name': '', 'language_id': '', 'estatus': ''},
                columns: ['banner_language_id', 'language_id', 'main_image', 'name','created_at','activate','option'],
                data: [],
                dlang: [],
                options: {
                    headings: {
                        banner_language_id: 'Id',
                        language_id: '@lang("support.banner.input.language_id")',
                        main_image: '@lang("support.banner.input.main_image")',
                        name: '@lang("support.banner.input.name")',
                        created_at: '@lang("support.banner.ban_date")',
                        activate: '@lang("support.banner.input.enable") / @lang("support.banner.input.disable")',
                        option: '@lang("support.banner.input.actions")'
                    },
                    sortable: ['banner_language_id', 'language_id','name','created_at'],
                    filterable: ['banner_language_id', 'language_id','name','created_at']
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
                    axios.get('banner/1').then(response => {
                        this.dlang = response.data.language;
                        this.getNameId(response.data.banner);
                    });
                },

                getNameId(items)
                {
                    if(items.length > 0) {
                        for (var i = 0; i < items.length; i++) {
                            items[i].language_id = items[i].language.short_name;
                            this.data = items;
                        }
                    }
                    else
                        this.data = [];
                },

                getDataEdit()
                {
                    axios.get('banner/'+this.idData+'/edit').then(response =>
                    {
                        this.newItem.name = response.data.name;
                        this.newItem.language_id = response.data.language_id;
                        this.newItem.estatus = response.data.estatus;
                        this.newItem.banner_img = response.data.main_image;
                    });
                },

                getCleanForm(id)
                {
                    this.newItem = {'main_image': '', 'name': '', 'language_id': '', 'estatus': '', 'banner_img': ''};
                    this.errors = new Errors();
                    if(id == 1){
                        this.createModal = false;
                    }else if(id == 2){
                        this.updateModal = false;
                    }
                },

                createItem() {
                    const formData = new FormData();
                    formData.append( 'name', this.$data.newItem.name );

                    if(document.getElementById('main_image').files[0] !=  undefined)
                        formData.append( 'main_image', document.getElementById('main_image').files[0]);

                    formData.append( 'estatus', this.$data.newItem.estatus );
                    formData.append( 'language_id', this.$data.newItem.language_id );

                    axios.post('banner', formData)
                        .then(response => {
                        this.newItem = {'main_image': '', 'name': '', 'language_id': '', 'estatus': ''};
                        this.getListItems();
                        this.createModal = false;

                        toastr.success('@lang("support.banner.item_saved")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                    });
                },

                updateItem (){
                    var formData = new FormData();
                    formData.append( 'name', this.$data.newItem.name );

                    if(document.getElementById('main_image').files[0] !=  undefined)
                        formData.append( 'main_image', document.getElementById('main_image').files[0]);

                    formData.append( 'estatus', this.$data.newItem.estatus );
                    formData.append( 'language_id', this.$data.newItem.language_id );
                    formData.append( 'id', this.idData);

                    axios.post('banner/'+this.idData, formData)
                        .then(response => {
                        this.newItem = {'main_image': '', 'name': '', 'language_id': '', 'estatus': ''};
                        this.getListItems();
                        this.updateModal = false;
                        toastr.success('@lang("support.banner.item_updated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                            this.errors.record(error.response.data.errors);
                    });
                },

                deleteItem(id) {
                    this.deleteModal = false;
                    axios.delete('banner/'+id).then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.banner.item_deleted")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                onItem(id) {
                    this.enableModal = false;
                    axios.get('banner/'+id+'/on').then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.banner.item_activated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                offItem(id) {
                    this.disableModal = false;
                    axios.get('banner/'+id+'/off').then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.banner.item_deactivated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                }
            }
        });

    </script>


@endsection
