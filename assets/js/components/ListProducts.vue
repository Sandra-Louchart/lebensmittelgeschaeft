<template>
  <section id="app" class="pt-5-pb-5 mb-5 mb-5">
    <div  class="container">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div v-for="product in products" :key="product.id" class="account-item col-md-6 pt-5 pb-2">
              <div class=" text-center text-xxl-center">
                <div class="card-header bg-secondary text-dark">{{product.name}}</div>
                <div class="card-body bg-primary text-dark">
                  <h5 class="card-title">{{product.price}} €</h5>
                  <p class="card-text"> {{product.subtitle}}</p>
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

<style>
account-item{
  width: 150px;
  height: 150px;
  border-radius: 20px;
}
</style>