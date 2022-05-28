<template>
<p>{{ product }}</p>


</template>
<script>
const axios = require('axios');

async function test() {
  return await axios.get('/unseren-products').then(response=> (response.data)).then((response) => {return response})
}
 export default {
     data() {
    return {
      product: null,
    };
  },
   async created () {
       console.log(await test())
       this.product = await this.gaga()
   },
   methods: {
      async gaga() {
        let test1 = await test()
       return test1
     }
   }


};
</script>
