@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="#"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.user.bc_home")</a></li>
        <li class="active"><i class="fa fa-id-card-o" aria-hidden="true"></i> @lang("support.user.bc_user")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud">
            <div class="row">
                <div class="col-xs-6">
                    <h2> <i class="fa fa-id-card-o" aria-hidden="true"></i> @lang("support.user.title") <small>@lang("support.user.subtitle")</small></h2>
                </div>
                <div class="col-xs-6">

                    <button class="btn btn-crud pull-right" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.user.btn_add')
                    </button>

                    <modal v-if="createModal" @close="createModal = false">
                        <h3 slot="header"><i class="fa fa-id-card-o" aria-hidden="true"></i> @lang('support.user.btn_add')</h3>
                        <div slot="body">
                            <form>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control input-crud" id="exampleInputEmail1" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control input-crud" id="exampleInputEmail1" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control input-crud" id="exampleInputEmail1" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control input-crud" id="exampleInputPassword1" placeholder="Password">
                                </div>
                            </form>
                        </div>
                        <div slot="footer">
                            <button type="submit" class="btn btn-crud pull-right">Guardar</button>
                            <button type="button" @click="createModal = false" class="btn btn-crud-cancel pull-right">Cancelar</button>
                        </div>
                    </modal>

                </div>
            </div>
            <hr style="margin-top: 0" />
            <div class="row">
                <div class="col-md-12">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011/04/25</td>
                            <td>$320,800</td>
                            <td class="text-center">
                                <i class="fa fa-power-off fa-2x" aria-hidden="true" style="color: green;" data-toggle="tooltip" data-placement="left" title="Activo"></i>
                                <i class="fa fa-trash fa-2x" aria-hidden="true" id="show-modal1"
                                   @click="enableModal = true" style="cursor: pointer;"data-toggle="tooltip" data-placement="left" title="Eliminar"></i> &nbsp;&nbsp;&nbsp;

                                <modal v-if="enableModal" @close="enableModal = false">
                                    <h3 slot="header" class="text-left">
                                        <i class="fa fa-id-card-o" aria-hidden="true"></i> Activar Usuario
                                    </h3>
                                    <div slot="body" class="text-center">
                                        <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: orangered; font-size: 10em"></i>
                                        <br /><br />
                                        <h2>¿Estas seguro de activar el usuario?<small> <br />Si elimina el registro no se podra recuperar</small></h2>
                                    </div>
                                    <div slot="footer" class="text-center">
                                        <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">NO</button>
                                        <button type="submit" class="btn btn-crud ">SI</button>
                                    </div>
                                </modal>
                                <i class="fa fa-power-off fa-2x" aria-hidden="true" style="color: red;" data-toggle="tooltip" data-placement="left" title="Inactivo"></i>
                                <i class="fa fa-trash fa-2x" aria-hidden="true" id="show-modal1"
                                   @click="deleteModal = true" style="cursor: pointer;"data-toggle="tooltip" data-placement="left" title="Eliminar"></i> &nbsp;&nbsp;&nbsp;

                                <modal v-if="deleteModal" @close="deleteModal = false">
                                    <h3 slot="header" class="text-left">
                                        <i class="fa fa-id-card-o" aria-hidden="true"></i> Eliminar Usuario
                                    </h3>
                                    <div slot="body" class="text-center">
                                        <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: orangered; font-size: 10em"></i>
                                        <br /><br />
                                        <h2>¿Estas seguro de eliminar el registro?<small> <br />Si elimina el registro no se podra recuperar</small></h2>
                                    </div>
                                    <div slot="footer" class="text-center">
                                        <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">NO</button>
                                        <button type="submit" class="btn btn-crud ">SI</button>
                                    </div>
                                </modal>
                            </td>
                            <td class="text-center">
                                
                                <i class="fa fa-eye fa-2x" aria-hidden="true" id="show-modal1"
                                   @click="viewModal = true" style="cursor: pointer;"
                                   data-toggle="tooltip" data-placement="left" title="Ver"></i> &nbsp;&nbsp;&nbsp;

                                <modal v-if="viewModal" @close="viewModal = false">
                                    <h3 slot="header" class="text-left">
                                        <i class="fa fa-id-card-o" aria-hidden="true"></i> Detalle Usuario
                                    </h3>
                                    <div slot="body" class="text-left">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="well well-sm" style="margin-bottom: 0">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <h4>Edgar Flores <small>Desarrollador Web</small></h4>
                                                                <p>
                                                                    <i class="fa fa-user-circle" aria-hidden="true"></i> edgar.flores
                                                                    <br />
                                                                    <i class="glyphicon glyphicon-envelope"></i> edgar.flores@omnilife.com
                                                                    <br />
                                                                    <i class="glyphicon glyphicon-map-marker"></i> San Francisco, USA
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div slot="footer">
                                        <button type="button" @click="viewModal = false" class="btn btn-crud-cancel pull-right">Cerrar</button>
                                    </div>
                                </modal>

                                <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true" id="show-modal1"
                                   @click="editModal = true" style="cursor: pointer;"data-toggle="tooltip" data-placement="left" title="Editar"></i> &nbsp;&nbsp;&nbsp;

                                <modal v-if="editModal" @close="editModal = false">
                                    <h3 slot="header" class="text-left">
                                        <i class="fa fa-id-card-o" aria-hidden="true"></i> Detalle Usuario
                                    </h3>
                                    <div slot="body" class="text-left">
                                        <form>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control input-crud" id="exampleInputEmail1" placeholder="Email" value="edgar">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control input-crud" id="exampleInputEmail1" placeholder="Email" value="edgar">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control input-crud" id="exampleInputEmail1" placeholder="Email" value="edgar">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input type="password" class="form-control input-crud" id="exampleInputPassword1" placeholder="Password" value="edgar" >
                                            </div>
                                        </form>
                                    </div>
                                    <div slot="footer">
                                        <button type="submit" class="btn btn-crud pull-right">Guardar</button>
                                        <button type="button" @click="editModal = false" class="btn btn-crud-cancel pull-right">Cancelar</button>
                                    </div>
                                </modal>

                                <i class="fa fa-trash fa-2x" aria-hidden="true" id="show-modal1"
                                   @click="deleteModal = true" style="cursor: pointer;"data-toggle="tooltip" data-placement="left" title="Eliminar"></i> &nbsp;&nbsp;&nbsp;

                                <modal v-if="deleteModal" @close="deleteModal = false">
                                    <h3 slot="header" class="text-left">
                                        <i class="fa fa-id-card-o" aria-hidden="true"></i> Eliminar Usuario
                                    </h3>
                                    <div slot="body" class="text-center">
                                        <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: orangered; font-size: 10em"></i>
                                        <br /><br />
                                        <h2>¿Estas seguro de eliminar el registro?<small> <br />Si elimina el registro no se podra recuperar</small></h2>
                                    </div>
                                    <div slot="footer" class="text-center">
                                        <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">NO</button>
                                        <button type="submit" class="btn btn-crud ">SI</button>
                                    </div>
                                </modal>

                                {{--<i class="" aria-hidden="true" data-toggle="tooltip" data-placement="rigth" title="Eliminar"></i>--}}

                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section("modal")
    <!-- template for the modal component -->
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
    <!-- app -->
@endsection
@section('js')

    <script>


        $(document).ready(function() {
            Vue.component('modal', {
                template: '#modal-template'
            })

    // start app
            new Vue({
                el: '#app',
                data: {
                    createModal: false,
                    editModal: false,
                    deleteModal: false,
                    updateModal: false,
                    enableModal: false,
                    disableModal: false,
                    viewModal: false
                }
            })

            $('#example').DataTable( {
                "language": {
                    "decimal":        "@lang('support.decimal')",
                    "emptyTable":     "@lang('support.emptyTable')",
                    "info":           "@lang('support.info')",
                    "infoEmpty":      "@lang('support.infoEmpty')",
                    "infoFiltered":   "@lang('support.infoFiltered')",
                    "infoPostFix":    "@lang('support.infoPostFix')",
                    "thousands":      ",",
                    "lengthMenu":     "@lang('support.lengthMenu')",
                    "loadingRecords": "@lang('support.loadingRecords')",
                    "processing":     "@lang('support.processing')",
                    "search":         "@lang('support.search')",
                    "zeroRecords":    "@lang('support.zeroRecords')",
                    "paginate": {
                        "first":      "@lang('support.paginate.first')",
                        "last":       "@lang('support.paginate.last')",
                        "next":       "@lang('support.paginate.next')",
                        "previous":   "@lang('support.paginate.previous')"
                    },
                    "aria": {
                        "sortAscending":  "@lang('support.aria.sortAscending')",
                        "sortDescending": "@lang('support.aria.sortDescending')"
                    }
                }
            } );
        } );
    </script>
@endsection
