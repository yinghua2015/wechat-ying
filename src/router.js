import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'

import k_line_btc from './views/k_line/k_line_btc.vue'
import k_line_btc_2 from './views/k_line/k_line_btc_2.vue'
import Chart_01 from './views/chain/chart01.vue'
import Chart_02 from './views/chain/chart02.vue'
import Chart_03 from './views/chain/chart03.vue'
import Chart_04 from './views/chain/chart04.vue'
import Chart_05 from './views/chain/chart05.vue'
import Chart_06 from './views/chain/chart06.vue'
import Chart_07 from './views/chain/chart07.vue'
import Chart_08 from './views/chain/chart08.vue'
import Chart_09 from './views/chain/chart09.vue'
import Chart_10 from './views/chain/chart10.vue'
import Chart_11 from './views/chain/chart11.vue'
import Chart_12 from './views/chain/chart12.vue'
// 以上为裢上
import bourse_chart01 from './views/bourse/bourse_chart01.vue'
import bourse_chart02 from './views/bourse/bourse_chart02.vue'
import bourse_chart03 from './views/bourse/bourse_chart03.vue'
import bourse_chart04 from './views/bourse/bourse_chart04.vue'
import bourse_chart05 from './views/bourse/bourse_chart05.vue'
import bourse_chart06 from './views/bourse/bourse_chart06.vue'
import bourse_chart07 from './views/bourse/bourse_chart07.vue'
import bourse_chart08 from './views/bourse/bourse_chart08.vue'
import bourse_chart09 from './views/bourse/bourse_chart09.vue'
import bourse_chart10 from './views/bourse/bourse_chart10.vue'
import bourse_chart11 from './views/bourse/bourse_chart11.vue'
import bourse_chart12 from './views/bourse/bourse_chart12.vue'
import bourse_chart13 from './views/bourse/bourse_chart13.vue'
import bourse_chart14 from './views/bourse/bourse_chart14.vue'
import okex_show from './views/okex_show/okex_show.vue'
import okex_show_btc from './views/okex_show/okex_show_btc.vue'
import okex_show_usdt from './views/okex_show/okex_show_usdt.vue'
import coinmarket_btc from './views/okex_show/coinmarket_btc.vue'
import coinmarket_eth from './views/okex_show/coinmarket_eth.vue'
import btcRate from './views/chainRate/btcRate.vue'
import usdtRate from './views/chainRate/usdtRate.vue'
import ethscan from './views/ethscan.vue'
import coinmetrics from './views/coinmetrics.vue'
import escanTable from './views/escanTable.vue'
import show_day_all from './views/show_day_all.vue'
import btc_dt from './views/btc_dt.vue'
import table from './views/table.vue'
import table1 from './views/table1.vue'
import table2 from './views/table2.vue'
import hashRate from './views/hashRate.vue'
import counter from './views/counter.vue'
import show200 from './views/show200.vue'
import show201 from './views/show201.vue'
import show202 from './views/show202.vue'
import show203 from './views/show203.vue'
import show203_a from './views/show203_a.vue'
import showApp from './views/showApp.vue'
import marketPerformance from './views/marketPerformance.vue'
import login from './views/login.vue'
import btcOnline from './views/btcOnline/btcOnline.vue'
import btcPrice from './views/btcOnline/btcPrice.vue'
import total from './views/total.vue'
import total_1 from './views/btcOnline/total_1.vue'
import total_2 from './views/btcOnline/total_2.vue'
import total_3 from './views/btcOnline/total_3.vue'
Vue.use(Router)
const router = new Router({
  routes: [
    //{path: '/', redirect: 'login'},
    {
      path: '/',
      name: 'home',
      component: Home,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/login',
      name: 'login',
      component: login
    },
    {
      path: '/hashRate',
      name: 'hashRate',
      component: hashRate,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/total',
      name: 'total',
      component: total,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chainRate/btcRate',
      name: 'btcRate',
      component: btcRate,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chainRate/usdtRate',
      name: 'usdtRate',
      component: usdtRate,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/btcOnline/total_1',
      name: 'total_1',
      component: total_1,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/btcOnline/total_2',
      name: 'total_2',
      component: total_2,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/btcOnline/total_3',
      name: 'total_3',
      component: total_3,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/counter',
      name: 'counter',
      component: counter,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/show200',
      name: 'show200',
      component: show200,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/show201',
      name: 'show201',
      component: show201,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/show202',
      name: 'show202',
      component: show202,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/show203',
      name: 'show203',
      component: show203,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/show203_a',
      name: 'show203_a',
      component: show203,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/showApp',
      name: 'showApp',
      component: showApp,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/marketPerformance',
      name: 'marketPerformance',
      component: marketPerformance,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/btcOnline/btcOnline',
      name: 'btcOnline',
      component: btcOnline,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/btcOnline/btcPrice',
      name: 'btcPrice',
      component: btcPrice,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/k_line/k_line_btc',
      name: 'k_line_btc',
      component: k_line_btc,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/k_line/k_line_btc_2',
      name: 'k_line_btc_2',
      component: k_line_btc_2,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/btc_dt',
      name: 'btc_dt',
      component: btc_dt,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/ethscan',
      name: 'ethscan',
      component: ethscan,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/coinmetrics',
      name: 'coinmetrics',
      component: coinmetrics,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/escanTable',
      name: 'escanTable',
      component: escanTable,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/show_day_all',
      name: 'show_day_all',
      component: show_day_all,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/okex_show/okex_show',
      name: 'okex_show',
      component: okex_show,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/okex_show/okex_show_btc',
      name: 'okex_show_btc',
      component: okex_show_btc,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/okex_show/coinmarket_btc',
      name: 'coinmarket_btc',
      component: coinmarket_btc,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/okex_show/coinmarket_eth',
      name: 'coinmarket_eth',
      component: coinmarket_eth,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/okex_show/okex_show_usdt',
      name: 'okex_show_usdt',
      component: okex_show_usdt,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart01',
      name: 'chart01',
      component: Chart_01,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart02',
      name: 'chart02',
      component: Chart_02,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart03',
      name: 'chart03',
      component: Chart_03,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart04',
      name: 'chart04',
      component: Chart_04,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart05',
      name: 'chart05',
      component: Chart_05,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart06',
      name: 'chart06',
      component: Chart_06,
      meta: {
        requireAuth: true
      }
    }, {
      path: '/chain/chart07',
      name: 'chart07',
      component: Chart_07,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart08',
      name: 'chart08',
      component: Chart_08,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart09',
      name: 'chart09',
      component: Chart_09,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart10',
      name: 'chart10',
      component: Chart_10,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart11',
      name: 'chart11',
      component: Chart_11,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/chain/chart12',
      name: 'chart12',
      component: Chart_12,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart01',
      name: 'bourse_chart01',
      component: bourse_chart01,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart02',
      name: 'bourse_chart02',
      component: bourse_chart02,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart03',
      name: 'bourse_chart03',
      component: bourse_chart03,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart04',
      name: 'bourse_chart04',
      component: bourse_chart04,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart05',
      name: 'bourse_chart05',
      component: bourse_chart05,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart06',
      name: 'bourse_chart06',
      component: bourse_chart06,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart07',
      name: 'bourse_chart07',
      component: bourse_chart07,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart08',
      name: 'bourse_chart08',
      component: bourse_chart08,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart09',
      name: 'bourse_chart09',
      component: bourse_chart09,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart10',
      name: 'bourse_chart10',
      component: bourse_chart10,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart11',
      name: 'bourse_chart11',
      component: bourse_chart11,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart12',
      name: 'bourse_chart12',
      component: bourse_chart12,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart13',
      name: 'bourse_chart13',
      component: bourse_chart13,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/bourse/bourse_chart14',
      name: 'bourse_chart14',
      component: bourse_chart14,
      meta: {
        requireAuth: true
      }
    },
    {
      path: '/list',
      name: 'list',
      meta: {
        requireAuth: true,
        title: '列表'
      },
      component: () => import('./views/List.vue')
    },
    {
      path: '/table',
      name: 'table',
      meta: {
        requireAuth: true,
        title: '列表'
      },
      component: table
    },
    {
      path: '/table1',
      name: 'table1',
      meta: {
        requireAuth: true,
        title: '列表'
      },
      component: table1
    },
    {
      path: '/table2',
      name: 'table2',
      meta: {
        requireAuth: true,
        title: '列表'
      },
      component: table2
    },
    {
      path: '/form',
      name: 'form',
      meta: {
        requireAuth: true,
        title: '编辑'
      },
      // route level code-splitting
      // this generates a separate chunk (about.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import( /* webpackChunkName: "form" */ './views/Form.vue')
    }
  ],
})
router.beforeEach((to, from, next) => {
  if (to.matched.some(res => res.meta.requireAuth)) {// 判断是否需要登录权限
    if (localStorage.getItem('token')) {// 判断是否登录 sessionStorage.getItem('token')关闭就重新输入
      next()
    } else {// 没登录则跳转到登录界面
      if(to.redirectedFrom){//vue-router redirect不会刷新页面，需要判断并刷新
        // vm.$router.go(0)//safari浏览器go(0)无效
        window.location.reload()
      }
      next({
        path: '/login'
      })
    }
  } else {
    next()
  }
})
export default router;