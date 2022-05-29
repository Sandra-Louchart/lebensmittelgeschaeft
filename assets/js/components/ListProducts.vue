<template>
  <div id="app">
    <p v-for="product in products">{{product.name}} {{product.price}}</p>
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
     let results = axios.get('/unseren-products').then(response=> (response.data)).then((response) => {this.products = response; return this.products;})
     this.products = results.data
     console.log(this.products)
   },


};
</script>
