<template>
  <div>
    <div class="txt" style="font-size:16px">
      <pre class="dl0">
已知全网平均每T算力一天收益的BTC数量（数据来源：btc.com），则计算收益单位BTC所需算力耗费的电费成本即是挖矿成本（该成本不包括购买矿机的费用及矿机损耗费）。

矿机算力（单位：T）  矿机功率（单位：KW/H） 电费（元/KWH ）每T收益（1T*24H=**BTC）

              矿机功率（单位：KW/H）*24H*电费（元/KWH ）
1 BTC挖矿成本= —————————————————————————————————————
              矿机算力* 每T收益（1T*24H=**BTC)

矿机数据来源：www.f2pool.com
</pre>
      <div class="dl1">
        <pre class="s1">
蚂蚁S17 Pro      发布时间： 2019/04
矿机算力： 53 T   矿机功耗： 2094 W

</pre>
        <pre>
翼比特E11++      发布时间： 2018/10
矿机算力： 44 T   矿机功耗： 1980 W

</pre>
        <pre>
蚂蚁S9           发布时间： 2016/07
矿机算力： 13 T   矿机功耗： 1300 W

</pre>
      </div>
    </div>
    <el-form ref="form" :model="form" label-width="80px">
      <el-row :gutter="20">
        <el-col :span="12" style="text-align:center;height:94px">
          <div style="border: 1px solid #ccc;margin-bottom: 32px;height:94px">
            <div class="dth">
              <input style="width:146px" type="text" v-model="form.s1" />
              <!-- 翼比特E11++ -->
              <span class="sp1">矿机名称</span>
            </div>
            <div class="dth">
              <input style="width:40px" type="text" v-model="form.s2" />
              <i>T</i>
              <span class="sp1">矿机算力</span>
            </div>

            <div class="dth">
              <input style="width:60px" type="text" v-model="form.s3" />
              <i>W</i>
              <span class="sp1">矿机功率</span>
            </div>

            <div class="dth">
              <el-button @click="onSubmit()">确定</el-button>
            </div>
          </div>
        </el-col>
        <el-col :span="12" style="text-align:center;height:94px">
          <div style="border: 1px solid #ccc;height:94px">
            <div class="dth">
              <span>1美元={{form.rmb}}人民币</span>
              <span class="sp1">实时汇率</span>
            </div>
            <div class="dth">
              <span>{{form.btcprice}}$</span>
              <span class="sp1">BTC美元价格</span>
            </div>
            <div class="dth">
              <span>{{parseInt(form.btcprice*form.rmb)}}CNY</span>
              <span class="sp1">BTC人民币价格</span>
            </div>
          </div>
        </el-col>
      </el-row>
      <el-row :gutter="20">
        <el-col :span="5">
          <label>每T收益 1T*24H=**BTC</label>
          <el-input v-model="form.step1"></el-input>
        </el-col>
        <el-col :span="3">
          <label class="b1"></label>
          <el-button @click="counter3()">确定</el-button>
        </el-col>
        <el-col :span="8">
          <label>全网算力EH/S</label>
          <el-input v-model="form.step2"></el-input>
        </el-col>
        <el-col :span="8">
          <label>挖矿收益率</label>
          <el-input v-model="form.step12"></el-input>
        </el-col>
      </el-row>
      <el-row :gutter="20">
        <el-col :span="5">
          <label>电费 元/KWH</label>
          <el-input v-model="form.step3"></el-input>
        </el-col>
        <el-col :span="3">
          <label class="b1"></label>
          <el-button @click="counter()">确定</el-button>
        </el-col>
        <el-col :span="8">
          <label>挖1btc的人民币成本价</label>
          <el-input v-model="form.step5"></el-input>
        </el-col>
        <el-col :span="8">
          <label>约合美金</label>
          <el-input v-model="form.step6"></el-input>
        </el-col>
      </el-row>
      <el-row :gutter="20">
        <el-col :span="5">
          <label>当全网算力变化为现在的</label>
          <el-input v-model="form.step7"></el-input>
        </el-col>
        <el-col :span="3">
          <label class="b1"></label>
          <el-button @click="counter2()">确定</el-button>
        </el-col>
        <el-col :span="8">
          <label>挖1btc的人民币成本价</label>
          <el-input v-model="form.step8"></el-input>
        </el-col>
        <el-col :span="8">
          <label>约合美金</label>
          <el-input v-model="form.step9"></el-input>
        </el-col>
      </el-row>
    </el-form>

    <div style="margin:10px">
      全网算力每日变化。算力表示每秒计算哈希碰撞的次数，由此图可观察全网平均算力的变化趋势。未来算力上涨，则挖矿难度增加，单位算力的产量将同比降低。总体来讲，算力的涨跌趋势与币价的涨跌正相关，与矿机价格的涨跌负相关。
      <br />数据来源：//btc.tokenview.com/cn/chart/dailyHashrate
    </div>
    <div id="container" style="height:900px"></div>
  </div>
</template>

<script>
import Highcharts from "highcharts/highstock";
import HighchartsMore from "highcharts/highcharts-more";
import HighchartsDrilldown from "highcharts/modules/drilldown";
import Highcharts3D from "highcharts/highcharts-3d";
import Highmaps from "highcharts/modules/map";
import exporting from "highcharts/modules/exporting";
import dragpanes from "highcharts/modules/drag-panes";
import indicators from "highcharts/indicators/indicators";
import volumeByPrice from "highcharts/indicators/volume-by-price";
import $ from "jquery";
exporting(Highcharts);
HighchartsMore(Highcharts);
HighchartsDrilldown(Highcharts);
Highcharts3D(Highcharts);
Highmaps(Highcharts);
export default {
  data() {
    return {
      form: {
        btcprice: "",
        rmb: "",
        s1: "翼比特E11++",
        s2: "44",
        s3: "1980",
        step1: "",
        step2: "",
        step3: "",
        step5: "",
        step6: "",
        step7: "",
        step8: "",
        step9: "",
        step12: "",
        name: "",
        region: "",
        date1: "",
        date2: "",
        delivery: false,
        type: [],
        resource: "",
        desc: ""
      }
    };
  },
  mounted() {
    this.into()
  },
  methods: {
    async into() {
      await this.kuangji();
      await this.get_btc_avg_hashrate();
    },
    kuangji() {
      let _that = this;
      return new Promise((resolve, reject) => {
        _that.$http
          .get("http://trendapi.show-fund.com/get_app_common_config/kuangji/")
          .then(function(res) {
            resolve(res);
            _that.form.step1 = res.data.data.everyT;
            _that.form.step7 = res.data.data.all_internet;
            _that.form.step3 = res.data.data.ele;
            _that.form.step5 = res.data.data.step5;
            _that.form.step6 = res.data.data.step6;
            _that.form.step8 = res.data.data.step8;
            _that.form.step9 = res.data.data.step9;
          });
      });
    },
    get_btc_avg_hashrate() {
      console.log(111111111111)
      let _that = this;
      return new Promise((resolve, reject) => {
        _that.$http
          .get("http://trendapi.show-fund.com/get_btc_avg_hashrate/")
          .then(function(data) {
            resolve(data);
            $(".el-loading-mask").hide();
            console.log(data);
            var ohlc = [];
            for (var i = 0; i < data.data.btc_hash_rate.length; i += 1) {
              ohlc.push([
                data.data.btc_hash_rate[i][0],
                data.data.btc_hash_rate[i][1] / 1000
              ]);
              _that.form.step2 = (
                Number(
                  data.data.btc_hash_rate[data.data.btc_hash_rate.length - 1][1]
                ) / 1000000000000000000
              ).toFixed(2);
            }
            console.log(ohlc);
            _that.charts(ohlc);
            _that.tsq();
          })
      });
    },
    tsq() {
      this.form.step12 =
        ((Number(this.form.btcprice) / Number(this.form.step6) - 1) * 100).toFixed(2) +
        "%";
        console.log(this.form.step12)
    },
    counter() {
      let c1 = 47.52 * this.form.step3; //电费step3
      let c2 = this.form.step1 * 44; //t收益
      localStorage.setItem("step1", c2);
      localStorage.setItem("step2", this.form.step2);
      this.form.step5 = (c1 / c2).toFixed(2);
      this.form.step6 = (this.form.step5 / this.form.rmb).toFixed(2);
      var that = this;
      const push_data = {
        name: "kuangji",
        data: {
          name: this.form.s1,
          power: this.form.s2,
          rote: this.form.s3,
          everyT: this.form.step1,
          ele: this.form.step3,
          all_internet: this.form.step7,
          step5: this.form.step5,
          step6: this.form.step6,
          step8: this.form.step8,
          step9: this.form.step9
        }
      };
      this.$http
        .post(
          "http://trendapi.show-fund.com/update_app_common_config/",
          push_data
        )
        .then(function(res) {
          //alert(res.data.message);
        });
    },
    counter2() {
      let c1 = 47.52 * this.form.step3;
      let c2 = this.form.step1 * 44;
      // localStorage.setItem("step77", this.form.step7);
      // localStorage.setItem(
      //   "step88",
      //   (this.form.step5 * this.form.step7).toFixed(2)
      // );
      // localStorage.setItem(
      //   "step99",
      //   (this.form.step8 / this.form.rmb).toFixed(2)
      // );
      this.form.step7 = this.form.step7;
      this.form.step8 = (this.form.step5 * this.form.step7).toFixed(2);
      this.form.step9 = (this.form.step8 / this.form.rmb).toFixed(2);
      var that = this;
      const push_data = {
        name: "kuangji",
        data: {
          name: this.form.s1,
          power: this.form.s2,
          rote: this.form.s3,
          everyT: this.form.step1,
          ele: this.form.step3,
          all_internet: this.form.step7,
          step5: this.form.step5,
          step6: this.form.step6,
          step8: this.form.step8,
          step9: this.form.step9
        }
      };
      this.$http
        .post(
          "http://trendapi.show-fund.com/update_app_common_config/",
          push_data
        )
        .then(function(res) {
          console.log(res);
          //alert(res.data.message);
        });
    },
    counter3() {
      var that = this;
      const push_data = {
        name: "kuangji",
        data: {
          name: this.form.s1,
          power: this.form.s2,
          rote: this.form.s3,
          everyT: this.form.step1
        }
      };
      this.$http
        .post(
          "http://trendapi.show-fund.com/update_app_common_config/",
          push_data
        )
        .then(function(res) {
          //alert(res.data.message);
        });
    },
    charts(ohlc) {
      this.stockChart = new Highcharts.stockChart("container", {
        chart: {
          //type: 'line',
          zoomType: "y"
        },
        global: { useUTC: true },
        rangeSelector: {
          selected: 1,
          buttonTheme: {
            display: "none" // 不显示按钮
          },
          allButtonsEnabled: false,
          // inputDateFormat: "%Y-%m-%d",
          // inputEditDateFormat: "%Y-%m-%d",
          enabled: false,
          buttons: [
            {
              type: "day",
              count: 7,
              text: "7d"
            },
            {
              type: "month",
              count: 1,
              text: "1m"
            },
            {
              type: "month",
              count: 3,
              text: "3m"
            },
            {
              type: "month",
              count: 6,
              text: "6m"
            },
            {
              type: "year",
              count: 1,
              text: "1y"
            },
            {
              type: "all",
              text: "All"
            }
          ]
        },
        title: {
          text: "BTC每日平均算力"
        },
        tooltip: {
          followTouchMove: false,
          zoomType: "y",
          panning: true,
          panKey: "shift",
          formatter: function(e) {
            ////console.log(e);
            //console.log(this.y);
            // //console.log(this.y/1000000000000000);
            // parseInt(this.y/1000)
            var date = new Date(this.x); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
            var Y = date.getFullYear() + "-";
            var M =
              (date.getMonth() + 1 < 10
                ? "0" + (date.getMonth() + 1)
                : date.getMonth() + 1) + "-";
            var D = date.getDate() + " ";
            var h = date.getHours() + ":00";
            var m = date.getMinutes();
            var s = date.getSeconds();
            var content = Y + M + D;

            var dy = this.y;
            console.log(this.y);
            return (
              "<b>" +
              content +
              "</b>   <b>" +
              (dy / 1000000000000000).toFixed(2) +
              "EH/s" +
              "</b>"
            );
          }
        },
        xAxis: {
          crosshair: {
            width: 2,
            color: "red",
            dashStyle: "shortdot"
          },
          dateTimeLabelFormats: {
            millisecond: "%H:%M:%S.%L",
            second: "%H:%M:%S",
            minute: "%H:%M",
            hour: "%H:%M",
            day: "%m/%d",
            week: "%m/%d",
            month: "%y/%m",
            year: "%Y"
          }
        },
        yAxis: [
          {
            labels: {
              align: "right",
              x: -3,
              formatter: function() {
                return this.value / 1000000000000000 + "EH";
              }
            },
            crosshair: {
              width: 2,
              color: "red",
              dashStyle: "shortdot"
            },
            title: {
              text: "BTC算力 EH/s"
            },
            //height: '60%',
            lineWidth: 2
          }
          // , {
          //     labels: {
          //         align: 'right',
          //         x: -3
          //     },
          //     title: {
          //         text: '成交量'
          //     },
          //     top: '65%',
          //     height: '35%',
          //     offset: 0,
          //     lineWidth: 2
          // }
        ],
        series: [
          {
            type: "area",
            name: "BTC算力",
            lineColor: Highcharts.getOptions().colors[1],
            color: Highcharts.getOptions().colors[2],
            fillOpacity: 0.5,
            upColor: "red",
            upLineColor: "red",
            events: {
              click: function(e) {
                //alert(e.point.category);
                alert("启动智能标记模式");
                $(".form-page").show();
                //$('.form-page-show').html(this.y);
              }
            },
            // tooltip: {},
            data: ohlc
            // dataGrouping: {
            //   enabled: false
            // }
          }
        ]
      });
    },
    onSubmit() {
      var that = this;
      const push_data = {
        name: "kuangji",
        data: {
          name: this.form.s1,
          power: this.form.s2,
          rote: this.form.s3,
          everyT: this.form.step1,
          ele: this.form.step3,
          all_internet: this.form.step7,
          step5: this.form.step5,
          step6: this.form.step6,
          step8: this.form.step8,
          step9: this.form.step9
        }
      };
      this.$http
        .post(
          "http://trendapi.show-fund.com/update_app_common_config/",
          push_data
        )
        .then(function(res) {
          //alert(res.data.message);
          that.$http
            .get("http://trendapi.show-fund.com/get_app_common_config/kuangji/")
            .then(function(res) {
              // that.form.s1 = res.data.data.name;
              // that.form.s2 = res.data.data.power;
              // that.form.s3 = res.data.data.rote;
            });
        });
      //console.log("submit!");
    }
  },
  created() {
    console.log('created')
    if (window.innerWidth < 500) {
      if (this.$store.getters.asideFolded == false) {
        $("#app").attr("class", "aside-folded");
      }
    }
    console.log(this.$store.getters._isMobile);
    // this.into()
    var that = this;
    this.$http
      .get("http://trendapi.show-fund.com/get_usdcny_exrate/")
      .then(function(data) {
        //console.log(data.data.result);
        that.form.rmb = data.data.result;
      });

    var that = this;
    this.$http
      .get("http://trendapi.show-fund.com/get_app_common_config/kuangji/")
      .then(function(res) {
        that.form.s1 = res.data.data.name;
        that.form.s2 = res.data.data.power;
        that.form.s3 = res.data.data.rote;
      });
    this.$http
      .get("http://trendapi.show-fund.com/btcprice/")
      .then(function(res) {
        console.log(res);
        that.form.btcprice = Number(res.data).toFixed(2);
        console.log(that.form.btcprice);
      });
  }
};
</script>

<style scoped>
.cell {
  font-size: 16px !important;
}
a {
  color: #3498db !important;
}
input[type="button"] {
  float: right;
  border: 0;
  background: hsla(0, 0%, 80%, 0.54);
  border-radius: 3px;
  outline: none;
}
input {
  overflow: visible;
  font-size: 18px;
}
label {
  height: 50px;
  width: 100px;
  display: inline-block;
}
.txt {
  font-size: 36px;
  font-family: inherit;
  font-weight: 500;
  line-height: 1.1;
  color: inherit;
}
.dth {
  display: inline-block;
  padding: 10px;
  font-size: 26px;
}
.dth span {
  display: block;
  text-align: center;
}
.el-input {
  margin-bottom: 32px;
  font-size: 22px;
  font-weight: 700;
}
label {
  font-size: 16px;
  padding-left: 15px;
}
.el-form {
  margin-top: 30px;
}
.el-input__inner {
  -webkit-appearance: none;
  background-color: hsla(0, 0%, 80%, 0.24);
  background-image: none;
  border-radius: 4px;
  border: 1px solid #dcdfe6;
  box-sizing: border-box;
  color: #000;
  display: inline-block;
  font-size: inherit;
  height: 40px;
  line-height: 40px;
  outline: 0;
  padding: 0 15px;
  transition: border-color 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);
  width: 100%;
}
.sp1 {
  font-size: 16px;
}
pre.dl0 {
  height: 180px;
  width: 60%;
  float: left;
  margin-right: 15rem;
}
.b1 {
  width: 507px;
}
.dth button {
  position: relative;
  bottom: 1rem;
}
pre.dl0 {
  height: 180px;
  width: 60%;
  float: left;
  margin-right: 15rem;
}
.b1 {
  width: 507px;
}
.dth button {
  position: relative;
  bottom: 1rem;
}
</style>