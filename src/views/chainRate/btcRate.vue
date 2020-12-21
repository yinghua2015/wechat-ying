<template>
  <div id="app">
    <div class="dq">
      <!-- <div @click="all_time()">全部</div> -->
      <div id="container" style="height:810px"></div>
      <div class="show_load">
        <div class="la-pacman la-2x">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
          <div></div>
        </div>
      </div>
    </div>
    <div class="textP tt">
      <p>红线为BTC价格走势图，单位$。</p>
      <p>蓝线为BTC全网算力走势，单位kH/s。</p>
      <p>算力单位：</p>
      <p>1 kH / s =每秒1,000哈希</p>
      <p>1 MH / s =每秒1,000,000次哈希。</p>
      <p>1 GH / s =每秒1,000,000,000次哈希。</p>
      <p>1 TH / s =每秒1,000,000,000,000次哈希。</p>
      <p>1 PH / s =每秒1,000,000,000,000,000次哈希。</p>
      <p>1 EH / s =每秒1,000,000,000,000,000,000次哈希。</p>
    </div>
    <div class="form-page-show"></div>
    <div class="form-page">
      <el-tabs type="card">
        <el-tab-pane label="日志"></el-tab-pane>
      </el-tabs>
      <div class="wrapper bg-white b">
        <el-form
          :model="ruleForm"
          :rules="rules"
          ref="ruleForm"
          label-width="100px"
          class="demo-ruleForm"
          size="small"
        >
          <el-form-item label="日志内容" prop="desc">
            <el-input type="textarea" v-model="ruleForm.desc"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
            <el-button @click="resetForm('ruleForm')">重置</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>
<style scoped>
.form-page {
  width: 100%;
  display: none;
}
.form-page-show {
  width: 100%;
  display: none;
}
</style>
<script>
import { mapGetters } from "vuex";
import Highcharts from "highcharts/highstock";
import HighchartsMore from "highcharts/highcharts-more";
import HighchartsDrilldown from "highcharts/modules/drilldown";
import Highcharts3D from "highcharts/highcharts-3d";
import Highmaps from "highcharts/modules/map";
import exporting from "highcharts/modules/exporting";
import exportata from "highcharts/modules/export-data";
import HighchartsExporting from "highcharts/modules/exporting";
import $ from "jquery";
exporting(Highcharts);
exportata(Highcharts);
HighchartsMore(Highcharts);
HighchartsDrilldown(Highcharts);
Highcharts3D(Highcharts);
Highmaps(Highcharts);
HighchartsExporting(Highcharts);

// import HighchartsComponent from "../../components/charts/HighchartsComponent";

export default {
  name: "app",
  data() {
    return {
      show2_data: [],
      tableData: [],
      cols: [
        { prop: "name", label: "名称" },
        { prop: "key0", label: "一天" },
        { prop: "key1", label: "1周平均" },
        { prop: "key2", label: "1月平均" },
        { prop: "key3", label: "3月平均" },
        { prop: "key4", label: "6月平均" },
        { prop: "key5", label: "1年平均" }
      ],
      leftPart: [{ name: "BTC资金费率" }, { name: "USDT资金费率" }],
      changeLeftBackground: 0,
      markList: [],
      isShow: false,
      isShow1: false,
      isList2: false,
      isList: false,
      activeNames: ["1"],
      kv: "买SHOW全部交易量",
      kv1: "买SHOW全部交易金额",
      stockChart: null,
      type: "drilldown",
      value1: 0,
      markcontent: [],
      moreSamples: [
        {
          name: "柱形范围图",
          code: "columnrange"
        },
        {
          name: "下钻",
          code: "drilldown"
        },
        {
          name: "3D 饼图",
          code: "3dpie"
        }
      ],

      chart: null,
      options: {
        xAxis: {
          categories: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec"
          ]
        },
        yAxis: {
          title: {
            text: "Temperature"
          },
          lineWidth: 2,
          lineColor: "#F33",
          id: "temperature-axis"
        },
        series: [
          {
            name: "Temperature",
            data: [
              7.0,
              6.9,
              9.5,
              14.5,
              18.2,
              21.5,
              25.2,
              26.5,
              23.3,
              18.3,
              13.9,
              9.6
            ],
            color: "#F33"
          }
        ]
      },
      styles: {
        width: 600,
        height: 400
      },
      //   form start
      ruleForm: {
        name: "",
        region: "",
        date1: "",
        date2: "",
        delivery: false,
        type: [],
        resource: "",
        desc: ""
      },
      rules: {
        name: [
          { required: true, message: "请输入标记名称", trigger: "blur" },
          { min: 3, max: 5, message: "长度在 3 到 5 个字符", trigger: "blur" }
        ],
        region: [
          { required: true, message: "请选择活动区域", trigger: "change" }
        ],
        date1: [
          {
            type: "date",
            required: true,
            message: "请选择日期",
            trigger: "change"
          }
        ],
        date2: [
          {
            type: "date",
            required: true,
            message: "请选择时间",
            trigger: "change"
          }
        ],
        type: [
          {
            type: "array",
            required: true,
            message: "请至少选择一个活动性质",
            trigger: "change"
          }
        ],
        resource: [
          { required: true, message: "请选择活动资源", trigger: "change" }
        ],
        desc: [{ required: true, message: "请填写标记内容", trigger: "blur" }]
      }
    };
  },
  computed: {
    async showOff() {
      let _that = this;
      return new Promise((resolve, reject) => {
        _that.$http
          .get("http://trendapi.show-fund.com/get_btc_avg_hashrate/")
          .then(function(data) {
            $(".el-loading-mask").hide();
            //console.log(data);
            var ohlc = [];
            for (var i = 0; i < data.data.btc_hash_rate.length; i += 1) {
              ohlc.push(data.data.btc_hash_rate[i][1] / 1000);
            }
            _that.show2_data = ohlc;
            console.log(_that.show2_data);
          });
        resolve(ohlc);
      });
    }
  },
  mounted() {
    //let _that = this;
    // async aa() {
    //   const q1 = await showOff();
    //   const q2 = await show1();
    //   console.log(q1)
    //    console.log(q2)
    // }

    // this.$http
    //   .all([
    //      _that.show2(),
    //     _that.show1()
    //   ])
    //   .then(
    //      this.$http.spread(function(acct,perms) {
    //       // 上面两个请求都完成后，才执行这个回调方法
    //     })
    //   );
    this.getAllData();
  },
  methods: {
    all_time() {},
    getAll() {
      let _that = this;
      return new Promise((resolve, reject) => {
        _that.$http
          .get("http://trendapi.show-fund.com/get_btc_avg_hashrate/")
          .then(function(data) {
            $(".el-loading-mask").hide();
            //console.log(data);
            let ohlc = [];
            let ohlc_time = [];
            for (var i = 986; i < data.data.btc_hash_rate.length; i += 1) {
              ohlc.push(data.data.btc_hash_rate[i][1] / 1000);
              ohlc_time.push(data.data.btc_hash_rate[i][0] / 1000);
            }
            _that.show2_data = ohlc;
            resolve(ohlc_time);
            //console.log(_that.show2_data);
          });
      });
    },
    getlog() {
      let _that = this;
      let timestamp = parseInt(new Date().getTime() / 1000);
      return new Promise((resolve, reject) => {
        this.$http
          .get(
            `//trendapi.show-fund.com/getbitstampbtcprice/1313625600/${timestamp}/`
          )
          .then(function(res) {
            let btcRate = res.data.data.kline_data;
            let btcRate_amount = [];
            let btcRate_rate = [];
            console.log(_that.show2_data);
            for (let i = 0; i < btcRate.length; i++) {
              btcRate_amount.push([
                btcRate[i][0] * 1000,
                // Number(btcRate[i][1]),
                // Number(btcRate[i][2]),
                // Number(btcRate[i][3]),
                Number(btcRate[i][4])
              ]);
              btcRate_rate.push([
                btcRate[i][0] * 1000,
                Number((_that.show2_data[i] / 10000000000000000).toFixed(2))
              ]);
            }
            console.log(btcRate_amount);
            console.log(btcRate_rate);
            var names = ["减半走势", "btc算力"];
            var seriesOptions = [
              {
                name: names[0],
                id: "aapl",
                zIndex: 2,
                color: "#ff0000",
                yAxis: 1,
                dataGrouping: {
                  enabled: false
                },
                data: btcRate_amount //红色减半走势 btc价
              },
              {
                name: names[2],
                color: "#0080ff",
                yAxis: 2,
                dataGrouping: {
                  enabled: false
                },
                data: btcRate_rate //btc算力 蓝色
              }
            ];

            _that.createChart(seriesOptions);
            _that.isShow1 = true;
            //_that.table()
            resolve("ok");
            $(".el-loading-spinner").hide();
            return;
          });
      });
    },
    async getAllData() {
      await this.getAll();
      await this.getlog();
    },
    tableRowStyle({ row, column, rowIndex, columnIndex }) {
      //  if (columnIndex === 0) {
      //   return 'background-color: lightblue;color: #fff;font-weight: 500;'
      // }
      return "color: #000;font-weight: 500;";
    },
    tableColStyle({ row, column, rowIndex, columnIndex }) {
      if (columnIndex === 0) {
        return "background-color: pink;color: #fff;font-weight: 500;";
      }
      //return 'background-color: blue'
    },
    // 修改table header的背景色
    tableHeaderColor({ row, column, rowIndex, columnIndex }) {
      //console.log(row, column, rowIndex, columnIndex)
      if (rowIndex === 0) {
        return "background-color: lightblue;color: #fff;font-weight: 500;";
      }
      //return 'background-color: lightblue;color: #fff;font-weight: 500;'
    },
    changeCellStyle({ row, column, rowIndex, columnIndex }) {
      //第八列添加 red 类
      if (rowIndex === 1) {
        return "background-color: lightblue;color: #fff;font-weight: 500;";
      }
      //某一行其中的一个变量applies值如果大于0，并且在第六列，即确定一个具体的单元格需要确定行和列
      if (parseFloat(row.applies) > 0 && columnIndex == 5) {
        return "background-color: lightblue;color: #fff;font-weight: 500;";
      }
    },
    table() {
      var _this = this;
      this.$http
        .get("http://trendapi.show-fund.com/show_okexusdt_report/")
        .then(function(res) {
          console.log(res.data.bitcoin);
          /*市场表现 sub_title*/
          var market_expression = res.data.bitcoin;
          var t_arr = [];
          var obj = {},
            obj_1 = {},
            obj_2 = {},
            obj_3 = {},
            obj_5 = {},
            obj_6 = {};
          for (var i = 0; i < res.data.allvolume.length; i++) {
            eval(
              "obj.key" +
                i +
                "='" +
                _this.get_thousand_num(res.data.allvolume[i].toFixed(0)) +
                " show" +
                "'"
            );
          }
          var o1 = {
            name: "总成交量"
          };
          obj.name = "总成交量";
          console.log(obj);
          var oo1 = obj;
          for (var i = 0; i < res.data.realvolume.length; i++) {
            eval(
              "obj_1.key" +
                i +
                "='" +
                _this.get_thousand_num(res.data.realvolume[i].toFixed(0)) +
                " show" +
                "'"
            );
          }
          var o2 = {
            name: "真实成交量"
          };
          var oo2 = Object.assign(o2, obj_1);
          console.log(oo2);
          for (var i = 0; i < res.data.volumepercent.length; i++) {
            eval(
              "obj_2.key" +
                i +
                "='" +
                _this.get_thousand_num(res.data.volumepercent[i].toFixed(2)) +
                "%" +
                "'"
            );
          }
          var o3 = {
            name: "真实成交量占比"
          };
          var oo3 = Object.assign(o3, obj_2);
          for (var i = 0; i < res.data.allamount.length; i++) {
            eval(
              "obj_3.key" +
                i +
                "='" +
                _this.get_thousand_num(res.data.allamount[i].toFixed(0)) +
                " $" +
                "'"
            );
          }
          var o5 = {
            name: "总成交金额"
          };
          var oo5 = Object.assign(o5, obj_3);
          for (var i = 0; i < res.data.realamount.length; i++) {
            eval(
              "obj_5.key" +
                i +
                "='" +
                _this.get_thousand_num(res.data.realamount[i].toFixed(0)) +
                " $" +
                "'"
            );
          }
          var o6 = {
            name: "真实成交金额"
          };
        
          var oo6 = Object.assign(o6, obj_5);
          for (var i = 0; i < res.data.amountpercent.length; i++) {
            eval(
              "obj_6.key" +
                i +
                "='" +
                _this.get_thousand_num(res.data.amountpercent[i].toFixed(2)) +
                "%" +
                "'"
            );
          }
          var o7 = {
            name: "真实成交金额占比"
          };
          var oo7 = Object.assign(o7, obj_6);
          _this.tableData.push(oo1, oo2, oo3, oo5, oo6, oo7);
          console.log(_this.tableData);
        });
    },
    get_thousand_num(num) {
      return num.toString().replace(/\d+/, function(n) {
        // 先提取整数部分
        return n.replace(/(\d)(?=(\d{3})+$)/g, function($1) {
          // 对整数部分添加分隔符
          return $1 + ",";
        });
      });
    },
    leftChange(index) {
      this.changeLeftBackground = index;
    },
    createChart(seriesOptions, index) {
      var sdk = "BTC算力与减半走势图";
      this.stockChart = new Highcharts.stockChart("container", {
        global: { useUTC: false },
        rangeSelector: {
          inputEnabled: false,
          inputDateFormat: "%Y-%m-%d",
          selected: 5
        },
        title: {
          text: sdk,
          align: "center",
          x: 70
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
            // 第一条Y轴
            labels: {
              format: "{value}\xB0C",
              style: {
                color: Highcharts.getOptions().colors[2]
              }
            },
            title: {
              text: "btc价格",
              style: {
                color: Highcharts.getOptions().colors[2]
              }
            },
            opposite: true
          },
          {
            // 第二条Y轴
            title: {
              text: "",
              style: {
                color: Highcharts.getOptions().colors[0]
              }
            },
            labels: {
              format: "{value} $",
              style: {
                color: Highcharts.getOptions().colors[0]
              }
            }
          },
          {
            // 第三条Y轴
            gridLineWidth: 0,
            title: {
              text: "btc算力",
              style: {
                color: Highcharts.getOptions().colors[1]
              }
            },
            labels: {
              format: "{value} kh/s",
              style: {
                color: Highcharts.getOptions().colors[1]
              }
            },
            opposite: true
          }
        ],
        responsive: {
          rules: [
            {
              condition: {
                maxWidth: 768
              },
              chartOptions: {
                rangeSelector: {
                  selected: 4
                },
                chart: {
                  //type: 'line',
                  zoomType: "y",
                  height: 700
                }
              }
            }
          ]
        },
        plotOptions: {
          series: {
            compare: "percent",
            compareBase: 100,
            showInNavigator: true
          }
        },
        tooltip: {
          valueDecimals: 2,
          split: true,
          followPointer: true,
          followTouchMove: true,
          formatter: function() {
            //console.log(index);
            //console.log(this.points);
            function get_thousand_num(num) {
              return num.toString().replace(/\d+/, function(n) {
                // 先提取整数部分
                return n.replace(/(\d)(?=(\d{3})+$)/g, function($1) {
                  // 对整数部分添加分隔符
                  return $1 + ",";
                });
              });
            }
            var date = new Date(this.x); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
            var Y = date.getFullYear() + "-";
            var M =
              (date.getMonth() + 1 < 10
                ? "0" + (date.getMonth() + 1)
                : date.getMonth() + 1) + "-";
            var D = date.getDate() + " ";
            var h = date.getHours() + ":";
            var m = date.getMinutes();
            var s = date.getSeconds();
            var content = Y + M + D;
            if (index == "1") {
              console.log("显示1");
              return (
                content +
                "<br>" +
                "借币利息:" +
                get_thousand_num(parseInt(this.points[1].y)) +
                " %" +
                "<br>" +
                "借币总额:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                " usdt"
              );
            } else if (index == "0") {
              console.log("显示000000000");
              return (
                content +
                "<br>" +
                "借币利息:" +
                get_thousand_num(parseInt(this.points[1].y)) +
                " %" +
                "<br>" +
                "<br>" +
                "<p>" +
                "借币总额:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                "</p>" +
                " btc"
              );
            }
            return (
              content +
              "<br>" +
              "BTC价格:" +
              get_thousand_num(Number(this.points[0].y).toFixed(2)) +
              " $" +
              "<br>" +
              "<br>" +
              "<p>" +
              "BTC算力:" +
              get_thousand_num(Number(this.points[1].y * 1000).toFixed(2)) +
              "</p>" +
              " K"
            );
          },
          shared: true
        },
        series: seriesOptions
      });
    },
    allData(kv, index) {
      this.changeLeftBackground = index;
      var that = this;
      //console.log(index);
      if (index == "0") {
        console.log("进入0");
        let _that = this;
        let timestamp = new Date().getTime();
        this.$http
          .get(`//trendapi.show-fund.com/bfxlendingdata/0/${timestamp}/1/`)
          .then(function(res) {
            console.log(res.data.bfx_lending_data);
            let btcRate = res.data.bfx_lending_data.btc;
            let btcRate_amount = [];
            let btcRate_rate = [];
            for (let i = 0; i < btcRate.length; i++) {
              btcRate_amount.push([
                btcRate[i][0] * 1000,
                Number(btcRate[i][1])
              ]);
              btcRate_rate.push([btcRate[i][0] * 1000, Number(btcRate[i][2])]);
            }
            console.log(btcRate_amount);
            console.log(btcRate_rate);
            var names = ["借币总额", "借币利息"];
            var seriesOptions = [
              {
                name: names[0],
                color: "#ff0000",
                data: btcRate_amount //红色总额
              },
              {
                name: names[2],
                color: "#0080ff", //蓝色利息
                data: btcRate_rate
              }
            ];

            _that.createChart(seriesOptions, index);
            _that.isShow1 = true;
            //_that.table()
            $(".el-loading-spinner").hide();
            return;
          });
      } else if (index == "1") {
        console.log("进入1");
        let _that = this;
        let timestamp = new Date().getTime();
        this.$http
          .get(`//trendapi.show-fund.com/bfxlendingdata/0/${timestamp}/1/`)
          .then(function(res) {
            //console.log(res.data.bfx_lending_data);
            let usdRate = res.data.bfx_lending_data.usd;
            let usdRate_amount = [];
            let usdRate_rate = [];
            for (let i = 0; i < usdRate.length; i++) {
              usdRate_amount.push([
                usdRate[i][0] * 1000,
                Number(usdRate[i][1])
              ]);
              usdRate_rate.push([usdRate[i][0] * 1000, Number(usdRate[i][2])]);
            }
            var names = ["借币总额", "借币利息"];
            var seriesOptions = [
              {
                name: names[0],
                color: "#ff0000",
                data: usdRate_amount //红色总额
              },
              {
                name: names[2],
                color: "#0080ff", //蓝色利息
                data: usdRate_rate
              }
            ];

            _that.createChart(seriesOptions, index);
            _that.isShow1 = true;
            //_that.table()
            $(".el-loading-spinner").hide();
            return;
          });
      }
    }
  },
  created() {
    if (window.innerWidth < 500) {
      if (this.$store.getters.asideFolded == false) {
        $("#app").attr("class", "aside-folded");
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.highcharts-range-selector-buttons {
  display: none;
}
.dq {
  margin: 0 !important;
}
.tt {
  text-align: left;
  margin: 0px auto;
  width: 350px;
}
@media screen and (max-width: 768px) {
  .dq {
    margin-top: 40px !important;
  }
}

.aa {
  width: 250px;
  margin: 10;
}
.liBackground {
  background: -webkit-gradient(
    linear,
    0 0,
    0 100%,
    from(#4ac10394),
    to(#d43e2f)
  );
  color: #000;
}
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

.box {
  width: 100%;
  height: 900px;
  display: inline-block;
  border: 1px solid #ccc;
  overflow: hidden;
  position: relative;

  h3 {
    position: absolute;
    top: -10px;
    left: 10px;
    z-index: 1000;
  }
}
.show_load {
  position: absolute;
  z-index: 999999;
  width: 300px;
  height: 80px;
  left: 50%;
  margin-left: -150px;
  text-align: center;
  top: 30%;
  font-size: 36px;
  background: #0000004a;
  line-height: 80px;
  border-radius: 10px;
  color: blueviolet;
  display: none;
}
</style>
