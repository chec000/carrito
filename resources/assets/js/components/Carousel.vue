<template>
	<section class="products">
    <h2 class="products-title morado"><b>{{ title }}</b></h2>
    <div class="products-slider s1">
      <div v-for="product in products" class="prod-item">
        <div class="prod-info ">
          <div class="col-lg-4">
            <div class="prod-image">
              <a href="#"><img src="http://intranet3.omnilife.com/demo/images/productos/4278605-1.png" class="slide-img rounded"></a>
            </div>
          </div><br>
          <div class="form-group">
            <p class="prod-name">{{ product.name }}</p>
            <p>{{ product.description }}<a href="">Leer mas</a></p>
          </div>
        </div>
        <div class="prod-values">
          <p class="prod-price"><b>$ {{ product.price.toLocaleString(undefined, {'maximumFractionDigits':2}) }}</b></p>
          <p class="prod-points"><b>PTS:{{ product.pts }}</b></p>
        </div>
        <button @click="$root.addProduct(product)" type="button" name="addToCart" class="fondo-morado letra-blanca btn btn-secondary w-100 height30 addProduct"><b><h4>{{ add }}</h4></b></button>
      </div>
    </div>
  </section>
</template>

<script>
  export default {
    name: 'carousel',
    props: ['title', 'add', 'products']
  }
</script>