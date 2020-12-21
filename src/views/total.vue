<template>
    <div>
      <!-- <div class="txt">
         比特币挖矿成本计算器
      </div> -->
    <el-form ref="form" :model="form" label-width="80px">
      <el-row :gutter="20">
  <el-col :span="12" style="text-align:center;">
    <div style="border: 1px solid #ccc;margin-bottom: 32px;">
    <div class="dth">
      <span>翼比特E11++</span>
      <span class="sp1">矿机名称</span>
      </div>
    <div class="dth">
     <span>44t</span>
     <span class="sp1">矿机算力</span>
      </div>

    <div class="dth">
      <span>1980W</span>
      <span class="sp1">矿机功率</span>
      </div>
      </div>
    </el-col>
    <el-col :span="12" style="text-align:center">
    <div style="border: 1px solid #ccc;">
    <div class="dth">
      <span>1美元={{form.rmb}}人民币</span>
      <span class="sp1">实时汇率</span>
      </div>
    <div class="dth">
     <span>{{form.btcprice.toFixed(2)}}$</span>
     <span class="sp1">BTC美元价格</span>
    </div>
    <div class="dth">
      <span>{{(form.btcprice*form.rmb).toFixed(2)}}CNY</span>
      <span class="sp1">BTC人民币价格</span>
      </div>
      </div>
    </el-col>
</el-row>
  <el-row :gutter="20">
  <el-col :span="12">
    <label>每T收益 1T*24H
    <el-input v-model="form.step1"></el-input>
    </label>
    </el-col>
    <el-col :span="12">
    <label>全网算力
    <el-input v-model="form.step2"></el-input>
    </label>
    </el-col>
</el-row>
<el-row :gutter="20">
  <el-col :span="8">
    <label>电费 per/kwh
    <el-input v-model="form.step3" @blur="counter()" ></el-input>
    </label>
    </el-col>
    <el-col :span="8">
    <label>挖1 btc的成本价
    <el-input v-model="form.step5"></el-input>
    </label>
    </el-col>
    <el-col :span="8">
    <label>约合美金
    <el-input v-model="form.step6"></el-input>
    </label>
    </el-col>
</el-row>
<el-row :gutter="20">
    <el-col :span="8">
    <label>当全网算力变化为现在的
    <el-input v-model="form.step7" @blur="counter2()"></el-input>
    </label>
    </el-col>
    <el-col :span="8">
    <label>挖1 btc的成本价
    <el-input v-model="form.step8"></el-input>
    </label>
    </el-col>
    <el-col :span="8">
    <label>约合美金
    <el-input v-model="form.step9"></el-input>
    </label>
    </el-col>
</el-row>
</el-form>
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
import exportdata from "highcharts/modules/export-data";
import dragpanes from "highcharts/modules/drag-panes";
import indicators from "highcharts/indicators/indicators";
import volumeByPrice from "highcharts/indicators/volume-by-price";
import $ from "jquery";
exporting(Highcharts);
exportdata(Highcharts);
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
        step1: "",
        step2: "",
        step3: "",
        step5: "",
        step6: "",
        step7: "",
        step8: "",
        step9: "",
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
    var _that = this;
    this.$http
      .get("http://trendapi.show-fund.com/get_btc_avg_hashrate/")
      .then(function(data) {
        $(".el-loading-mask").hide();
        //console.log(data.data.btc_hash_rate.length);
        var ohlc = [];
        for (var i = 0; i < data.data.btc_hash_rate.length; i += 1) {
          ohlc.push([
            data.data.btc_hash_rate[i][0] * 1000,
            data.data.btc_hash_rate[i][1]
          ]);
        }
        ////console.log(ohlc);
        _that.charts(ohlc);
      });
  },
  methods: {
    counter() {
      let c1 = (47.52 / (this.form.step2 * 44)) * this.form.step3;
      let c2 = 47.52 / (this.form.step2 * 44);
      localStorage.setItem("step2", this.form.step2);
      console.log(localStorage.step2);
      //console.log(c1);
      this.form.step5 = c1.toFixed(2);
      this.form.step6 = (c1 / this.form.rmb).toFixed(2);
    },
    counter2() {
      let c1 = (47.52 / (this.form.step2 * 44)) * this.form.step3;
      let c2 = 47.52 / (this.form.step2 * 44);
      //console.log(c1);
      this.form.step8 = (c1 * this.form.step7).toFixed(2);
      this.form.step9 = (this.form.step8 / this.form.rmb).toFixed(2);
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
          text: "BTC每日算力"
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
            var content = Y + M + D + h;

            var dy = this.y;
            return (
              "<b>" +
              content +
              "</b> :  <b>" +
              (dy / 1000000000000000000).toFixed(2) +
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
              x: -3
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
      //console.log("submit!");
    }
  },
  created() {
    var that = this;
    this.$http
      .get("http://trendapi.show-fund.com/get_usdcny_exrate/")
      .then(function(data) {
        //console.log(data.data.result);
        that.form.rmb = data.data.result;
      });
    this.$http
      .get("http://trendapi.show-fund.com/btcprice/")
      .then(function(res) {
        console.log(res);
        that.form.btcprice = Number(res.data);
        console.log(that.form.btcprice);
      });
  }
};
</script>

<style scoped>
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
  /* text-align: center; */
}
.dth span {
  display: block;
  text-align: center;
}
.el-input {
    margin-bottom: 32px;
    font-size: 22px;
    font-weight: bold;
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
    background-color: rgba(204, 204, 204, 0.24);
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
    transition: border-color .2s cubic-bezier(.645,.045,.355,1);
    width: 100%;
}
.sp1 {
    font-size: 16px;
}
</style>