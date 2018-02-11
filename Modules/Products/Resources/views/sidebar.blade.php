    <!-- sidebar -->
<div id="products-sidebar" class="col-xl-2 col-lg-3 col-md-3" align="left">
    <div id="sidebar" class="p-2 products-borderBlue_Viol">
        <span class="products-colorBlue products-font14"><b> {{trans('welcome.products.search_products')}}</b></span>
        <form class='form-inline' @submit.prevent='product.method.searchProducts()'>                
                <div class="input-group p-1 products-colorBlue search-input">
            <input  type="text"    id="product_name"  class="form-control products-borderBlue" placeholder="{{trans('welcome.products.search_products')}}"/>
            <span class="input-group-addon boton_icon products-borderBlue"  v-on:click="product.method.searchProducts()">
                <i class="fa fa-search" ></i>
            </span>

        </div>   </form>
        <hr class="products-hrBlue">
                  <p class="products-colorBlue products-font14 products-uppercase"><b>{{trans('welcome.common.categories')}}</b></p>
        <ul  class="form-group list-unstyled" id = "categories_list">           
               <li class="radio"  v-for = "category in product.prop.list_categories" >                     
                    <!--<label class="custom-control custom-radio products-colorBlu_Viol">-->                   
                        <input  name="radio-group" type="radio" class="radio-custom" 
                                v-bind:id="'category'+category.category_id"
                        v-on:change="product.method.getFilterByCategory(category.category_id)" >

                   <label   class="radio-custom-label products-colorBlue custom-control-description products-font13 products-type-font-regular products-uppercase" v-bind:for="'category'+category.category_id" v-on:click="product.method.getFilterByCategory(category.category_id)" >@{{category.category}}</label>
                    </li>
        </ul>            
        <hr class="products-hrBlue">
        <p class="products-colorBlue products-font14 products-uppercase"><b>{{trans('welcome.common.benefits')}}</b></p>
        <ul class="form-group list-unstyled" id = "benefits_list">            
              <li class="radio" v-for="benefit in product.prop.list_benefits" >                                  
                  <div class="products-colorBlu_Viol">
                      
                  <input name="radio-group" type="radio" class="radio-custom"  v-bind:id="'benefit'+benefit.benefit_id"  v-on:change='product.method.getFilterByBenefit(benefit.benefit_id)' >

                   <label   class="radio-custom-label products-colorBlue custom-control-description products-font13 products-type-font-regular products-uppercase" v-bind:for="'benefit'+benefit.benefit_id"
                            v-on:click="product.method.getFilterByBenefit(benefit.benefit_id)" >
                       @{{benefit.benefit}}</label>
                  </div>    
                  
                </li>           
        </ul>
       <!-- class="products-hrBlue">
        <p class="products-colorBlue products-font14 products-uppercase"><b>{{trans('welcome.common.my_orders')}}</b></p>
        <ul class="form-group list-unstyled" id = "benefits_list">
            <li class="list-unstyled">
                <label class="custom-control custom-radio products-colorBlu_Viol">
                    <a class="custom-control-description products-font13 products-type-font-regular products-uppercase" href="../public/orders/getDataOrdersByEoNumber">{{trans('welcome.common.orders_history')}}</a>
                </label>
            </li>
        </ul> -->
    </div>
</div>