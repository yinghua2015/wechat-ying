<template>
    <div class="aside-wrap">
        <div class="logo"><router-link to="/"></router-link></div>
        <div class="menu-wrap">
            <el-menu :default-active="activePath" class="el-menu-vertical-demo" @open="handleOpen" @close="handleClose" :collapse="isCollapse" unique-opened background-color="#324157" text-color="#B4BCCC" active-text-color="#fff" style="border-right:0" router>
                <el-submenu :index="'group-'+key" v-for="(value, key) in navData" :key="key">
                    <template slot="title">
                        <i :class="value.icon"></i>
                        <span slot="title" v-text="value.group"></span>
                    </template>
                    <el-menu-item :index="value.href" v-for="(value, key) in value.list" :key="key" :route="{path:value.href}" v-text="value.name"></el-menu-item>
                </el-submenu>

            </el-menu>
        </div>
    </div>
</template>
<style>
.el-submenu {
  list-style: none;
  margin: 0;
  padding-left: 0;
  text-align: left;
}
</style>
<script>
import $ from "jquery";
export default {
  data() {
    return {
      navData: [
        {
          icon: "el-icon-menu",
          group: "链上数据",
          list: [
            {
              href: "/chain/chart01",
              name: "BTC链上转账数额"
            },
            {
              href: "/chain/chart02",
              name: "BTC链上转账笔数"
            },
            {
              href: "/chain/chart09",
              name: "BTC活跃地址数"
            },
            {
              href: "/chain/chart10",
              name: "BTC新增地址数"
            },
            {
              href: "/chain/chart03",
              name: "ETH链上转账数额"
            },
            {
              href: "/chain/chart04",
              name: "ETH链上转账笔数"
            },
            {
              href: "/chain/chart11",
              name: "ETH活跃地址数"
            },
            {
              href: "/chain/chart12",
              name: "ETH新增地址数"
            },
            {
              href: "/chain/chart05",
              name: "USDT链上转账数额"
            },
            {
              href: "/chain/chart06",
              name: "USDT链上转账笔数"
            },
            {
              href: "/chain/chart07",
              name: "SHOW链上转账数额"
            },
            {
              href: "/chain/chart08",
              name: "SHOW链上转账笔数"
            }
          ]
        },
        {
          icon: "el-icon-menu",
          group: "交易所数据",
          list: [
            {
              href: "/bourse/bourse_chart07",
              name: "流入交易所BTC数额"
            },
            {
              href: "/bourse/bourse_chart08",
              name: "流出交易所BTC数额"
            },
            {
              href: "/bourse/bourse_chart09",
              name: "交易所BTC净流入数额"
            },
            {
              href: "/bourse/bourse_chart01",
              name: "流入交易所ETH数额"
            },
            {
              href: "/bourse/bourse_chart02",
              name: "流出交易所ETH数额"
            },
            {
              href: "/bourse/bourse_chart12",
              name: "交易所ETH净流入数额"
            },
            {
              href: "/bourse/bourse_chart10",
              name: "流入交易所USDT数额"
            },
            {
              href: "/bourse/bourse_chart11",
              name: "流出交易所USDT数额"
            },
            {
              href: "/bourse/bourse_chart13",
              name: "交易所USDT净流入数额"
            },
            {
              href: "/bourse/bourse_chart03",
              name: "流入交易所SHOW数额"
            },
            {
              href: "/bourse/bourse_chart04",
              name: "流出交易所SHOW数额"
            },
            {
              href: "/bourse/bourse_chart14",
              name: "交易所SHOW净流入数额"
            },
            {
              href: "/bourse/bourse_chart05",
              name: "交易所内的秀币总量"
            },
            {
              href: "/bourse/bourse_chart06",
              name: "OKEx内的秀币总量"
            }
          ]
        },
        {
          icon: "el-icon-menu",
          group: "行情图表",
          list: [
            {
              href: "/okex_show/coinmarket_btc",
              name: "BTC/USDT"
            },
            {
              href: "/okex_show/coinmarket_eth",
              name: "ETH/USDT"
            },
            {
              href: "/okex_show/okex_show_btc",
              name: "SHOW/BTC"
            },
            {
              href: "/okex_show/okex_show",
              name: "SHOW/ETH"
            },
            {
              href: "/okex_show/okex_show_usdt",
              name: "SHOW/USDT"
            }
          ]
        },
        // {
        //   icon: "el-icon-menu",
        //   group: "ethscan内部",
        //   list: [
        //     {
        //       href: "/ethscan",
        //       name: "秀币持仓排行榜"
        //     },
        //     {
        //       href: "/show_day_all",
        //       name: "show每日冲提"
        //     },
        //     // {
        //     //   href: "/btc_dt",
        //     //   name: "BTC挖矿成本"
        //     // },
        //     {
        //       href: "/counter",
        //       name: "BTC成本计算器"
        //     },
        //     // {
        //     //   href: "/escanTable",
        //     //   name: "escanTable"
        //     // }
        //   ]
        // },
        // {
        //   icon: "el-icon-menu",
        //   group: "BTC减半行情图",
        //   list: [
        //     {
        //       href: "/k_line/k_line_btc",
        //       name: "BTC减半行情图"
        //     },
        //     {
        //       href: "/k_line/k_line_btc_2",
        //       name: "BTC减半行情图02"
        //     }
        //   ]
        // },
        {
          icon: "el-icon-menu",
          group: "数据图",
          list: [
            {
              href: "/btcOnline/total_1",
              name: "数字货币总市值图"
            },
            {
              href: "/btcOnline/total_2",
              name: "总市值图(除比特币)"
            },
            {
              href: "/k_line/k_line_btc_2",
              name: "比特币走势预测图"
            },
            {
              href: "/marketPerformance",
              name: "数字货币市场表现"
            },
            {
              href: "/btcOnline/btcOnline",
              name: "BTC市值趋势图"
            },
            {
              href: "/btcOnline/btcPrice",
              name: "BTC价格与24节气"
            },
            {
              href: "/k_line/k_line_btc",
              name: "BTC减半行情图"
            },
            {
              href: "/counter",
              name: "BTC成本计算器"
            },
            {
              href: "/table1",
              name: "USDT区块链浏览器"
            },
            {
              href: "/table2",
              name: "USDT增发销毁记录"
            },
            {
              href: "/chainRate/btcRate",
              name: "BTC算力与减半走势图"
            },
            {
              href: "/coinmetrics",
              name: "coinmetrics.io"
            },
          ]
        },
        {
          icon: "el-icon-menu",
          group: "合约数据",
          list: [
            {
              href: "/chainRate/usdtRate",
              name: "Bitfinex资金费率"
            }
          ]
        },
        {
          icon: "el-icon-menu",
          group: "秀币数据",
          list: [
            {
              href: "/table",
              name: "秀币链上交易记录"
            },
            {
              href: "/ethscan",
              name: "秀币持仓排行榜"
            },
            {
              href: "/show_day_all",
              name: "SHOW每日充提"
            },
            {
              href: "/show201",
              name: "SHOW交易数据"
            },
            {
              href: "/show202",
              name: "SHOW换手率"
            },
            {
              href: "/show203",
              name: "SHOW多空比"
            },
            {
              href: "/showApp",
              name: "SHOWapp充值提现"
            },
          ]
        }
        // {
        //     icon:'el-icon-menu',
        //     group:'模板',
        //     list:[
        //         {
        //             href:'/list',
        //             name:'列表'
        //         },
        //         {
        //             href:'/form',
        //             name:'表单'
        //         }
        //     ]
        // },
        // {
        //     icon:'el-icon-message',
        //     group:'其他',
        //     list:[
        //         {
        //             href:'/foo2',
        //             name:'foo2'
        //         }
        //     ]
        // }
      ],
      isCollapse: false
    };
  },
  methods: {
    handleOpen(key, keyPath) {
      console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      console.log(key, keyPath);
    }
  },
  computed: {
    activePath() {
      var path = this.$route.path;
      var light = this.$route.meta.light;
      var param = this.$route.meta.param;
      if (light) {
        path = light;
        if (param) {
          path = path + "/" + this.$route.params[param];
        }
      }
      return path;
    }
  }
};
</script>