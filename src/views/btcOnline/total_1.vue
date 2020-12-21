<template>
  <div id="app">

    <div class="box">
      <!-- <h3>股票图</h3> -->
      <div id="container" style="height:900px"></div>
      <button @click="updateStcockChart" :disabled="!stockChart">更新数据范围</button>
      <div class="show_load">        <div class="la-pacman la-2x">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
        </div></div>
   </div>
   <div>Coinmarketcap统计全部数字货币的总市值及交易量数据。当前某币种总市值=当前流总通量*当前价。数据来源：//coinmarketcap.com/zh/charts/</div>
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
import { Loading, Message } from "element-ui";
import { mapGetters } from "vuex";
import Highcharts from "highcharts/highstock";
import HighchartsMore from "highcharts/highcharts-more";
import HighchartsDrilldown from "highcharts/modules/drilldown";
import Highcharts3D from "highcharts/highcharts-3d";
import Highmaps from "highcharts/modules/map";
import exporting from "highcharts/modules/exporting";
import exportata from "highcharts/modules/export-data";
import $ from "jquery";
exporting(Highcharts);
exportata(Highcharts);
HighchartsMore(Highcharts);
HighchartsDrilldown(Highcharts);
Highcharts3D(Highcharts);
Highmaps(Highcharts);

import HighchartsComponent from "../../components/charts/HighchartsComponent";
import editer from "../../components/charts/editer";
import updata from "../../components/charts/updata";
import updata2 from "../../components/charts/updata2";

export default {
  name: "app",
  data() {
    return {
      logsTag: "   日志：",
      yAxi: "",
      tagTxt: "标签：",
      tags: "",
      content2: "",
      record_id2: "",
      isshow2: false,
      labelList: [],
      times_begin: "",
      topic_content: "",
      content: "",
      record_id: "",
      markList: [],
      isshow: false,
      isList2: false,
      isList: false,
      activeNames: ["1"],
      typeNameNew: "show-in-ok",
      htmlall: "",
      markcontent: [],
      flagsName: [],
      stockChart: null,
      type: "drilldown",
      isday: "1",
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
  components: {
    HighchartsComponent,
    editer,
    updata,
    updata2
  },
  computed: {
    ...mapGetters(["times"]),
    ...mapGetters(["ex"])
  },
  mounted() {
    this.$store.commit("typeNewAll", this.typeNameNew);
    this.createChart();
  },
  methods: {
    get_label(flag) {
      console.log("进入getlabel");
      const _that = this;
      var endTime = Date.parse(new Date());
      this.$http
        .get(
          "http://trendapi.show-fund.com/get_time_label_in_range/0/" +
            endTime +
            "/" +
            this.typeNameNew +
            "/" +
            this.typeNameNew
        )
        .then(function(response) {
          //console.log(response);
          //console.log(_that);
          var res = response.data.content_in_range;
          var flag_content = {};
          var flag2 = [];
          var i = 0;
          // {
          // 			x: 1525968000000,
          // 			title: '3'
          // 	}
          for (i; i < res.length; i += 1) {
            flag2.push({
              point: {
                xAxis: 0,
                yAxis: 0,
                x: res[i].mark_time,
                y: Number(res[i].user_data)
              },
              x: -60,
              y: -30,
              text: res[i].label_content
            });
          }
          console.log(flag2);
          _that.createChart(flag, flag2);
        });
    },
    updata_new_2(record_id, label_content) {
      this.content2 = label_content;
      console.log(label_content);
      this.record_id2 = record_id;
      this.isshow2 = true;
    },
    delete_time_mark_2(record_id) {
      //console.log(record_id)
      var _this = this;
      this.$http
        .get(
          "http://trendapi.show-fund.com/delete_time_label/" + record_id + "/"
        )
        .then(function(res) {
          _this.isList = false;
          _this.isshow = false;
          _this.reload();
        });
    },
    updata_new(record_id, mark_content, topic_content) {
      console.log(record_id);
      console.log(mark_content);
      this.content = mark_content;
      this.record_id = record_id;
      this.topic_content = topic_content;
      this.isshow = true;
    },
    delete_time_mark(record_id) {
      //console.log(record_id)
      var _this = this;
      this.$http
        .get(
          "http://trendapi.show-fund.com/delete_time_mark/" + record_id + "/"
        )
        .then(function(res) {
          _this.isList = false;
          _this.isshow = false;
          _this.reload();
        });
    },
    handleChange(val) {
      //console.log(val);
    },

    timeer(time_e) {
      var date = new Date(time_e); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
      var Y = date.getFullYear() + "-";
      var M =
        (date.getMonth() + 1 < 10
          ? "0" + (date.getMonth() + 1)
          : date.getMonth() + 1) + "-";
      var D = date.getDate() + " ";
      var h = date.getHours() + ":00";
      var m = date.getMinutes();
      var s = date.getSeconds();
      return Y + M + D + h;
    },
    updateChart() {
      // 通过 refs 获取组件信息
      this.$refs.simpleChart.chart.series[0].update({
        color: "#000"
      });
    },
    updateStcockChart() {
      var rangeSelector = this.stockChart.rangeSelector,
        selected = rangeSelector.selected,
        total = rangeSelector.buttons.length;
      selected++;
      if (selected >= total) {
        selected = 0;
      }

      this.stockChart.rangeSelector.clickButton(selected);
    },
    createChart(flag, flag2) {
      //console.log(flag);
      const _this = this;
      Highcharts.setOptions({
        lang: {
          rangeSelectorZoom: ""
        }
      });
      var endTime = Date.parse(new Date());
      var urt_dev = "/goods/show-in";
      var urt_pro = "http://trendapi.show-fund.com/cmkapi/";

      $.ajax({
        type: "post",
        data: {
          url: "http://graphs2.coinmarketcap.com/global/marketcap-total/"
        },
        url: urt_pro,
        dataType: "json",
        beforeSend: function() {
          $(".show_load").show();
        },
        success: function(data) {
          console.log(data);
          if (data.errcode < 0) {
            _this.$alert(data.message);
          }
          var txt_title = "交易额";
          if (window.innerWidth < 500) {
            txt_title = null;
          } else {
            txt_title = "交易额";
          }
          var ohlc = [],
            series = [],
            series_all = [],
            volume = [],
            _flag = [],
            dataLength = data.market_cap_by_available_supply.length,
            volume_usd_length = data.volume_usd_length,
            // set the allowed units for data grouping
            groupingUnits = [
              [
                "week", // unit name
                [1] // allowed multiples
              ],
              ["month", [1, 2, 3, 4, 6]]
            ],
            i = 0;

          for (i; i < dataLength; i += 1) {
            ohlc.push([
              parseInt(Number(data.market_cap_by_available_supply[i][0])),
              parseInt(data.market_cap_by_available_supply[i][1]),
              // the date
            ]);
            volume.push([
              parseInt(Number(data.volume_usd[i][0])),
              data.volume_usd[i][1]
              // the date
            ]);
          }

          console.log(ohlc);
          console.log(volume);

          series_all.push({
            type: "column",
            name: "BTC市值趋势图",
            data: ohlc,
            id: "dataseries",
            color: "green",
            lineColor: "green",
            upColor: "red",
            upLineColor: "red",
            events: {
              click: function(e) {
                alert("启动智能标记模式");
                _this.value1 = e.point.options.x;
                _this.yAxi = e.point.options.y;
                _this.isList = false;
                $(".form-page").show();
              }
            },
            dataGrouping: {
              enabled: false
            }
          });
          var call = series_all;
          console.log(call);
          //console.log(_flag);
          // create the chart
          Highcharts.setOptions({
            lang: {
              rangeSelectorZoom: "",
              printChart:'打印图表',
                downloadJPEG:'下载 JPEG 文件',
                downloadPDF: '下载 PDF  文件',
                downloadPNG: '下载 PNG  文件',
                downloadSVG: '下载 SVG  文件',
                downloadCSV: '下载 CSV  文件',
                downloadXLS: '下载 XLS  文件',
                viewData: '查看数据表格'
            },
            navigation:{
                menuItemStyle:{
                    padding:'6px 14px'
                }
            },
            exporting:{
                url:'//export.highcharts.com.cn'
            },
            credits:{
                text:'简数科技',
                url:'//jianshukeji.com'
            },
            global: {
              useUTC: false
            }
          });
          this.stockChart = new Highcharts.stockChart("container", {
            rangeSelector: {
              selected: 5,
              // buttonTheme: {
              // display: 'none' // 不显示按钮
              // },
              inputEnabled: false,
              allButtonsEnabled: true,
              inputDateFormat: "%Y-%m-%d",
              inputEditDateFormat: "%Y-%m-%d",
              enabled: true,
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
              text: "数字货币总市值图"
            },
            yAxis: [
              {
                startOnTick: false,
                endOnTick: false,
                labels: {
                  align: "right",
                  x: -3
                },
                title: {
                  text: "市值"
                },
                height: "60%",
                lineWidth: 2,
                resize: {
                  enabled: true
                }
              },
              {
                labels: {
                  align: "right",
                  x: -3
                },
                title: {
                  text: "24小时交易量"
                },
                top: "65%",
                height: "35%",
                offset: 0,
                lineWidth: 2
              }
            ],
            tooltip: {
              split: true,
              followTouchMove: false,
              zoomType: "y",
              panning: true,
              panKey: "shift",
              xDateFormat: '%Y-%m-%d',
              valueSuffix: ' $',
            },
            plotOptions: {
              series: {
                dataGrouping: {
                  units: groupingUnits
                }
              }
            },
            series: [
              {
                type: "",
                name: "市值",
                id: "aapl",
                zIndex: 2,
                data: ohlc,
                dataGrouping: {
                  enabled: false
                }
              },
              {
                type: "column",
                name: "总量",
                id: "volume",
                data: volume,
                yAxis: 1,
                dataGrouping: {
                  enabled: false
                }
              }
            ],
            responsive: {
                rules: [{
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
                        height:700
                    },
                  }
                }]
            }
          });
          //chart.hideLoading();
          $(".show_load").hide();
          return;
        }
      });
    },

    moreChart() {
      var options = this.getMoreOptions(this.type);

      if (this.chart) {
        this.chart.destroy();
      }

      this.chart = new Highcharts.Chart("highcharts-more", options);
    },
    get_time(timeNow, content, logsContent) {
      console.log(logsContent);
      if (this.$store.getters.times == 1) {
        //console.log("一天");
        var endtimecore = Number(timeNow) + 86400000 - 1000;
        this.get_mark(timeNow, content, logsContent, endtimecore);
        this.get_mark2(timeNow, content, logsContent, endtimecore);
      } else if (this.$store.getters.times == 0) {
        //console.log("一小时");
        var endtimecore = this.value1;
        this.get_mark(timeNow, content, logsContent, endtimecore);
        this.get_mark2(timeNow, content, logsContent, endtimecore);
      }
    },
    get_mark(timeNow, content, logsContent, endtimecore) {
      var _that = this;
      $.ajax({
        type: "get",
        url:
          "http://trendapi.show-fund.com/get_time_mark_in_range/" +
          this.value1 +
          "/" +
          endtimecore +
          "/" +
          this.typeNameNew +
          "/" +
          this.typeNameNew,
        dataType: "json",
        success: function(response) {
          console.log("进入mark1");
          //console.log("进入日志了" + response);
          if (response.content_in_range.length === 0) {
            _that.isList = false;
            _that.isList2 = false;
          } else {
            _that.markList = response.content_in_range;
            _that.isList = true;
          }
        }
      });
    },

    get_mark2(timeNow, content, logsContent, endtimecore) {
      var _that = this;
      $.ajax({
        type: "get",
        url:
          "http://trendapi.show-fund.com/get_time_label_in_range/" +
          this.value1 +
          "/" +
          endtimecore +
          "/" +
          this.typeNameNew +
          "/" +
          this.typeNameNew,
        dataType: "json",
        success: function(response) {
          //console.log("进入日志了" + response);
          console.log("进入mark2");
          if (response.content_in_range.length === 0) {
            _that.isList = false;
            _that.isList2 = false;
          } else {
            _that.labelList = response.content_in_range;
            _that.isList2 = true;
          }
        }
      });
    }
  },
  created() {
    //console.log(this.$store);
    // if (
    //   this.$store.getters.times === "1" && this.$store.getters.ex === "Okex") {
    //   this.createChart();
    // }
    if (window.innerWidth < 500) {
      if (this.$store.getters.asideFolded == false) {
        $("#app").attr("class", "aside-folded");
      }
    }
  }
};
</script>

<style lang="scss">
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
