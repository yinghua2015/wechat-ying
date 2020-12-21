<template>
  <div id="app" :class="{'aside-folded':asideFolded}">
    <!-- <img src="./assets/logo.png"> -->
    <v-header></v-header>
    <v-menu></v-menu>

    <div class="content">
      <div class="wrapper">
        <transition mode="out-in" enter-active-class="animated fadeInDown">
          <router-view></router-view>
        </transition>
      </div>
    </div>

  </div>
</template>
<style scoped>

</style>
<script>
import $ from "jquery";
import {mapGetters} from 'vuex'
import header from './components/block/Header'
import menu from './components/block/Menu'
export default {
  name: 'app',
  data(){
    return {

    }
  },
  mounted(){
    //此方法刷新页面时也会执行
        //  window.addEventListener('beforeunload',()=>{
        //     localStorage.removeItem('token');
        // });
        // window.onbeforeunload = function (e) {
        //         var storage = window.localStorage;
        //         storage.clear()
        //         alert(111)
        // }

  },
  created(){
    // this.$http.get('subject/subject_list.php',{}).then(function(res){
    //   console.log(res)
    // })
  },
  components: {
    'v-header': header,
    'v-menu': menu
  },
  methods:{
  },
  computed: {
    ...mapGetters(['asideFolded']),
    ...mapGetters(["times"]),
    ...mapGetters(["ex"])
  }
}
</script>

<style lang="scss">
@import './assets/css/app.scss'
</style>
