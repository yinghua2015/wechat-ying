import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store/store'
import './registerServiceWorker'
import { mapGetters } from "vuex";
import './plugins/element'
import VueDataTables from 'vue-data-tables'
Vue.use(VueDataTables)

// import DataTables and DataTablesServer together
// import VueDataTables from 'vue-data-tables'
// Vue.use(VueDataTables)
import ElSearchTablePagination from 'el-search-table-pagination'

// Default use axios as HTTP tool
Vue.use(ElSearchTablePagination)
// or set a custom HTTP tool
import axios from 'axios'
Vue.use(ElSearchTablePagination, {
    axios
})
import './config/axios'
import constant from './config/constant'
import utils from './config/utils';

// hightcharts start 依赖
import Highcharts from 'highcharts/highcharts';
import exporting from "highcharts/modules/exporting";
import exportData from "highcharts/modules/export-data";
import HighchartsMore from 'highcharts/highcharts-more';
import HighchartsDrilldown from 'highcharts/modules/drilldown';
import Highcharts3D from 'highcharts/highcharts-3d';
import Highmaps from 'highcharts/modules/map';
// import Highighcharts_zh_CN from "highcharts/highcharts-zh_CN";
import Highighcharts_exporting from "highcharts/modules/exporting";
import Highighcharts_annotations from "highcharts/modules/annotations";
import Highighcharts_oldie from "highcharts/modules/oldie";
import HighighchartsIndicators from "highcharts/indicators/indicators";
import MuseUI from 'muse-ui';
import 'muse-ui/dist/muse-ui.css';

import VueQuillEditor  from 'vue-quill-editor'
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

Vue.use(VueQuillEditor);

Vue.use(MuseUI);


Vue.use(utils)
Vue.use(constant)

Vue.config.productionTip = false
exporting(Highcharts);
exportData(Highcharts);
HighchartsMore(Highcharts);
// Highighcharts_zh_CN(Highcharts);
Highighcharts_exporting(Highcharts);
Highighcharts_annotations(Highcharts);
Highighcharts_oldie(Highcharts);
HighighchartsIndicators(Highcharts);
HighchartsDrilldown(Highcharts);
Highcharts3D(Highcharts);
Highmaps(Highcharts);

Vue.directive('focus', function (el) {
  el.focus()
})
window.router=router

new Vue({
  router,
  store,
  mapGetters,
  render: h => h(App)
}).$mount('#app')
