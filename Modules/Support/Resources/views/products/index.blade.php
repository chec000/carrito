@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
    <style>
        /*Form Wizard*/
        .bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
        .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
        .bs-wizard > .bs-wizard-step + .bs-wizard-step {}
        .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
        .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #f55de2a8; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;}
        .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #5b2c76; border-radius: 50px; position: absolute; top: 8px; left: 8px; }
        .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
        .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #f55de2a8;}
        .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
        .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
        .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
        .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
        .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
        .bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
        .bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
        .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
        .VueTables__table tr td{vertical-align: middle !important; font-size: 14px;}
        .modal-container{
            width: 850px;
        }
    </style>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.products.bc_home")</a></li>
        <li class="active"><i class="fa fa-cube" aria-hidden="true"></i> @lang("support.products.bc_products")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-cube" aria-hidden="true"></i> @lang("support.products.title") <small>@lang("support.products.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("products.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.products.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                        <h3 slot="header"><i class="fa fa-cube" aria-hidden="true"></i> @lang('support.products.btn_add')</h3>
                        <div slot="body">

                            <div class="tab-content">

                                {{-- FORMULARIO PRINCIPAL --}}
                                <div role="tabpanel" class="tab-pane fade in active" id="home">
                                    <div class="row bs-wizard" style="border-bottom:0;">

                                        <div class="col-xs-2 bs-wizard-step active">
                                            <div class="text-center bs-wizard-stepnum">Productos</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Imagen</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Categorias</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            {{--<div class="text-center bs-wizard-stepnum">Beneficios</div>--}}
                                            <div class="text-center bs-wizard-stepnum">Extras</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                        </div>

                                    </div>
                                    <form method="POST" id="createForm"
                                          @submit.prevent="createItem"
                                          @keydown="errors.clear($event.target.name)"
                                          @change="errors.clear($event.target.name)">
                                        {{ csrf_field() }}
                                        <br />
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">
                                                        <span style="color: red;">*</span>@lang("support.products.input.name")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="fa fa-at"></span></div>
                                                        <input type="text" name="name" class="form-control input-crud" id="name"
                                                               placeholder="@lang("support.products.input.name")" v-model="newItem.name" autofocus>
                                                    </div>
                                                    <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nutritional_table">
                                                        <span style="color: red;">*</span>@lang("support.products.input.nutritional_table")</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="fa fa-balance-scale"></span></div>
                                                        <input type="text" name="nutritional_table" class="form-control input-crud" id="nutritional_table"
                                                               placeholder="@lang("support.products.input.nutritional_table")" v-model="newItem.nutritional_table">
                                                    </div>
                                                    <span v-text="errors.get('nutritional_table')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sku">
                                                        <span style="color: red;">*</span>@lang("support.products.input.sku")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="fa fa-tags"></span></div>
                                                        <input type="text" name="sku" class="form-control input-crud" id="sku"
                                                               placeholder="@lang("support.products.input.sku")" v-model="newItem.sku" autofocus>
                                                    </div>
                                                    <span v-text="errors.get('sku')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="price">
                                                        <span style="color: red;">*</span>@lang("support.products.input.price")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="fa fa-money"></span></div>
                                                        <input type="text" name="price" class="form-control input-crud" id="price"
                                                               placeholder="@lang("support.products.input.price")" v-model="newItem.price" autofocus>
                                                    </div>
                                                    <span v-text="errors.get('price')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="points">
                                                        <span style="color: red;">*</span>@lang("support.products.input.points")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="fa fa-bullseye"></span></div>
                                                        <input type="text" name="points" class="form-control input-crud" id="points"
                                                               placeholder="@lang("support.products.input.points")" v-model="newItem.points" autofocus>
                                                    </div>
                                                    <span v-text="errors.get('points')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="description">
                                                        <span style="color: red;">*</span>@lang("support.products.input.description")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="fa fa-commenting-o"></span></div>
                                                        <textarea name="description" class="form-control" v-model="newItem.description"
                                                                  rows="3" style="border: 2px solid #5b2c76;"
                                                                  placeholder="@lang("support.products.input.description")">
                                                        </textarea>
                                                    </div>
                                                    <span v-text="errors.get('description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="short_description">
                                                        <span style="color: red;">*</span>@lang("support.products.input.short_description")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="fa fa-commenting-o"></span></div>
                                                        <textarea name="short_description" class="form-control" v-model="newItem.short_description"
                                                                  rows="3" style="border: 2px solid #5b2c76;"
                                                                  placeholder="@lang("support.products.input.short_description")">
                                                </textarea>
                                                    </div>
                                                    <span v-text="errors.get('short_description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="consupsion_tips">
                                                        <span style="color: red;">*</span>@lang("support.products.input.consupsion_tips")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="fa fa-commenting-o"></span></div>
                                                        <textarea name="consupsion_tips" class="form-control" v-model="newItem.consupsion_tips"
                                                                  rows="3" style="border: 2px solid #5b2c76;"
                                                                  placeholder="@lang("support.products.input.consupsion_tips")">
                                                </textarea>
                                                    </div>
                                                    <span v-text="errors.get('consupsion_tips')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="video_url">@lang("support.products.input.video_url")</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="fa fa-youtube-play"></span></div>
                                                        <input type="text" name="video_url" class="form-control input-crud" id="video_url"
                                                               placeholder="@lang("support.products.input.video_url")" v-model="newItem.video_url">
                                                    </div>
                                                    <span v-text="errors.get('video_url')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="language_id">
                                                        <span style="color: red;">*</span>@lang("support.products.input.language_id")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                                                        <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                                            <option value="">@lang("support.products.input.language_id")</option>
                                                            <option :value="d.language_id" v-for="d in dSelect">@{{ d.name }} - @{{ d.short_name }}</option>
                                                        </select>
                                                    </div>
                                                    <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="estatus">
                                                        <span style="color: red;">*</span>@lang("support.products.input.estatus")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                                        <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                                            <option value="">@lang("support.products.input.estatus")</option>
                                                            <option value="1">@lang("support.products.input.enable")</option>
                                                            <option value="0">@lang("support.products.input.disable")</option>
                                                        </select>
                                                    </div>
                                                    <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="is_kit">
                                                        <span style="color: red;">*</span>@lang("support.products.input.is_kit")
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                                        <select name="is_kit" class="form-control input-crud-select" id="is_kit" v-model="newItem.is_kit">
                                                            <option value="">@lang("support.products.input.is_kit")</option>
                                                            <option value="1">@lang("support.products.input.yes")</option>
                                                            <option value="0">@lang("support.products.input.no")</option>
                                                        </select>
                                                    </div>
                                                    <span v-text="errors.get('is_kit')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <button id="crear" type="submit" class="btn btn-crud pull-right" style="display:none;">
                                            @lang("support.products.button.save")
                                        </button>
                                    </form>
                                </div>

                                {{-- FORMULARIO PARA IMAGEN --}}
                                <div role="tabpanel" class="tab-pane fade" id="image" style="min-height: 430px">
                                    <div class="row bs-wizard" style="border-bottom:0;">

                                        <div class="col-xs-2 bs-wizard-step complete">
                                            <div class="text-center bs-wizard-stepnum">Productos</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step active"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Imagen</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Categorias</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Beneficios</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                        <div class="col-md-12 text-center">
                                            <h3>@lang("support.products.tabs.tit_image")</h3>
                                            <h5 style="color: red;">*Solo se admiten imagen en formato .png</h5>
                                            <label class="btn btn-default btn-file">
                                                Buscar Imagen
                                                <input name="file-input" id="file-input" type="file" style="display: none"
                                                       @change="displayImage"/>
                                            </label>
                                            <br />
                                            <span v-text="errors.get('file-input')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>

                                            <hr />
                                            <img id="imgSalida" width="50%" height="50%" src="" style="display: none;text-align: center" />

                                        </div>

                                    </div>

                                </div>

                                {{-- FORMULARIO PARA CATEGORIAS --}}
                                <div role="tabpanel" class="tab-pane fade" id="categoria" style="min-height: 430px">
                                    <div class="row bs-wizard" style="border-bottom:0;">

                                        <div class="col-xs-2 bs-wizard-step complete">
                                            <div class="text-center bs-wizard-stepnum">Productos</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Imagen</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step active"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Categorias</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Beneficios</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                        <div class="col-md-8">
                                            <h3>@lang("support.products.tabs.tit_category")</h3>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                                </div>
                                                <select name="category" class="form-control input-crud-select"
                                                        id="category" v-model="dataInput.category"
                                                        style="text-transform: capitalize;">
                                                    <option value="">@lang("support.products.input.category")</option>
                                                    <option :class="'categoria_'+d.category_id" :value="d.category_id" v-for="d in dataController.category">
                                                        @{{ d.category }} - @{{ d.language.name }}</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-success" style="margin-top: 30px" @click="addCategory(1)">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                                <th class="text-center">Categoria</th>
                                                <th class="text-center">Eliminar</th>
                                                <th class="text-center">&nbsp; </th>
                                            </tr>
                                            <tr  v-for="d in newItem.category">
                                                <td class="text-center"
                                                    style="text-transform: capitalize; font-size: 16px">
                                                    @{{ d.category }} - @{{ d.language.name }}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-xs" @click="deleteList(1,d.category_id)">
                                                        <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                                    </button>
                                                </td>
                                                <td> &nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- FORMULARIOS PARA ETIQUETAS --}}
                                <div role="tabpanel" class="tab-pane fade" id="label" style="min-height: 430px">
                                    <div class="row bs-wizard" style="border-bottom:0;">

                                        <div class="col-xs-2 bs-wizard-step complete">
                                            <div class="text-center bs-wizard-stepnum">Productos</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Imagen</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Categorias</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step active"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Beneficios</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                        <div class="col-md-8">
                                            <h3>@lang("support.products.tabs.tit_label")</h3>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                                </div>
                                                <select name="label" class="form-control input-crud-select"
                                                        id="label" v-model="dataInput.label"
                                                        style="text-transform: capitalize;">
                                                    <option value="">@lang("support.products.input.label")</option>
                                                    <option :class="'label_'+d.label_id" :value="d.label_id" v-for="d in dataController.label">
                                                        @{{ d.name }} - @{{ d.language.name }}</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-success" style="margin-top: 30px" @click="addCategory(2)">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                                <th class="text-center">Categoria</th>
                                                <th class="text-center">Eliminar</th>
                                                <th class="text-center">&nbsp; </th>
                                            </tr>
                                            <tr  v-for="d in newItem.label">
                                                <td class="text-center"
                                                    style="text-transform: capitalize; font-size: 16px">
                                                    @{{ d.name }} - @{{ d.language.name }}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-xs" @click="deleteList(2,d.label_id)">
                                                        <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                                    </button>
                                                </td>
                                                <td> &nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- FORMULARIOS PARA INGREDIENTES --}}
                                <div role="tabpanel" class="tab-pane fade" id="ingredient" style="min-height: 430px">
                                    <div class="row bs-wizard" style="border-bottom:0;">

                                        <div class="col-xs-2 bs-wizard-step complete">
                                            <div class="text-center bs-wizard-stepnum">Productos</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Imagen</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Categorias</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step complete"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step complete"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Beneficios</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                        <div class="col-md-8">
                                            <h3>@lang("support.products.tabs.tit_ingredient")</h3>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                                </div>
                                                <select name="ingredient" class="form-control input-crud-select"
                                                        id="ingredient" v-model="dataInput.ingredient"
                                                        style="text-transform: capitalize;">
                                                    <option value="">@lang("support.products.input.ingredient")</option>
                                                    <option :class="'ingredient_'+d.ingredient_id" :value="d.ingredient_id" v-for="d in dataController.ingredient">
                                                        @{{ d.ingredient }} - @{{ d.language.name }}</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-success" style="margin-top: 30px" @click="addCategory(3)">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                                <th class="text-center">Categoria</th>
                                                <th class="text-center">Eliminar</th>
                                                <th class="text-center">&nbsp; </th>
                                            </tr>
                                            <tr  v-for="d in newItem.ingredient">
                                                <td class="text-center"
                                                    style="text-transform: capitalize; font-size: 16px">
                                                    @{{ d.ingredient }} - @{{ d.language.name }}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-xs" @click="deleteList(3,d.ingredient_id)">
                                                        <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                                    </button>
                                                </td>
                                                <td> &nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- FORMULARIOS PARA EXTRAS BENEFICIOS y --}}
                                <div role="tabpanel" class="tab-pane fade" id="benefit" style="min-height: 430px">
                                    <div class="row bs-wizard" style="border-bottom:0;">

                                        <div class="col-xs-2 bs-wizard-step complete">
                                            <div class="text-center bs-wizard-stepnum">Productos</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Imagen</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                            <div class="text-center bs-wizard-stepnum">Categorias</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                        </div>

                                        <div class="col-xs-2 bs-wizard-step complete"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step complete"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                        </div>
                                        <div class="col-xs-2 bs-wizard-step active"><!-- active -->
                                            <div class="text-center bs-wizard-stepnum">Extras</div>
                                            {{--<div class="text-center bs-wizard-stepnum">Beneficios</div>--}}
                                            <div class="progress"><div class="progress-bar"></div></div>
                                            <a href="#" class="bs-wizard-dot"></a>
                                            {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6" style=" border-right: solid 1px #e5e5e5;">
                                            <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                                <div class="col-md-9">
                                                    <h3>@lang("support.products.tabs.tit_related")</h3>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                                        </div>
                                                        <select name="related" class="form-control input-crud-select"
                                                                id="related" v-model="dataInput.related"
                                                                style="text-transform: capitalize;">
                                                            <option value="">@lang("support.products.input.related")</option>
                                                            <option :class="'related_'+d.product_id" :value="d.product_id" v-for="d in dataController.related">
                                                                @{{ d.name }} - @{{ d.language.name }}</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-3">
                                                    <button type="button" class="btn btn-xs btn-success" style="margin-top: 55px" @click="addCategory(5)">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <table class="table">
                                                    <tr>
                                                        <th class="text-center">Productos Relacionados</th>
                                                        <th class="text-center">Eliminar</th>
                                                        <th class="text-center">&nbsp; </th>
                                                    </tr>
                                                    <tr  v-for="d in newItem.related">
                                                        <td class="text-center"
                                                            style="text-transform: capitalize; font-size: 12px">
                                                            @{{ d.name }} - @{{ d.language.name }}
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger btn-xs" @click="deleteList(5,d.product_id)">
                                                                <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                                            </button>
                                                        </td>
                                                        <td> &nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                                <div class="col-md-9">
                                                    <h3>@lang("support.products.tabs.tit_benefit")</h3>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                                        </div>
                                                        <select name="benefit" class="form-control input-crud-select"
                                                                id="benefit" v-model="dataInput.benefit"
                                                                style="text-transform: capitalize;">
                                                            <option value="">@lang("support.products.input.benefit")</option>
                                                            <option :class="'benefit_'+d.benefit_id" :value="d.benefit_id" v-for="d in dataController.benefit">
                                                                @{{ d.benefit }} - @{{ d.language.name }}</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-3">
                                                    <button type="button" class="btn btn-xs btn-success" style="margin-top: 55px" @click="addCategory(4)">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <table class="table">
                                                    <tr>
                                                        <th class="text-center">Categoria</th>
                                                        <th class="text-center">Eliminar</th>
                                                        <th class="text-center">&nbsp; </th>
                                                    </tr>
                                                    <tr  v-for="d in newItem.benefit">
                                                        <td class="text-center"
                                                            style="text-transform: capitalize; font-size: 14px">
                                                            @{{ d.benefit }} - @{{ d.language.name }}
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger btn-xs" @click="deleteList(4,d.benefit_id)">
                                                                <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                                            </button>
                                                        </td>
                                                        <td> &nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div slot="footer">
                            <button v-if="buttonNav.next" class="btn btn-crud pull-right" @click="changeSection(buttonNav.seccion)" >
                                Siguiente <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </button>
                            <a id="imageBtn" class="btn btn-crud pull-right" href="#image"
                               aria-controls="image" role="tab" data-toggle="tab" style="display: none">
                                AGREGAR IMAGEN <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                            <a id="categoryBtn" class="btn btn-crud pull-right" href="#categoria"
                               aria-controls="categoria" role="tab" data-toggle="tab" style="display: none">
                                AGREGAR CATEGORIA <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                            <a id="labelBtn"  class="btn btn-crud pull-right" href="#label"
                               aria-controls="label" role="tab" data-toggle="tab" style="display: none">
                                AGREGAR ETIQUETA <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                            <a id="ingredientBtn"  class="btn btn-crud pull-right" href="#ingredient"
                               aria-controls="ingredient" role="tab" data-toggle="tab" style="display: none">
                                AGREGAR INGREDIENTES <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                            <a id="benefitBtn"  class="btn btn-crud pull-right" href="#benefit"
                               aria-controls="benefit" role="tab" data-toggle="tab" style="display: none">
                                AGREGAR BENEFICIOS <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                            <button v-if="buttonNav.save" class="btn btn-crud pull-right" @click="sendForm(1)">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> @lang("support.products.button.save")
                            </button>
                            <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">
                                <i class="fa fa-times" aria-hidden="true"></i> @lang("support.products.button.exit")
                            </button>
                        </div>
                    </modal>
                </div>
                <div class="col-md-12">
                    <hr style="margin-top: 0"/>
                </div>
            </div>



            <v-client-table :columns="columns" :data="data" :options="options">

                <div slot="imageProd" slot-scope="props" class="text-center">
                    <img :src="'../img/img-products/'+props.row.sku+'.png'" class="rounded" height="50" />
                </div>

                <div slot="activate" slot-scope="props" class="text-center">

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #0d8406;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Activo"
                       @click = "getModalOn(props.row.product_language_id,'2')"
                       v-if="props.row.estatus == '1'"></i>

                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @click = "getModalOn(props.row.product_language_id,'1')"
                       v-if="props.row.estatus == '0'"></i>

                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    @if(Auth::user()->hasPermission("products.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.product_language_id,'4')"></i>
                        @endif
                        @if(Auth::user()->hasPermission("products.delete"))
                            <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                               @click = "getModalOn(props.row.product_language_id,'3')"></i>
                        @endif
                        @if(Auth::user()->hasPermission("products.warehouse"))
                        <a v-bind:href="'inventories/'+ props.row.product_id" type="button" title="@lang('support.products.see_warehouses')">
                            <i class="optIcon fa fa-eye fa-2x" aria-hidden="true"></i>
                        </a>
                         @endif


                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
                <h3 slot="header"><i class="fa fa-cube" aria-hidden="true"></i> @lang('support.products.btn_add')</h3>
                <div slot="body">
                    <div class="tab-content">
                        {{-- FORMULARIO PRINCIPAL --}}
                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                            <div class="row bs-wizard" style="border-bottom:0;">

                                <div class="col-xs-2 bs-wizard-step active">
                                    <div class="text-center bs-wizard-stepnum">Productos</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step disabled"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Imagen</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step disabled"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Categorias</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Beneficios</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                </div>
                            </div>
                            <form method="POST" id="updateForm"
                                  @submit.prevent="updateItem"
                                  @keydown="errors.clear($event.target.name)"
                                  @change="errors.clear($event.target.name)">
                                {{ csrf_field() }}
                                <br />
                                <div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">
                                                <span style="color: red;">*</span>@lang("support.products.input.name")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-at"></span></div>
                                                <input type="text" name="name" class="form-control input-crud" id="name"
                                                       placeholder="@lang("support.products.input.name")" v-model="newItem.name" autofocus>
                                            </div>
                                            <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nutritional_table">
                                                <span style="color: red;">*</span>@lang("support.products.input.nutritional_table")</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-balance-scale"></span></div>
                                                <input type="text" name="nutritional_table" class="form-control input-crud" id="nutritional_table"
                                                       placeholder="@lang("support.products.input.nutritional_table")" v-model="newItem.nutritional_table">
                                            </div>
                                            <span v-text="errors.get('nutritional_table')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sku">
                                                <span style="color: red;">*</span>@lang("support.products.input.sku")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-tags"></span></div>
                                                <input type="text" name="sku" class="form-control input-crud" id="sku"
                                                       placeholder="@lang("support.products.input.sku")" v-model="newItem.sku" autofocus>
                                            </div>
                                            <span v-text="errors.get('sku')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="price">
                                                <span style="color: red;">*</span>@lang("support.products.input.price")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-money"></span></div>
                                                <input type="text" name="price" class="form-control input-crud" id="price"
                                                       placeholder="@lang("support.products.input.price")" v-model="newItem.price" autofocus>
                                            </div>
                                            <span v-text="errors.get('price')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="points">
                                                <span style="color: red;">*</span>@lang("support.products.input.points")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-bullseye"></span></div>
                                                <input type="text" name="points" class="form-control input-crud" id="points"
                                                       placeholder="@lang("support.products.input.points")" v-model="newItem.points" autofocus>
                                            </div>
                                            <span v-text="errors.get('points')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">
                                                <span style="color: red;">*</span>@lang("support.products.input.description")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-commenting-o"></span></div>
                                                <textarea name="description" class="form-control" v-model="newItem.description"
                                                          rows="3" style="border: 2px solid #5b2c76;"
                                                          placeholder="@lang("support.products.input.description")">
                                                        </textarea>
                                            </div>
                                            <span v-text="errors.get('description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="short_description">
                                                <span style="color: red;">*</span>@lang("support.products.input.short_description")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-commenting-o"></span></div>
                                                <textarea name="short_description" class="form-control" v-model="newItem.short_description"
                                                          rows="3" style="border: 2px solid #5b2c76;"
                                                          placeholder="@lang("support.products.input.short_description")">
                                                </textarea>
                                            </div>
                                            <span v-text="errors.get('short_description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="consupsion_tips">
                                                <span style="color: red;">*</span>@lang("support.products.input.consupsion_tips")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-commenting-o"></span></div>
                                                <textarea name="consupsion_tips" class="form-control" v-model="newItem.consupsion_tips"
                                                          rows="3" style="border: 2px solid #5b2c76;"
                                                          placeholder="@lang("support.products.input.consupsion_tips")">
                                                </textarea>
                                            </div>
                                            <span v-text="errors.get('consupsion_tips')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="video_url">@lang("support.products.input.video_url")</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-youtube-play"></span></div>
                                                <input type="text" name="video_url" class="form-control input-crud" id="video_url"
                                                       placeholder="@lang("support.products.input.video_url")" v-model="newItem.video_url">
                                            </div>
                                            <span v-text="errors.get('video_url')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="language_id">
                                                <span style="color: red;">*</span>@lang("support.products.input.language_id")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                                                <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                                    <option value="">@lang("support.products.input.language_id")</option>
                                                    <option :value="d.language_id" v-for="d in dSelect">@{{ d.name }} - @{{ d.short_name }}</option>
                                                </select>
                                            </div>
                                            <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="estatus">
                                                <span style="color: red;">*</span>@lang("support.products.input.estatus")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                                <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                                    <option value="">@lang("support.products.input.estatus")</option>
                                                    <option value="1">@lang("support.products.input.enable")</option>
                                                    <option value="0">@lang("support.products.input.disable")</option>
                                                </select>
                                            </div>
                                            <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="is_kit">
                                                <span style="color: red;">*</span>@lang("support.products.input.is_kit")
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                                <select name="is_kit" class="form-control input-crud-select" id="is_kit" v-model="newItem.is_kit">
                                                    <option value="">@lang("support.products.input.is_kit")</option>
                                                    <option value="1">@lang("support.products.input.yes")</option>
                                                    <option value="0">@lang("support.products.input.no")</option>
                                                </select>
                                            </div>
                                            <span v-text="errors.get('is_kit')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                    </div>
                                </div>
                                <button id="editar" type="submit" class="btn btn-crud pull-right" style="display: none">
                                    @lang("support.products.button.save")
                                </button>
                            </form>
                        </div>

                        {{-- FORMULARIO PARA IMAGEN --}}
                        <div role="tabpanel" class="tab-pane fade" id="image" style="min-height: 430px">
                            <div class="row bs-wizard" style="border-bottom:0;">

                                <div class="col-xs-2 bs-wizard-step complete">
                                    <div class="text-center bs-wizard-stepnum">Productos</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step active"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Imagen</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step disabled"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Categorias</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Beneficios</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                <div class="col-md-12 text-center">
                                    <h3>@lang("support.products.tabs.tit_image")</h3>
                                    <h5 style="color: red;">*Solo se admiten imagen en formato .png</h5>
                                    <label class="btn btn-default btn-file">
                                        Buscar Imagen
                                        <input name="file-input" id="file-input" type="file" style="display: none"
                                               @change="displayImage"/>
                                    </label>
                                    <br />
                                    <span v-text="errors.get('file-input')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>

                                    <hr />
                                    <img id="imgSalida" width="50%" height="50%" src="" style="display: none;text-align: center" />

                                </div>

                            </div>

                        </div>

                        {{-- FORMULARIO PARA CATEGORIAS --}}
                        <div role="tabpanel" class="tab-pane fade" id="categoria" style="min-height: 430px">
                            <div class="row bs-wizard" style="border-bottom:0;">

                                <div class="col-xs-2 bs-wizard-step complete">
                                    <div class="text-center bs-wizard-stepnum">Productos</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Imagen</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step active"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Categorias</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Beneficios</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                <div class="col-md-8">
                                    <h3>@lang("support.products.tabs.tit_category")</h3>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                        </div>
                                        <select name="category" class="form-control input-crud-select"
                                                id="category" v-model="dataInput.category"
                                                style="text-transform: capitalize;">
                                            <option value="">@lang("support.products.input.category")</option>
                                            <option :class="'categoria_'+d.category_id" :value="d.category_id" v-for="d in dataController.category">
                                                @{{ d.category }} - @{{ d.language.name }}</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success" style="margin-top: 30px" @click="addCategory(1)">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <th class="text-center">Categoria</th>
                                        <th class="text-center">Eliminar</th>
                                        <th class="text-center">&nbsp; </th>
                                    </tr>
                                    <tr  v-for="d in newItem.category">
                                        <td class="text-center"
                                            style="text-transform: capitalize; font-size: 16px">
                                            @{{ d.category }} - @{{ d.language.name }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-xs" @click="deleteList(1,d.category_id)">
                                                <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                            </button>
                                        </td>
                                        <td> &nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- FORMULARIOS PARA ETIQUETAS --}}
                        <div role="tabpanel" class="tab-pane fade" id="label" style="min-height: 430px">
                            <div class="row bs-wizard" style="border-bottom:0;">

                                <div class="col-xs-2 bs-wizard-step complete">
                                    <div class="text-center bs-wizard-stepnum">Productos</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Imagen</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Categorias</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step active"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Beneficios</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                <div class="col-md-8">
                                    <h3>@lang("support.products.tabs.tit_label")</h3>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                        </div>
                                        <select name="label" class="form-control input-crud-select"
                                                id="label" v-model="dataInput.label"
                                                style="text-transform: capitalize;">
                                            <option value="">@lang("support.products.input.label")</option>
                                            <option :class="'label_'+d.label_id" :value="d.label_id" v-for="d in dataController.label">
                                                @{{ d.name }} - @{{ d.language.name }}</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success" style="margin-top: 30px" @click="addCategory(2)">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <th class="text-center">Categoria</th>
                                        <th class="text-center">Eliminar</th>
                                        <th class="text-center">&nbsp; </th>
                                    </tr>
                                    <tr  v-for="d in newItem.label">
                                        <td class="text-center"
                                            style="text-transform: capitalize; font-size: 16px">
                                            @{{ d.name }} - @{{ d.language.name }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-xs" @click="deleteList(2,d.label_id)">
                                                <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                            </button>
                                        </td>
                                        <td> &nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- FORMULARIOS PARA INGREDIENTES --}}
                        <div role="tabpanel" class="tab-pane fade" id="ingredient" style="min-height: 430px">
                            <div class="row bs-wizard" style="border-bottom:0;">

                                <div class="col-xs-2 bs-wizard-step complete">
                                    <div class="text-center bs-wizard-stepnum">Productos</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Imagen</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Categorias</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step complete"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step complete"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Beneficios</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                <div class="col-md-8">
                                    <h3>@lang("support.products.tabs.tit_ingredient")</h3>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                        </div>
                                        <select name="ingredient" class="form-control input-crud-select"
                                                id="ingredient" v-model="dataInput.ingredient"
                                                style="text-transform: capitalize;">
                                            <option value="">@lang("support.products.input.ingredient")</option>
                                            <option :class="'ingredient_'+d.ingredient_id" :value="d.ingredient_id" v-for="d in dataController.ingredient">
                                                @{{ d.ingredient }} - @{{ d.language.name }}</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success" style="margin-top: 30px" @click="addCategory(3)">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <th class="text-center">Categoria</th>
                                        <th class="text-center">Eliminar</th>
                                        <th class="text-center">&nbsp; </th>
                                    </tr>
                                    <tr  v-for="d in newItem.ingredient">
                                        <td class="text-center"
                                            style="text-transform: capitalize; font-size: 16px">
                                            @{{ d.ingredient }} - @{{ d.language.name }}
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-xs" @click="deleteList(3,d.ingredient_id)">
                                                <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                            </button>
                                        </td>
                                        <td> &nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        {{-- FORMULARIOS PARA BENEFICIOS--}}
                        <div role="tabpanel" class="tab-pane fade" id="benefit" style="min-height: 430px">
                            <div class="row bs-wizard" style="border-bottom:0;">

                                <div class="col-xs-2 bs-wizard-step complete">
                                    <div class="text-center bs-wizard-stepnum">Productos</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Ingresa los datos del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Imagen</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona la imagen del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
                                    <div class="text-center bs-wizard-stepnum">Categorias</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las categorias del producto</div>--}}
                                </div>

                                <div class="col-xs-2 bs-wizard-step complete"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Etiquetas</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona las etiquetas del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step complete"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Ingredientes</div>
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los ingredientes del producto</div>--}}
                                </div>
                                <div class="col-xs-2 bs-wizard-step active"><!-- active -->
                                    <div class="text-center bs-wizard-stepnum">Extras</div>
                                    {{--<div class="text-center bs-wizard-stepnum">Beneficios</div>--}}
                                    <div class="progress"><div class="progress-bar"></div></div>
                                    <a href="#" class="bs-wizard-dot"></a>
                                    {{--<div class="bs-wizard-info text-center">Selecciona los beneficios del producto</div>--}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" style=" border-right: solid 1px #e5e5e5;">
                                    <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                        <div class="col-md-9">
                                            <h3>@lang("support.products.tabs.tit_related")</h3>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                                </div>
                                                <select name="related" class="form-control input-crud-select"
                                                        id="related" v-model="dataInput.related"
                                                        style="text-transform: capitalize;">
                                                    <option value="">@lang("support.products.input.related")</option>
                                                    <option :class="'related_'+d.product_id" :value="d.product_id" v-for="d in dataController.related">
                                                        @{{ d.sku }} - @{{ d.name }}
                                                        {{--- @{{ d.language.name }}--}}
                                                    </option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-xs btn-success" style="margin-top: 55px" @click="addCategory(5)">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                                <th class="text-center">Productos Relacionados</th>
                                                <th class="text-center">Eliminar</th>
                                                <th class="text-center">&nbsp; </th>
                                            </tr>
                                            <tr  v-for="d in newItem.related">
                                                <td class="text-center"
                                                    style="text-transform: capitalize; font-size: 12px">
                                                    @{{ d.sku }} - @{{ d.name }}
                                                    {{--- @{{ d.language.name }}--}}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-xs" @click="deleteList(5,d.product_id)">
                                                        <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                                    </button>
                                                </td>
                                                <td> &nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row" style="margin-bottom: 10px;margin-top: 20px">
                                        <div class="col-md-9">
                                            <h3>@lang("support.products.tabs.tit_benefit")</h3>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                                </div>
                                                <select name="benefit" class="form-control input-crud-select"
                                                        id="benefit" v-model="dataInput.benefit"
                                                        style="text-transform: capitalize;">
                                                    <option value="">@lang("support.products.input.benefit")</option>
                                                    <option :class="'benefit_'+d.benefit_id" :value="d.benefit_id" v-for="d in dataController.benefit">
                                                        @{{ d.benefit }} - @{{ d.language.name }}</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-xs btn-success" style="margin-top: 55px" @click="addCategory(4)">
                                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                                <th class="text-center">Categoria</th>
                                                <th class="text-center">Eliminar</th>
                                                <th class="text-center">&nbsp; </th>
                                            </tr>
                                            <tr  v-for="d in newItem.benefit">
                                                <td class="text-center"
                                                    style="text-transform: capitalize; font-size: 14px">
                                                    @{{ d.benefit }} - @{{ d.language.name }}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-xs" @click="deleteList(4,d.benefit_id)">
                                                        <i class="fa fa-times" aria-hidden="true"></i> Quitar
                                                    </button>
                                                </td>
                                                <td> &nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div slot="footer">

                    <button v-if="buttonNav.next" class="btn btn-crud pull-right" @click="changeSection(buttonNav.seccion)" >
                        Siguiente <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </button>
                    <a id="imageBtn" class="btn btn-crud pull-right" href="#image"
                       aria-controls="image" role="tab" data-toggle="tab" style="display: none">
                        AGREGAR IMAGEN <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a id="categoryBtn" class="btn btn-crud pull-right" href="#categoria"
                       aria-controls="categoria" role="tab" data-toggle="tab" style="display: none">
                        AGREGAR CATEGORIA <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a id="labelBtn"  class="btn btn-crud pull-right" href="#label"
                       aria-controls="label" role="tab" data-toggle="tab" style="display: none">
                        AGREGAR ETIQUETA <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a id="ingredientBtn"  class="btn btn-crud pull-right" href="#ingredient"
                       aria-controls="ingredient" role="tab" data-toggle="tab" style="display: none">
                        AGREGAR INGREDIENTES <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <a id="benefitBtn"  class="btn btn-crud pull-right" href="#benefit"
                       aria-controls="benefit" role="tab" data-toggle="tab" style="display: none">
                        AGREGAR BENEFICIOS <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                    <button v-if="buttonNav.save" class="btn btn-crud pull-right" @click="sendForm(2)">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> @lang("support.products.button.save")
                    </button>
                    <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.products.button.exit")
                    </button>
                </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.products.tit_delete")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.products.dialog_delete")<small> <br />@lang("support.products.subdialog_delete")</small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.products.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">
                        <i class="fa fa-check" aria-hidden="true"></i> @lang("support.products.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.products.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.products.dialog_enable")<small> <br />@lang("support.products.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.products.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        <i class="fa fa-check" aria-hidden="true"></i> @lang("support.products.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.products.tit_disable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.products.dialog_disable")<small> <br />@lang("support.products.subdialog_disable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                        <i class="fa fa-times" aria-hidden="true"></i> @lang("support.products.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                        <i class="fa fa-check" aria-hidden="true"></i> @lang("support.products.button.yes")
                    </button>
                </div>
            </modal>


            {{-- Modal warehouses --}}
            <modal v-if="warehouseModal" @close="warehouseModal = false" class="text-left">
            <h3 slot="header" class="text-left">
                <i class="fa fa-star" aria-hidden="true"></i> @lang("support.products.tit_warehouse")
            </h3>
            <div slot="body" class="text-center">

            </div>
            <div slot="footer" class="text-center">
                <button type="button" @click="warehouseModal = false" class="btn btn-crud-cancel">
                    <i class="fa fa-times" aria-hidden="true"></i> @lang("support.products.button.exit")
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
            $('#myTabs a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            })

            $( ".VueTables__search label" ).text('@lang("support.products.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.products.table.search")');

            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.products.table.placeholder")' );

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
                warehouseModal: false,
                errors: new Errors(),
                newItem: {
                    'idNewProduct': '',
                    'name': '',
                    'nutritional_table': '',
                    'sku': '',
                    'price': '',
                    'points': '',
                    'description': '',
                    'short_description': '',
                    'consupsion_tips': '',
                    'video_url': '',
                    'language_id': '',
                    'is_kit': '',
                    'estatus': '',
                    'image': '',
                    'selectType': 1,
                    'category': [],
                    'label': [],
                    'ingredient': [],
                    'benefit': [],
                    'related': []
                },
                buttonNav: {
                    'seccion':0,
                    'next':false,
                    'save':true,
                    'product':false,
                    'image': false,
                    'category': false,
                    'label': false,
                    'ingredient': false,
                    'benefit': false,
                },
                dataController:{
                    'category':[],
                    'label':[],
                    'ingredient':[],
                    'benefit':[],
                    'related':[]
                },
                dataInput:{
                    'category':'',
                    'label':'',
                    'ingredient':'',
                    'benefit':'',
                    'related':''
                },
                columns: [
                    'product_language_id',
                    'language_id',
                    'sku',
                    'name',
                    'price',
                    'points',
                    'short_description',
                    'created_at',
                    'updated_at',
                    'imageProd',
                    'activate',
                    'option'
                ],
                data: [],
                dSelect: [],
                options: {
                    headings: {
                        product_language_id: '@lang("support.products.input.id")',
                        language_id: '@lang("support.products.input.language_id")',
                        sku: '@lang("support.products.input.sku")',
                        name: '@lang("support.products.input.name")',
                        price: '@lang("support.products.input.price")',
                        points: '@lang("support.products.input.points")',
                        short_description: '@lang("support.products.input.short_description")',
                        created_at: '@lang("support.products.input.created_at")',
                        updated_at: '@lang("support.products.input.updated_at")',
                        imageProd: '@lang("support.products.input.imageProd")',
                        activate: '@lang("support.products.input.activate")',
                        option: '@lang("support.products.input.option")'
                    },
                    sortable: ['product_language_id', 'language_id','name','sku','price','points','short_description','created_at','updated_at'],
                    filterable: ['product_language_id', 'language_id','name','sku','price','points','short_description','created_at','updated_at']
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
                    }else if(tipo == '5'){
                        //this.getDataEdit();
                        this.warehouseModal = true;
                    }
                },

                getListItems()
                {
                    axios.get('products/1').then(response =>
                    {
                        this.dSelect = response.data.select;
                        this.dataController.category = response.data.category;
                        this.dataController.label = response.data.label;
                        this.dataController.ingredient = response.data.ingredient;
                        this.dataController.benefit = response.data.benefit;

                        if(response.data.products.length == 0)
                        {
                            this.data = [];
                        }
                        else
                        {
                            this.getNameId(response.data.products);
                        }
                    });
                },

                getNameId(items)
                {
                    for (var i=0; i<items.length; i++)
                    {
                        items[i].language_id = items[i].language.short_name;
                        this.data = items;
                        this.dataController.related = items
                    }
                },

                getDataEdit()
                {
                    axios.get('products/'+this.idData+'/edit').then(response =>
                    {
                        this.buttonNav.next = true;
                        this.buttonNav.save = true;
                        this.newItem.idNewProduct = response.data.products.product_id;
                        this.newItem.name = response.data.products.name;
                        this.newItem.nutritional_table = response.data.products.nutritional_table;
                        this.newItem.sku = response.data.products.sku;
                        this.newItem.price = response.data.products.price;
                        this.newItem.points = response.data.products.points;
                        this.newItem.description = response.data.products.description;
                        this.newItem.short_description = response.data.products.short_description;
                        this.newItem.consupsion_tips = response.data.products.consupsion_tips;
                        this.newItem.video_url = response.data.products.video_url;
                        this.newItem.language_id = response.data.products.language_id;
                        this.newItem.is_kit = response.data.products.is_kit;
                        this.newItem.estatus = response.data.products.estatus;

                        this.addEdit(1, response.data.category);
                        this.addEdit(2, response.data.label);
                        this.addEdit(3, response.data.ingredient);
                        this.addEdit(4, response.data.benefit);
                        this.addEdit(5, response.data.related);

                    });
                },

                addEdit(section,info){

                    switch(section) {
                        case 1:
                            for(var j = 0;  j < info.length; j++){

                                for (var i = 0; i < this.dataController.category.length; i++) {

                                    if(info[j].category_id == this.dataController.category[i].category_id){

                                        this.newItem.category.push(this.dataController.category[i]);

                                        $(".categoria_"+this.dataController.category[i].category_id).remove();

                                    }

                                }
                            }
                            break;
                        case 2:
                            for(var j = 0;  j < info.length; j++){

                                for (var i = 0; i < this.dataController.label.length; i++) {

                                    if(info[j].label_id == this.dataController.label[i].label_id){

                                        this.newItem.label.push(this.dataController.label[i]);

                                        $(".label_"+this.dataController.label[i].label_id).remove();

                                    }

                                }
                            }
                            break;
                        case 3:
                            for(var j = 0;  j < info.length; j++){

                                for (var i = 0; i < this.dataController.ingredient.length; i++) {

                                    if(info[j].ingredient_id == this.dataController.ingredient[i].ingredient_id){

                                        this.newItem.ingredient.push(this.dataController.ingredient[i]);

                                        $(".ingredient_"+this.dataController.ingredient[i].ingredient_id).remove();

                                    }

                                }
                            }
                            break;
                        case 4:
                            for(var j = 0;  j < info.length; j++){

                                for (var i = 0; i < this.dataController.benefit.length; i++) {

                                    if(info[j].benefit_id == this.dataController.benefit[i].benefit_id){

                                        this.newItem.benefit.push(this.dataController.benefit[i]);

                                        $(".benefit_"+this.dataController.benefit[i].benefit_id).remove();

                                    }

                                }
                            }
                            break;
                        case 5:
                            for(var j = 0;  j < info.length; j++){

                                for (var i = 0; i < this.dataController.related.length; i++) {

                                    if(info[j].product_id_related == this.dataController.related[i].product_id){

                                        this.newItem.related.push(this.dataController.related[i]);

                                        $(".related_"+this.dataController.related[i].product_id).remove();

                                    }

                                }
                            }
                            break;
                        default:
                            break;
                    }

                },

                getCleanForm(id)
                {
                    this.errors = new Errors();
                    if(id == 1)
                    {
                        this.buttonNav.seccion = 0;
                        this.createModal = false;
                    }
                    else if(id == 2)
                    {
                        this.buttonNav.seccion = 0;
                        this.getListItems();
                        this.updateModal = false;
                    }
                    this.clearInput();
                },

                clearInput(){
                    this.newItem =  {
                        'idNewProduct': '',
                        'name': '',
                        'nutritional_table': '',
                        'sku': '',
                        'price': '',
                        'points': '',
                        'description': '',
                        'short_description': '',
                        'consupsion_tips': '',
                        'video_url': '',
                        'language_id': '',
                        'is_kit': '',
                        'estatus': '',
                        'image': '',
                        'selectType': 1,
                        'category': [],
                        'label': [],
                        'ingredient': [],
                        'benefit': [],
                        'related': []
                    }
                },

                createItem()
                {
                    axios.post('products', this.$data.newItem)
                        .then(response =>
                        {
                            this.getListItems();
                            this.buttonNav.next = true;
                            this.newItem.idNewProduct = response.data;
                            toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error =>
                        {
                            toastr.warning('Faltaron campos que son obligatorios', 'Informacion Incorrecta', {"closeButton": true, timeOut: 5000,"progressBar": true,"positionClass": "toast-top-center",});
                            this.errors.record(error.response.data.errors);
                        });
                },

                updateItem ()
                {
                    axios.post('products', this.$data.newItem)
                        .then(response =>
                        {
                            this.getListItems();
                            this.buttonNav.next = true;
                            this.newItem.idNewProduct = response.data;
                            toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error =>
                        {
                            toastr.warning('Faltaron campos que son obligatorios', 'Informacion Incorrecta', {"closeButton": true, timeOut: 5000,"progressBar": true,"positionClass": "toast-top-center",});
                            this.errors.record(error.response.data.errors);
                        });
                },

                deleteItem(id)
                {
                    this.deleteModal = false;
                    axios.delete('products/'+id).then(response =>
                    {
                        this.getListItems();
                        toastr.success('Item Delete Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                onItem(id)
                {
                    this.enableModal = false;
                    axios.get('products/'+id+'/on').then(response =>
                    {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                offItem(id)
                {
                    this.disableModal = false;
                    axios.get('products/'+id+'/off').then(response =>
                    {
                        this.getListItems();
                        toastr.success('Item Updated Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },

                addCategory(section){

                    switch(section) {
                        case 1:
                            for (var i = 0; i < this.dataController.category.length; i++) {
                                if(this.dataController.category[i].category_id == this.dataInput.category){

                                    this.saveExtras(this.dataController.category[i],"category");
                                    this.newItem.category.push(this.dataController.category[i]);
                                    $(".categoria_"+this.dataInput.category).remove();
                                    this.dataInput.category = "";

                                }
                            }
                            break;
                        case 2:
                            for (var i = 0; i < this.dataController.label.length; i++) {
                                if(this.dataController.label[i].label_id == this.dataInput.label){

                                    this.saveExtras(this.dataController.label[i],"label");
                                    this.newItem.label.push(this.dataController.label[i]);
                                    $(".label_"+this.dataInput.label).remove();
                                    this.dataInput.label = "";
                                }
                            }
                            break;
                        case 3:
                            for (var i = 0; i < this.dataController.ingredient.length; i++) {
                                if(this.dataController.ingredient[i].ingredient_id == this.dataInput.ingredient){

                                    this.saveExtras(this.dataController.ingredient[i],"ingredient");
                                    this.newItem.ingredient.push(this.dataController.ingredient[i]);
                                    $(".ingredient_"+this.dataInput.ingredient).remove();
                                    this.dataInput.ingredient = "";
                                }
                            }
                            break;
                        case 4:
                            for (var i = 0; i < this.dataController.benefit.length; i++) {
                                if(this.dataController.benefit[i].benefit_id == this.dataInput.benefit){

                                    this.saveExtras(this.dataController.benefit[i],"benefit");
                                    this.newItem.benefit.push(this.dataController.benefit[i]);
                                    $(".benefit_"+this.dataInput.benefit).remove();
                                    this.dataInput.benefit = "";
                                }
                            }
                            break;
                        case 5:
                            for (var i = 0; i < this.dataController.related.length; i++) {
                                if(this.dataController.related[i].product_id == this.dataInput.related){

                                    this.saveExtras(this.dataController.related[i],"related");
                                    this.newItem.related.push(this.dataController.related[i]);
                                    $(".related_"+this.dataInput.related).remove();
                                    this.dataInput.related = "";
                                }
                            }
                            break;
                        default:
                            break;
                    }

                },

                deleteList(section,id){

                    switch(section) {
                        case 1:
                            for (var i = 0; i < this.newItem.category.length; i++) {

                                if(this.newItem.category[i].category_id == id){

                                    this.deleteExtras(this.newItem.category[i],"category");
                                    this.dataController.category.push(this.newItem.category[i]);

                                    this.newItem.category.splice(i, 1);



                                }

                            }
                            break;
                        case 2:
                            for (var i = 0; i < this.newItem.label.length; i++) {

                                if(this.newItem.label[i].label_id == id){

                                    this.deleteExtras(this.newItem.label[i],"label");

                                    this.dataController.label.push(this.newItem.label[i]);

                                    this.newItem.label.splice(i, 1);

                                }

                            }
                            break;
                        case 3:
                            for (var i = 0; i < this.newItem.ingredient.length; i++) {

                                if(this.newItem.ingredient[i].ingredient_id == id){

                                    this.deleteExtras(this.newItem.ingredient[i],"ingredient");

                                    this.dataController.ingredient.push(this.newItem.ingredient[i]);

                                    this.newItem.ingredient.splice(i, 1);

                                }

                            }
                            break;
                        case 4:
                            for (var i = 0; i < this.newItem.benefit.length; i++) {

                                if(this.newItem.benefit[i].benefit_id == id){

                                    this.deleteExtras(this.newItem.benefit[i],"benefit");

                                    this.dataController.benefit.push(this.newItem.benefit[i]);

                                    this.newItem.benefit.splice(i, 1);

                                }
                            }
                            break;
                        case 5:
                            for (var i = 0; i < this.newItem.related.length; i++) {

                                if(this.newItem.related[i].product_id == id){

                                    this.deleteExtras(this.newItem.related[i],"related");

                                    this.dataController.related.push(this.newItem.related[i]);

                                    this.newItem.related.splice(i, 1);

                                }
                            }
                            break;
                        default:
                            break;
                    }


                },

                displayImage(e)
                {

                    this.errors.clear('file-input')

                    var file = e.target.files[0], imageType = /image.png/;

                    if (!file.type.match(imageType)){
                        this.uploadImage();
                        $('#imgSalida').hide();
                        $('#file-input').val('');
                        return;
                    }

                    var reader = new FileReader();
                    reader.onload = this.fileOnload;
                    reader.readAsDataURL(file);
                    this.uploadImage();

                },

                fileOnload(e)
                {
                    var result = e.target.result;
                    $('#imgSalida').show();
                    $('#imgSalida').attr("src",result);
                },

                changeSection(section)
                {
                    this.buttonNav.seccion += 1;

                    switch(this.buttonNav.seccion) {
                        case 1:
                            $('#imageBtn').click();
                            this.buttonNav.save = false;
                            break;
                        case 2:
                            $('#categoryBtn').click();

                            break;
                        case 3:
                            $('#labelBtn').click();

                            break;
                        case 4:
                            $('#ingredientBtn').click();

                            break;
                        case 5:
                            $('#benefitBtn').click();
                            this.buttonNav.next = false;
                            break;
                        default:
                            break;
                    }

                },

                saveExtras(item, type) {

                    item.estatus = 1;
                    item.type = type;
                    item.product_id_new = this.newItem.idNewProduct;

                    axios.post('products/actionExtras', item)
                        .then(response => {

                            //this.getListItems();

                            toastr.success('Se realizo correctamente la accion.', 'Accion Correcta', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error => {
                            toastr.warning('Error al procesar la solicitud',
                                'Error',
                                {"closeButton": true, timeOut: 5000,"progressBar": true,
                                    "positionClass": "toast-top-center",});

                        });

                },

                deleteExtras(item, type) {

                    item.estatus = 0;
                    item.type = type;
                    item.product_id_new = this.newItem.idNewProduct;

                    axios.post('products/actionExtras', item)
                        .then(response => {

                            //this.getListItems();
                            //
                            toastr.success('Se realizo correctamente la accion.', 'Accion Correcta', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error => {
                            toastr.warning('Error al procesar la solicitud',
                                'Error',
                                {"closeButton": true, timeOut: 5000,"progressBar": true,
                                    "positionClass": "toast-top-center",});

                        });

                },

                uploadImage()
                {
                    const formData = new FormData();

                    if(document.getElementById('file-input').files[0] !=  undefined)
                        formData.append( 'file-input', document.getElementById('file-input').files[0]);

                    formData.append('name', this.$data.newItem.sku );

                    axios.post('products/uploadImage', formData)
                        .then(response => {

                            this.getListItems();

                            toastr.success('Item Created Successfully.', 'Success Alert', {"closeButton": true, timeOut: 5000});
                        })
                        .catch(error => {
                            this.errors.record(error.response.data.errors);
                            toastr.warning('La imagen no se pudo cargar, intentalo nuevamente',
                                'Error al cargar imagen',
                                {"closeButton": true, timeOut: 5000,"progressBar": true,
                                    "positionClass": "toast-top-center",});

                        });
                },


            }
        });

    </script>

@endsection