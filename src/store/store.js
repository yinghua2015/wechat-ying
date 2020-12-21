import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    asideFolded:false, //左侧菜单折叠开关
    changeTimeAll:false,//一天的数据
    times:"1",
    ex:"Okex",
    cityname0:[],
    typeS:'',
    typeNew:'',
    _isMobile() {
      let flag = navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i)
      return flag;
   }
  },
  mutations: {
    ASIDE_TOGGLE(state, data){
      console.log(state)
      if(typeof data === 'boolean'){
        state.asideFolded = data;
      }else{
        state.asideFolded = !state.asideFolded
      }
    },
    more_Times(state, data){
      console.log('more_Times数据'+state)
      console.log('more_Times数据'+data)
      state.times = data;
      // if(typeof data === 'boolean'){
      //   state.times === data;
      // }else{
      //   state.times === !state.times
      // }
    },
    more_Type(state, data){
      console.log('more_Type数据'+state)
      console.log('more_Type数据'+data)
      state.ex =  data;
      // if(typeof data === 'boolean'){
      //   state.ex = data;
      // }else{
      //   state.ex = !state.ex
      // }
    },
    checkedBox0(state, data){
      // console.log('checkedBox0数据'+state)
      // console.log('checkedBox0数据'+data)
      state.cityname0 =  data;
    },
    typeStatus(state,data){
      state.typeS = data
    },
    typeNewAll(state,data){
      state.typeNew = data
    }

  },
  actions: {

  },
  getters:{
    _isMobile:state => state._isMobile(),
    asideFolded:state => state.asideFolded,
    changeTimeAll:state => state.changeTimeAll,
    times:state => state.times,
    ex:state => state.ex,
    cityname0:state => state.cityname0,
    typeS:state => state.typeS,
    typeNew:state => state.typeNew
  }
})
