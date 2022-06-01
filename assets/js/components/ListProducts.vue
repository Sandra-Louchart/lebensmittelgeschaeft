<template>
  <section id="app" class="pt-5-pb-5 mt-5 mb-5">
  <div  class="container">
    <div class="row">
      <div class="col-6">
        <h2 class="text-primary text-bg-dark">Unsere Aktionen</h2>
      </div>
    <div class="col-12">
      <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="row">
              <div v-for="product in products" class="card text-center col-md-4 p-3">
                <div class="card-header bg-primary text-dark">{{product.name}}</div>
                <div class="card-body">
                  <h5 class="card-title">{{product.price}} €</h5>
                  <p class="card-text"> {{product.subtitle}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>
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
