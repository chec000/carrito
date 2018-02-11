@extends('support::layouts.master')
@section('css')
    <link rel="stylesheet" type="text/css" id="theme" href="{{ Module::asset('support:css/crud.css') }}"/>
@endsection
@section('content')

    <ul class="breadcrumb">
        <li><a href="{{ url('support') }}"><i class="fa fa-tachometer" aria-hidden="true"></i> @lang("support.package.bc_home")</a></li>
        <li class="active"><i class="fa fa-star" aria-hidden="true"></i> @lang("support.package.title")</li>
    </ul>

    <div class="page-content-wrap">
        <div class="marco-crud" id="app">
            <div class="row">
                <div class="col-md-6">
                    <h2> <i class="fa fa-star" aria-hidden="true"></i> @lang("support.package.title") <small>@lang("support.package.subtitle")</small></h2>
                </div>
                <div class="col-md-6 text-right">
                    @if(Auth::user()->hasPermission("packages.create"))
                    <button class="btn btn-crud" id="show-modal" @click="createModal = true">
                        <i class="fa fa-plus" aria-hidden="true"></i> @lang('support.package.btn_add')
                    </button>
                    @endif
                    <modal v-if="createModal" @close="createModal = false" class="text-left">
                        <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.package.btn_add')</h3>
                        <div slot="body">
                            <div class="row">
                                <div class="col-md-6 float-left">
                                    <form method="POST" id="createForm"
                                          @submit.prevent="createItem"
                                          @keydown="errors.clear($event.target.name)">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="name">@lang("support.package.input.name")</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                                <input type="text" name="name" class="form-control input-crud" id="name"
                                                       placeholder="@lang("support.package.input.name")" v-model="newItem.name" autofocus>
                                            </div>
                                            <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="image_package">@lang("support.package.input.image_package")</label>
                                            <input type="file" name="image_package" id="image_package" v-model="newItem.image_package">
                                            <span v-text="errors.get('image_package')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">@lang("support.package.input.price")</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                                <input type="number" name="price" class="form-control input-crud" id="price"
                                                       placeholder="@lang("support.package.input.price")" v-model="newItem.price" autofocus>
                                            </div>
                                            <span v-text="errors.get('price')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="points">@lang("support.package.input.points")</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                                <input type="number" name="points" class="form-control input-crud" id="points"
                                                       placeholder="@lang("support.package.input.points")" v-model="newItem.points" autofocus>
                                            </div>
                                            <span v-text="errors.get('points')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">@lang("support.package.input.description")</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                                <textarea name="description" class="form-control input-crud" id="description"
                                                          placeholder="@lang("support.package.input.description")" v-model="newItem.description" autofocus>
                                        </textarea>
                                            </div>
                                            <span v-text="errors.get('description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="video_url">@lang("support.package.input.video_url")</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                                <input type="text" name="video_url" class="form-control input-crud" id="video_url"
                                                       placeholder="@lang("support.package.input.video_url")" v-model="newItem.video_url" autofocus>
                                            </div>
                                            <span v-text="errors.get('video_url')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="language_id">@lang("support.package.input.language_id")</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                                                <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                                    <option value="">@lang("support.package.input.language_id")</option>
                                                    <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                                </select>
                                            </div>
                                            <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="estatus">@lang("support.package.input.estatus")</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                                <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                                    <option value="">@lang("support.package.input.estatus")</option>
                                                    <option value="1">@lang("support.package.input.enable")</option>
                                                    <option value="0">@lang("support.package.input.disable")</option>
                                                </select>
                                            </div>
                                            <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                        </div>

                                        <button id="crear" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.package.button.save")</button>
                                    </form>
                                </div>
                                <div class="products col-md-6">
                                    <h6><i class="fa fa-product-hunt" aria-hidden="true"></i> @lang('support.package.add_products')</h6>
                                    <div class="form-group">
                                        <label for="products">@lang("support.package.input.products")</label>
                                        <div class="input-group">
                                            <select name="products" class="form-control input-crud-select" id="products" v-model="newItem.products">
                                                <option value="">@lang("support.package.input.products")</option>
                                                <option :value="dP.product_id" :sku="dP.sku" v-for="dP in dprod">@{{ dP.productlanguage.name }}</option>
                                            </select>
                                        </div>
                                        <span v-text="errors.get('products')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">@lang("support.package.input.quantity")</label>
                                        <div class="input-group">
                                            <input type="number" name="quantity" class="form-control input-crud" id="quantity" min="0"
                                                   placeholder="@lang("support.package.input.quantity")" v-model="newItem.quantity" autofocus>
                                        </div>
                                        <span v-text="errors.get('quantity')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                    </div>
                                    <button class="btn btn-crud" @click="addListProduct()">@lang("support.package.button.addprod")</button>


                                    <div class="row">
                                        <table class="col-md-12">
                                            <thead>
                                             <tr>
                                                 <td>Cantidad</td>
                                                 <td>Producto</td>
                                                 <td>Nombre</td>
                                                 <td>Accion</td>
                                             </tr>

                                            </thead>
                                            <tr v-for="ap in addProducts">
                                                <td>@{{ ap.quantity }} </td>
                                                <td>@{{ ap.products }}</td>
                                                <td>@{{ ap.name }}</td>
                                                <td>

                                                    <button type="button" class="btn btn-danger" style="padding: 0 5px" @click="removeProductList(ap.products)">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                        </table>

                                    </div>


                                </div>

                            </div>

                        </div>
                        <div slot="footer">
                            <button class="btn btn-crud pull-right" @click="sendForm(1)">@lang("support.package.button.save")</button>
                            <button type="button" @click="getCleanForm(1)" class="btn btn-crud-cancel pull-right">@lang("support.package.button.cancel")</button>

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
                       @if(Auth::user()->hasPermission("packages.update"))
                       @click = "getModalOn(props.row.package_language_id,'2')"
                       @endif
                       v-if="props.row.estatus == '1'"></i>


                    <i class="optIcon fa fa-power-off fa-2x" style="color: #ff4141;"
                       aria-hidden="true"
                       data-toggle="tooltip"
                       data-placement="left"
                       title="Inactivo"
                       @if(Auth::user()->hasPermission("packages.update"))
                       @click = "getModalOn(props.row.package_language_id,'1')"
                       @endif
                       v-if="props.row.estatus == '0'"></i>


                </div>

                <div slot="option" slot-scope="props" :href="props.row.option" class="text-center optionBtn" style="color: #5b2c76">
                    @if(Auth::user()->hasPermission("packages.update"))
                    <i class="optIcon fa fa-pencil-square-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.package_language_id,'4')"></i>
                    @endif
                        @if(Auth::user()->hasPermission("packages.delete"))
                    <i class="optIcon fa fa-trash-o fa-2x" aria-hidden="true"
                       @click = "getModalOn(props.row.package_language_id,'3')"></i>
                       @endif

                </div>
            </v-client-table>

            {{-- Modal Update Registro --}}
            <!--<modal v-if="updateModal" @close="updateModal = false" class="text-left">
            <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.package.btn_add')</h3>
            <div slot="body">
                <form method="POST" id="createForm"
                      @submit.prevent="updateItem"
                      @keydown="errors.clear($event.target.name)">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">@lang("support.package.input.name")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                <input type="text" name="name" class="form-control input-crud" id="name"
                                       placeholder="@lang("support.package.input.name")" v-model="newItem.name" autofocus>
                            </div>
                            <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="image_package">@lang("support.package.input.image_package")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                <input type="text" name="image_package" class="form-control input-crud" id="image_package"
                                       placeholder="@lang("support.package.input.image_package")" v-model="newItem.image_package" autofocus>
                            </div>
                            <span v-text="errors.get('image_package')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="price">@lang("support.package.input.price")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                <input type="number" name="price" class="form-control input-crud" id="price"
                                       placeholder="@lang("support.package.input.price")" v-model="newItem.price" autofocus>
                            </div>
                            <span v-text="errors.get('price')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="points">@lang("support.package.input.points")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                <input type="number" name="points" class="form-control input-crud" id="points"
                                       placeholder="@lang("support.package.input.points")" v-model="newItem.points" autofocus>
                            </div>
                            <span v-text="errors.get('points')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="description">@lang("support.package.input.description")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                <textarea name="description" class="form-control input-crud" id="description"
                                          placeholder="@lang("support.package.input.description")" v-model="newItem.description" autofocus>
                                        </textarea>
                            </div>
                            <span v-text="errors.get('description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="video_url">@lang("support.package.input.video_url")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                <input type="text" name="video_url" class="form-control input-crud" id="video_url"
                                       placeholder="@lang("support.package.input.video_url")" v-model="newItem.video_url" autofocus>
                            </div>
                            <span v-text="errors.get('video_url')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="language_id">@lang("support.package.input.language_id")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                                <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                    <option value="">@lang("support.package.input.language_id")</option>
                                    <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                </select>
                            </div>
                            <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>
                        <div class="form-group">
                            <label for="estatus">@lang("support.package.input.estatus")</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                    <option value="">@lang("support.package.input.estatus")</option>
                                    <option value="1">@lang("support.package.input.enable")</option>
                                    <option value="0">@lang("support.package.input.disable")</option>
                                </select>
                            </div>
                            <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                        </div>

                        <button id="crear" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.package.button.save")</button>
                    </form>
                </div>
                <div slot="footer">
                    <button class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.package.button.save")</button>
                    <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.package.button.cancel")</button>
                </div>
            </modal>-->


            <modal v-if="updateModal" @close="updateModal = false" class="text-left">
                <h3 slot="header"><i class="fa fa-star" aria-hidden="true"></i> @lang('support.package.tit_edit')</h3>
                <div slot="body">
                    <div class="row">
                        <div class="col-md-6 float-left">
                            <form method="POST" id="createForm"
                                  @submit.prevent="updateItem"
                                  @keydown="errors.clear($event.target.name)">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name">@lang("support.package.input.name")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                        <input type="text" name="name" class="form-control input-crud" id="name"
                                               placeholder="@lang("support.package.input.name")" v-model="newItem.name" autofocus>
                                    </div>
                                    <span v-text="errors.get('name')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="image_package">@lang("support.package.input.image_package")</label>
                                    <br>
                                    <a :href="newItem.package_img" target="_blank">
                                        <img v-bind:src="newItem.package_img" style="max-width: 100px;max-height: 25px;" />
                                    </a><br><br>
                                    <input type="file" name="image_package" id="image_package" v-model="newItem.image_package">
                                    <span v-text="errors.get('image_package')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="price">@lang("support.package.input.price")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                        <input type="number" name="price" class="form-control input-crud" id="price"
                                               placeholder="@lang("support.package.input.price")" v-model="newItem.price" autofocus>
                                    </div>
                                    <span v-text="errors.get('price')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="points">@lang("support.package.input.points")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                        <input type="number" name="points" class="form-control input-crud" id="points"
                                               placeholder="@lang("support.package.input.points")" v-model="newItem.points" autofocus>
                                    </div>
                                    <span v-text="errors.get('points')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="description">@lang("support.package.input.description")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <textarea name="description" class="form-control input-crud" id="description"
                                                  placeholder="@lang("support.package.input.description")" v-model="newItem.description" autofocus>
                                        </textarea>
                                    </div>
                                    <span v-text="errors.get('description')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="video_url">@lang("support.package.input.video_url")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="fa fa-star"></span></div>
                                        <input type="text" name="video_url" class="form-control input-crud" id="video_url"
                                               placeholder="@lang("support.package.input.video_url")" v-model="newItem.video_url" autofocus>
                                    </div>
                                    <span v-text="errors.get('video_url')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="language_id">@lang("support.package.input.language_id")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-language" aria-hidden="true"></i></div>
                                        <select name="language_id" class="form-control input-crud-select" id="language_id" v-model="newItem.language_id" >
                                            <option value="">@lang("support.package.input.language_id")</option>
                                            <option :value="dL.language_id" v-for="dL in dlang">@{{ dL.name }} - @{{ dL.short_name }}</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('language_id')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>
                                <div class="form-group">
                                    <label for="estatus">@lang("support.package.input.estatus")</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></div>
                                        <select name="estatus" class="form-control input-crud-select" id="rol" v-model="newItem.estatus">
                                            <option value="">@lang("support.package.input.estatus")</option>
                                            <option value="1">@lang("support.package.input.enable")</option>
                                            <option value="0">@lang("support.package.input.disable")</option>
                                        </select>
                                    </div>
                                    <span v-text="errors.get('estatus')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                                </div>

                                <button id="editar" type="submit" class="btn btn-crud pull-right" style="display:none;">@lang("support.package.button.save")</button>
                            </form>
                        </div>
                        <div class="products col-md-6">
                            <h6><i class="fa fa-product-hunt" aria-hidden="true"></i> @lang('support.package.add_products')</h6>
                            <div class="form-group">
                                <label for="products">@lang("support.package.input.products")</label>
                                <div class="input-group">
                                    <select name="products" class="form-control input-crud-select" id="products" v-model="newItem.products">
                                        <option value="">@lang("support.package.input.products")</option>
                                        <option :value="dP.product_id" :sku="dP.sku" v-for="dP in dprod">@{{ dP.productlanguage.name }}</option>
                                    </select>
                                </div>
                                <span v-text="errors.get('products')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <div class="form-group">
                                <label for="quantity">@lang("support.package.input.quantity")</label>
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control input-crud" id="quantity" min="0"
                                           placeholder="@lang("support.package.input.quantity")" v-model="newItem.quantity" autofocus>
                                </div>
                                <span v-text="errors.get('quantity')" class="error text-danger" style="font-weight: 700;font-size: 14px;"></span>
                            </div>
                            <button class="btn btn-crud" @click="addListProduct()">@lang("support.package.button.addprod")</button>


                            <div class="row">
                                <table class="col-md-12">
                                    <thead>
                                    <tr>
                                        <td>Cantidad</td>
                                        <td>Producto</td>
                                        <td>SKU</td>
                                        <td>Accion</td>
                                    </tr>

                                    </thead>
                                    <tr v-for="ap in addProducts">
                                        <td>@{{ ap.quantity }} </td>
                                        <td>@{{ ap.products }}</td>
                                        <td>@{{ ap.name }}</td>
                                        <td>

                                            <button type="button" class="btn btn-danger" style="padding: 0 5px" @click="removeProductList(ap.products)">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>

                                </table>

                            </div>


                        </div>

                    </div>

                </div>
                <div slot="footer">
                    <button class="btn btn-crud pull-right" @click="sendForm(2)">@lang("support.package.button.save")</button>
                    <button type="button" @click="getCleanForm(2)" class="btn btn-crud-cancel pull-right">@lang("support.package.button.cancel")</button>

                </div>
            </modal>

            {{-- Modal Delete Registro --}}
            <modal v-if="deleteModal" @close="deleteModal = false">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.package.tit_delete")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.package.dialog_delete")<small> <br />@lang("support.package.subdialog_delete")</small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="deleteModal = false" class="btn btn-crud-cancel">
                        @lang("support.package.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud " @click="deleteItem(idData)">@lang("support.package.button.yes")</button>
                </div>
            </modal>

            {{-- Modal Enable Registro --}}
            <modal v-if="enableModal" @close="enableModal = false" class="text-left">

                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.package.tit_enable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.package.dialog_enable")<small> <br />@lang("support.package.subdialog_enable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="enableModal = false" class="btn btn-crud-cancel">
                        @lang("support.package.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="onItem(idData)">
                        @lang("support.package.button.yes")
                    </button>
                </div>
            </modal>

            {{-- Modal Disable Registro --}}
            <modal v-if="disableModal" @close="disableModal = false" class="text-left">
                <h3 slot="header" class="text-left">
                    <i class="fa fa-star" aria-hidden="true"></i> @lang("support.package.tit_disable")
                </h3>
                <div slot="body" class="text-center">
                    <i class="fa fa-question-circle-o fa-5x" aria-hidden="true" style="color: #f0ad4e; font-size: 10em"></i>
                    <br /><br />
                    <h2>@lang("support.package.dialog_disable")<small> <br />@lang("support.package.subdialog_disable") </small></h2>
                </div>
                <div slot="footer" class="text-center">
                    <button type="button" @click="disableModal = false" class="btn btn-crud-cancel">
                        @lang("support.package.button.no")
                    </button>
                    <button type="submit" class="btn btn-crud" @click="offItem(idData)">
                        @lang("support.package.button.yes")
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
                    <div class="modal-container" style="width:900px !important;">
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
            $( ".VueTables__search label" ).text('@lang("support.package.table.search")');

            $( ".VueTables__limit label" ).text('@lang("support.package.table.search")');

            $( ".VueTables__search input" ).attr( 'placeholder', '@lang("support.package.table.placeholder")' );
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
                newItem: {'name': '','language_id': '','image_package':'','description':'','video_url':'','price':'','points':'','estatus': '','quantity': '', 'products':''},
                columns: ['package_language_id', 'language_id', 'name','price','points','created_at','activate','option'],
                data: [],
                dlang: [],
                dprod:[],
                prods:{'quantity':0,'products':0},
                addProducts:[],
                options: {
                    headings: {
                        package_language_id: 'Id',
                        language_id: '@lang("support.package.input.language_id")',
                        name: '@lang("support.package.input.name")',
                        price:'@lang("support.package.input.price")',
                        points:'@lang("support.package.input.points")',
                        products:'@lang("support.package.input.products")',
                        created_at: '@lang("support.package.pack_date")',
                        activate: '@lang("support.package.input.enable") / @lang("support.package.input.disable")',
                        option: '@lang("support.package.input.actions")'
                    },
                    sortable: ['package_language_id', 'language_id','name','price','created_at'],
                    filterable: ['package_language_id', 'language_id','name','price','created_at']
                }
            },

            created() {
                this.getListItems();
            },

            methods: {

                sendForm(package_language_id)
                {
                    if (package_language_id == 1){
                        $("#crear").click();
                    }else if(package_language_id == 2){
                        $("#editar").click();
                    }
                },

                getModalOn(package_language_id,tipo){
                    this.idData = package_language_id;
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
                    axios.get('packages/1').then(response => {
                        //console.log(response.data.products);
                        this.dlang = response.data.language;
                        this.getNameId(response.data.package);
                        this.dprod = response.data.products;
                        console.log(this.dprod.productlanguage);
                    });
                },

                getNameId(items)
                {
                    if(items.length > 0) {
                        for (var i=0; i<items.length; i++) {
                            items[i].language_id = items[i].language.short_name;
                            this.data = items;
                        }
                    }
                    else
                        this.data = [];
                },

                getDataEdit()
                {
                    axios.get('packages/'+this.idData+'/edit').then(response =>
                    {
                        this.newItem.package = response.data.package_language.package;
                        this.newItem.language_id = response.data.package_language.language_id;
                        this.newItem.is_main_package = response.data.package.is_main_package;
                        this.newItem.estatus = response.data.package_language.estatus;
                        this.newItem.list_order = response.data.package.list_order;
                        this.newItem.package = response.data.package_language.package;
                        this.newItem.language_id = response.data.package_language.language_id;
                        this.newItem.is_main_package = response.data.package.is_main_package;
                        this.newItem.estatus = response.data.package_language.estatus;
                        this.newItem.list_order = response.data.package.list_order;

                        this.newItem.name = response.data.package_language.name;
                        this.newItem.description = response.data.package_language.description;
                        this.newItem.video_url = response.data.package_language.video_url;
                        this.newItem.price = response.data.package.price;
                        this.newItem.points = response.data.package.points;

                        this.newItem.package_img = response.data.package_language.image_package;

                        var self = this;
                        $.each( response.data.products, function( index, product ) {
                            self.addProducts.push({
                                quantity: product.quantity,
                                products: product.product_id,
                                name : product.product.sku,
                            });

                            $("#createForm").append("<input class='input_products' id='prod_"+product.product_id+"' type='hidden' name='productos[]' value='"+product.product_id+"'  />");
                            $("#createForm").append("<input class='input_quantities'  id='cant_"+product.product_id+"' type='hidden' name='cantidades[]' value='"+product.quantity+"' />");
                        });
                    });
                },

                getCleanForm(package_language_id)
                {
                    this.addProducts = [];
                    $('.input_products').remove();
                    $('.input_quantities').remove();
                    this.errors = new Errors();
                    this.newItem = {'name': '','language_id': '','image_package':'','description':'','video_url':'','price':'','points':'','estatus': ''};

                    if(package_language_id == 1){
                        this.createModal = false;
                    }else if(package_language_id == 2){
                        this.updateModal = false;
                    }
                },

                createItem() {

                    const formData = new FormData();
                    formData.append('name',this.$data.newItem.name);
                    if(document.getElementById('image_package').files[0] !=  undefined)
                        formData.append( 'image_package', document.getElementById('image_package').files[0]);
                    formData.append('price',this.$data.newItem.price);
                    formData.append('points',this.$data.newItem.points);
                    formData.append('description',this.$data.newItem.description);
                    formData.append('video_url',this.$data.newItem.video_url);
                    formData.append('language_id',this.$data.newItem.language_id);
                    formData.append('estatus',this.$data.newItem.estatus);
                    formData.append('products', $( "input[name='productos[]']").serialize())
                    formData.append('quantities', $( "input[name='cantidades[]']").serialize())

                    axios.post('packages',formData)
                        .then(response => {
                        this.newItem = {'name': '','language_id': '','image_package':'','description':'','video_url':'','price':'','points':'','estatus': ''};
                        this.getListItems();
                        //this.createModal = false;
                        this.getCleanForm(1);
                        toastr.success('@lang("support.package.item_saved")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                    });


                },

                updateItem (){
                    const formData = new FormData();
                    formData.append( 'id', this.idData);
                    formData.append('name',this.$data.newItem.name);
                    if(document.getElementById('image_package').files[0] !=  undefined)
                        formData.append( 'image_package', document.getElementById('image_package').files[0]);
                    formData.append('price',this.$data.newItem.price);
                    formData.append('points',this.$data.newItem.points);
                    formData.append('description',this.$data.newItem.description);
                    formData.append('video_url',this.$data.newItem.video_url);
                    formData.append('language_id',this.$data.newItem.language_id);
                    formData.append('estatus',this.$data.newItem.estatus);
                    formData.append('products', $( "input[name='productos[]']").serialize())
                    formData.append('quantities', $( "input[name='cantidades[]']").serialize())

                    axios.post('packages/'+this.idData, formData)
                        .then(response => {

                        this.newItem = {'name': '','language_id': '','image_package':'','description':'','video_url':'','price':'','points':'','estatus': ''};
                        this.getListItems();
                        //this.updateModal = false;
                        this.getCleanForm(2);
                        toastr.success('@lang("support.package.item_updated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                    });



                },

                deleteItem(package_language_id) {
                    this.deleteModal = false;
                    axios.delete('packages/'+package_language_id).then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.package.item_deleted")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                onItem(package_language_id) {
                    this.enableModal = false;
                    axios.get('packages/'+package_language_id+'/on').then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.package.item_activated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                offItem(package_language_id) {
                    this.disableModal = false;
                    axios.get('packages/'+package_language_id+'/off').then(response => {
                        this.getListItems();
                        toastr.success('@lang("support.package.item_deactivated")', 'Success Alert', {"closeButton": true, timeOut: 5000});
                    });
                },
                addListProduct(){




                    if(this.newItem.quantity != "" && this.newItem.products != "" && this.newItem.quantity > 0){
                        /*console.log(this.newItem.quantity);
                        console.log(this.newItem.products); */
                       // console.log($("#cant_"+this.newItem.products).val());
                        $("#cant_"+this.newItem.products).val(parseInt(this.newItem.quantity) + parseInt($("#cant_"+this.newItem.products).val()));
                         //console.log(parseInt($("#cant_"+this.addProducts[i].products).val()) + parseInt(this.newItem.quantity));

                                         var result = this.search(this.newItem.products, this.addProducts);

                                         if (result != null) {

                                             //console.log("en el if");
                                             for(i = 0;i < this.addProducts.length;i++){
                                                 if(this.addProducts[i].products == result.products){
                                                     this.addProducts[i].quantity = parseInt(this.newItem.quantity) + parseInt(this.addProducts[i].quantity);
                                                 }
                                             }

                                         } else {

                                             this.addProducts.push({
                                                 quantity: this.newItem.quantity,
                                                 products: this.newItem.products,
                                                 //name     : $("#products").find(":selected").text(),
                                                 name: $("#products").find(":selected").attr('sku'),
                                             });

                                             $("#createForm").append("<input id='prod_"+this.newItem.products+"' type='hidden' name='productos[]' value='"+this.newItem.products+"'  />");
                                             $("#createForm").append("<input id='cant_"+this.newItem.products+"' type='hidden' name='cantidades[]' value='"+this.newItem.quantity+"' />");

                                             //console.log(this.addProducts);
                                         }




                    }else{
                        alert('Es necesario ingresar el producto y cantidad');
                    }




                },
                removeProductList(prodCode){
                    //console.log(prodCode);

                    for (var i = 0; i < this.addProducts.length; i++) {
                        if(this.addProducts[i].products == prodCode){
                            Vue.delete(this.addProducts,i);
                            $('#prod_' + prodCode).remove();
                            $('#cant_' + prodCode).remove();

                            //if (this.addProducts.length == '0') { $('.actPreBtn').attr('disabled', 'disabled'); }
                        }
                    }
                    //$('.actOrdBtn').attr('disabled', 'disabled');
                },
                search(nameKey, myArray){
                    for (var i=0; i < myArray.length; i++) {
                            if (myArray[i].products === nameKey) {
                              return myArray[i];
                            }
                }
        }
            }
        });

    </script>


@endsection
