<template>
  <div id="app" class="m-5 text-center">
    <h2 class="text-primary text-bg-dark">Unsere Aktionen</h2>
    <div class="row">
    <div v-for="product in products" class="card text-center col-md-3">
      <div class="card-header">{{product.name}}</div>
      <div class="card-body">
        <h5 class="card-title">{{product.price}}</h5>
        <p class="card-text"> {{product.subtitle}}</p>
      </div>
    </div>
    </div>
  </div>

</template>

<script>
const axios = require('axios');


 export default {
   data() {
    return {
      products: null,
    };
  },
   async mounted() {
     let results = axios.get('/sold').then(response=> (response.data)).then((response) => {this.products = response; return this.products;})
     this.products = results.data
     console.log(this.products)
   },


};
</script>
