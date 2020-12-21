<template>
   <div>
     <div>成本计算器</div>

     <iframe src="http://bigdata.show.local/ViaBTC.html" frameborder="0" width="100%" height="1000px"></iframe>
     <!-- <iframe src="http://bitinfocharts.com/zh/comparison/hashrate-btc-eth.html" style="margin-top:20px" frameborder="0" width="100%" height="1000px"></iframe> -->
     <!-- <div id="tp" @click="load()">bitcoin-hashrate</div> -->
   </div>
</template>

<style scoped>

</style>

<script>
  import $ from 'jquery'
  export default {
    methods: {
      load(){
        location.href= "http://bitinfocharts.com/zh/comparison/hashrate-btc-eth.html"
        // $("#tp").get("http://bitinfocharts.com/zh/comparison/hashrate-btc-eth.html");
        // console.log(111)
        // $.ajax({
        //   type: "get",
        //   url: "http://bitinfocharts.com/zh/comparison/hashrate-btc-eth.html",
        //   success: function (response) {
        //     console.log(response)
        //   }
        // });
      }

    },
    created(){
      // this.load();
       if (window.innerWidth<500) { if(this.$store.getters.asideFolded == false){
          $('#app').attr('class','aside-folded')}
      }
      //this.load()
    }
  }
</script>