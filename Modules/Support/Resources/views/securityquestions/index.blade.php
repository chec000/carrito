@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.securityquestions.bc_home")</a></li>
        <li class="active"><i class="fa fa-question-circle" aria-hidden="true"></i> @lang("support.securityquestions.bc_securityquestions")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-question-circle" aria-hidden="true"></i> @lang("support.securityquestions.title") <small>@lang("support.securityquestions.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("questions.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.securityquestions.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                        <h3 slot="header"><i class="fa fa-question-circle" aria-hidden="true"></i> @lang('support.securityquestions.btn_add')</h3>
                        <div slot="body">
                            <form method="POST" id="createForm"
                                  @submit.prevent="createItem"
                                  @keydown="errors.clear($event.target.name)">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="securityquestions">@lang("support.securityquestions.input.securityquestions")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-question-circle"></span></div>
                                        <input type="text" name="securityquestions" class="form-control input-crud" id="securityquestions"
                                               placeholder="@lang("support.securityquestions.input.securityquestions")" v-model="newItem.securityquestions" autofocus>
                                    </div>
                                    <span v-text="errors.get('securityquestions')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <div class="form-group">
                                    <label for="language_id">@lang("support.securityquestions.input.language_id")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><<i class="fa fa-language" aria-hidden="true"></i></div>
                                        <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                            <option value="">@lang("support.securityquestions.input.language_id")</option>
                                            <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="estatus">@lang("support.securityquestions.input.estatus")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-power-off" aria-hidden="true"></i></div>
                                        <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                            <option value="">@lang("support.securityquestions.input.estatus")</option>
                                            <option value="1">@lang("support.securityquestions.input.enable")</option>
                                            <option value="0">@lang("support.securityquestions.input.disable")</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <button id="crear" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.securityquestions.button.save")</button>
                            </form>
                        </div>
                        <div slot="footer">
                            <button class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.securityquestions.button.save")</button>
                            <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.securityquestions.button.cancel")</button>
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
                       @if(Auth::user()->hasPermission("questions.update"))
                       @click = "getModalOn(props.row.security_question_language_id,'2')"
                       @endif
                       v-if="props.row.estatus == '1'"></i>


                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("questions.update"))
                       @click = "getModalOn(props.row.security_question_language_id,'1')"
                       @endif
                       v-if="props.row.estatus == '0'"></i>


                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    @if(Auth::user()->hasPermission("questions.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.security_question_language_id,'4')"></i>
                    @endif
                        @if(Auth::user()->hasPermission("questions.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.security_question_language_id,'3')"></i>
                            @endif

                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
                <h3 slot="header"><i class="fa fa-question-circle" aria-hidden="true"></i> @lang('support.securityquestions.btn_add')</h3>
                <div slot="body">
                    <form method="POST" id="createForm"
                          @submit.prevent="updateItem"
                          @keydown="errors.clear($event.target.name)">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="securityquestions">@lang("support.securityquestions.input.securityquestions")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-question-circle"></span></div>
                                <input type="text" name="securityquestions" class="form-control input-crud" id="securityquestions"
                                       placeholder="@lang("support.securityquestions.input.securityquestions")" v-model="newItem.securityquestions" autofocus>
                            </div>
                            <span v-text="errors.get('securityquestions')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>

                        <div class="form-group">
                            <label for="language_id">@lang("support.securityquestions.input.language_id")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><<i class="fa fa-language" aria-hidden="true"></i></div>
                                <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                    <option value="">@lang("support.securityquestions.input.language_id")</option>
                                    <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                </select>
                            </div>
                            <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="estatus">@lang("support.securityquestions.input.estatus")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-power-off" aria-hidden="true"></i></div>
                                <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                    <option value="">@lang("support.securityquestions.input.estatus")</option>
                                    <option value="1">@lang("support.securityquestions.input.enable")</option>
                                    <option value="0">@lang("support.securityquestions.input.disable")</option>
                                </select>
                            </div>
                            <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>

                        <button id="editar" type="submit" class="btn btn-crud pull-right" style="display: none">@lang("support.securityquestions.button.save")</button>
                    </form>
                </div>
                <div slot="footer">
                    <button class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.securityquestions.button.save")</button>
                    <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.securityquestions.button.cancel")</button>
                </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-question-circle" aria-hidden="true"></i> @lang("support.securityquestions.tit_delete")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.securityquestions.dialog_delete")<small> <br />@lang("support.securityquestions.subdialog_delete")</small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                        @lang("support.securityquestions.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.securityquestions.button.yes")</button>
                </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-question-circle" aria-hidden="true"></i> @lang("support.securityquestions.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.securityquestions.dialog_enable")<small> <br />@lang("support.securityquestions.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        @lang("support.securityquestions.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        @lang("support.securityquestions.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-question-circle" aria-hidden="true"></i> @lang("support.securityquestions.tit_disable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.securityquestions.dialog_disable")<small> <br />@lang("support.securityquestions.subdialog_disable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                        @lang("support.securityquestions.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                        @lang("support.securityquestions.button.yes")
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
            $( ".VueTables__search label" ).text('@lang("support.securityquestions.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.securityquestions.table.search")');

            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.securityquestions.table.placeholder")' );
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
                newItem: {'securityquestions': '','language_id': '', 'estatus': ''},
                columns: ['security_question_language_id', 'language_id', 'question','created_at','activate','option'],
                data: [],
                dlang: [],
                options: {
                    headings: {
                        security_question_language_id: 'Id',
                        language_id: '@lang("support.securityquestions.input.language_id")',
                        question: '@lang("support.securityquestions.input.securityquestion")',
                        created_at: '@lang("support.date_created")',
                        activate: '@lang("support.securityquestions.input.enable") / @lang("support.securityquestions.input.disable")',
                        option: '@lang("support.securityquestions.input.actions")'
                    },
                    sortable: ['security_question_language_id', 'language_id','question','created_at'],
                    filterable: ['security_question_language_id', 'language_id','question','created_at']
                }
            },

            created() {
                this.getListItems();
            },

            methods: {

                sendForm(security_question_language_id)
                {
                    if (security_question_language_id == 1){
                        $("#crear").click();
                    }else if(security_question_language_id == 2){
                        $("#editar").click();
                    }
                },

                getModalOn(security_question_language_id,tipo){
                    this.idData = security_question_language_id;
                    console.log(this.idData);
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
                    axios.get('securityquestions/1').then(response => {
                        //console.log(response.data);
                        this.dlang = response.data.language;
                        this.getNameId(response.data.securityquestions);
                    });
                },

                getNameId(items)
                {

                    for (var i=0; i<items.length; i++) {

                        items[i].language_id = items[i].language.short_name;
                        this.data = items;
                    }
                },

                getDataEdit()
                {
                    axios.get('securityquestions/'+this.idData+'/edit').then(response =>
                    {

                        this.newItem.securityquestions = response.data.securityquestions_language.question;
                        this.newItem.language_id = response.data.securityquestions_language.language_id;
                        this.newItem.estatus = response.data.securityquestions_language.estatus;

                    });
                },

                getCleanForm(security_question_language_id)
                {
                    this.newItem = {'securityquestions': '','language_id': '', 'estatus': ''};
                    if(security_question_language_id == 1){
                        this.createModal = false;
                    }else if(security_question_language_id == 2){
                        this.updateModal = false;
                    }

                    this.errors = new Errors();
                },

                createItem() {
                    console.log("llamando a createitem");
                    axios.post('securityquestions', this.$data.newItem)
                        .then(response => {
                        this.newItem = {'securityquestions': '','language_id': '', 'estatus': ''};
                        this.getListItems();
                        this.createModal = false;
                        toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                    });
                },

                updateItem (){
                    console.log("llamando a updateitem");
                    axios.put('securityquestions/'+this.idData, this.$data.newItem)
                        .then(response => {
                        this.newItem = {'securityquestions': '','language_id': '', 'estatus': ''};
                        this.getListItems();
                        this.updateModal = false;
                        toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                            this.errors.record(error.response.data.errors);
                    });
                },

                deleteItem(security_question_language_id) {
                    this.deleteModal = false;
                    axios.delete('securityquestions/'+security_question_language_id).then(response => {
                        this.getListItems();
                        toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                onItem(security_question_language_id) {
                    this.enableModal = false;
                    axios.get('securityquestions/'+security_question_language_id+'/on').then(response => {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                offItem(security_question_language_id) {
                    this.disableModal = false;
                    axios.get('securityquestions/'+security_question_language_id+'/off').then(response => {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                }
            }
        });

    </script>


@endsection
