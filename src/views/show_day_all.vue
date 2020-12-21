<template>
   <div>
     <div style="margin-top:45px">绿色显示每日流入交易所的秀币数量，红色显示每日流出交易所的数量，紫色为当日净流入的数量。净流入=流入-流出</div>

     <iframe src="chart_mobile.html" frameborder="0" width="100%" height="1000px"></iframe>
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