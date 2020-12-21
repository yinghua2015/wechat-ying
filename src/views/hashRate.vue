<template>
   <div>
     <div>成本计算器</div>

     <iframe src="http://bitinfocharts.com/zh/comparison/hashrate-btc-eth.html" frameborder="0" width="100%" height="1000px"></iframe>
   </div>
</template>

<style scoped>

</style>

<script>
  import $ from 'jquery'
  export default {
    methods: {
      load(){
        //$("#tp").load("http://bigdata.show.local/");
      }

    },
    created(){
       if (window.innerWidth<500) { if(this.$store.getters.asideFolded == false){
          $('#app').attr('class','aside-folded')}
      }
      //this.load()
    }
  }
</script>