<template>
   <div>
     <!-- <div>以太坊钱包地址中SHOW持仓排行榜。数据来源：//etherscan.io/token/0xf41861f194e7ba8de95144a89e0c6ed16ee0b3a0#balances</div> -->

     <iframe src="http://coinmetrics.io/charts/#assets=btc" frameborder="0" width="100%" height="1000px"></iframe>
   </div>
</template>

<style scoped>

</style>

<script>
  import $ from 'jquery'
  export default {
    methods: {
      load(){
        $("#tp").load("http://bigdata.show-fund.com/");
      }

    },
    created(){
       if (window.innerWidth<500) { if(this.$store.getters.asideFolded == false){
          $('#app').attr('class','aside-folded')}
      }
      this.load()
    }
  }
</script>