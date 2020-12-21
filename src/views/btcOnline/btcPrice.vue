<template>
  <div id="app">

    <div class="box" style="height:900px">
      <!-- <h3>股票图</h3> -->
      <div id="container" style="height:900px"></div>
      <button  :disabled="!stockChart">更新数据范围</button>
      <div class="show_load">        <div class="la-pacman la-2x">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
        </div></div>
    </div>
    <div class="p-txt">选取Coinmarketcap上BTC的价格走势图，在时间线上标记出24节气。BTC价格数据来源：//coinmarketcap.com/currencies/bitcoin/</div>
<div v-show="isList2">
        <el-collapse>
          <el-collapse-item :title="tagTxt+item.label_content" :name="index"  v-for="(item, index) in labelList">
            <div v-html="item.label_content"></div>
            <div class="t-btn">
              <div>编辑于：{{item.update_time}}</div>
              <el-button type="button" @click="updata_new_2(item.record_id,item.label_content)">更新</el-button>
              <el-button type="button" @click="delete_time_mark_2(item.record_id)">删除</el-button>
              <updata2  v-show="isshow2" ref="updata2" v-on:reload="exchange" :isday="isday" :typeNameNew="typeNameNew" :markTime="value1" :contentlabel="content2"  :recordlabel="record_id2" :isList="isList" :timesBengin="times_begin" :yAxi="yAxi"></updata2>
            </div>
          </el-collapse-item>
        </el-collapse>
    </div>
    <div v-show="isList">
      <!--v-for="itemColor in activeBackground" v-bind:style="{ background: itemColor }" -->
        <el-collapse   v-for="(item, index) in markList">
          <el-collapse-item :title="index+1+logsTag+item.topic_content" :name="index" v-if="item.priority === 1" style="background:red !important">
            <div v-html="item.mark_content" ></div>
            <div class="t-btn">
              <div>编辑于：{{item.update_time}}</div>
              <el-button type="button" @click="updata_new(item.record_id,item.mark_content,item.topic_content)">更新</el-button>
              <el-button type="button" @click="delete_time_mark(item.record_id)">删除</el-button>

            <updata  v-show="isshow" ref="updata" v-on:reload="exchange" :isday="isday" :typeNameNew="typeNameNew" :markTime="value1" :content="content" :topText="topic_content" :record="record_id" :isList="isList" :timesBengin="times_begin" :yAxi="yAxi"></updata>
            </div>
          </el-collapse-item>
          <el-collapse-item :title="index+1+logsTag+item.topic_content" :name="index" v-if="item.priority === 2" style="background:#0080ff !important">
            <div v-html="item.mark_content" ></div>
            <div class="t-btn">
              <div>编辑于：{{item.update_time}}</div>
              <el-button type="button" @click="updata_new(item.record_id,item.mark_content,item.topic_content)">更新</el-button>
              <el-button type="button" @click="delete_time_mark(item.record_id)">删除</el-button>

            <updata  v-show="isshow" ref="updata" v-on:reload="exchange" :isday="isday" :typeNameNew="typeNameNew" :markTime="value1" :content="content" :topText="topic_content" :record="record_id" :isList="isList" :timesBengin="times_begin" :yAxi="yAxi"></updata>
            </div>
          </el-collapse-item>
          <el-collapse-item :title="index+1+logsTag+item.topic_content" :name="index" v-if="item.priority === 3" style="background:#eaeaea !important">
            <div v-html="item.mark_content" ></div>
            <div class="t-btn">
              <div>编辑于：{{item.update_time}}</div>
              <el-button type="button" @click="updata_new(item.record_id,item.mark_content,item.topic_content)">更新</el-button>
              <el-button type="button" @click="delete_time_mark(item.record_id)">删除</el-button>

            <updata  v-show="isshow" ref="updata" v-on:reload="exchange" :isday="isday" :typeNameNew="typeNameNew" :markTime="value1" :content="content" :topText="topic_content" :record="record_id" :isList="isList" :timesBengin="times_begin" :yAxi="yAxi"></updata>
            </div>
          </el-collapse-item>
        </el-collapse>
    </div>
    <div class="form-page">
        <!-- <el-tabs type="card">
          <el-tab-pane label="日志"></el-tab-pane>
        </el-tabs> -->
        <div class="wrapper bg-white b">
           <editer ref="editer" v-on:reload="exchange" :isday="isday" :typeNameNew="typeNameNew" :markTime="value1" :isList="isList" :timesBengin="times_begin" :yAxi="yAxi"></editer>
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
import exportData from "highcharts/modules/export-data";

import $ from "jquery";
exporting(Highcharts);
exportData(Highcharts);
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
      solar: [],
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
      typeNameNew: "xiubi-show-usdt",
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
  watch: {
    times: function(val) {
      //
      //console.log(val + "时间改变");
      this.isday = val;
      //this.createChart();
      this.exchange();
    }
    // ex: function(val) {
    //   this.trend_type = val;
    //   //console.log(this.trend_type);
    //   if (val === "Okex") {
    //     var localcontent = "btc-out-ok";
    //     this.typeNameNew = "btc-out-ok";
    //     this.$store.commit("typeNewAll",this.typeNameNew);
    //     this.exchange();
    //   } else if (val === "Huobi") {
    //     var localcontent = "btc-out-hb";
    //     this.typeNameNew = "btc-out-hb";
    //     this.$store.commit("typeNewAll",this.typeNameNew);
    //     this.exchange();
    //   } else if (val === "Bitfinex") {
    //     var localcontent = "btc-out-btf";
    //     this.typeNameNew = "btc-out-btf";
    //     this.$store.commit("typeNewAll",this.typeNameNew);
    //     this.exchange();
    //   } else if (val === "Binance") {
    //     var localcontent = "btc-out-bin";
    //     this.typeNameNew = "btc-out-bin";
    //     this.$store.commit("typeNewAll",this.typeNameNew);
    //     this.exchange();
    //   } else if (val === "all") {
    //     var localcontent = "btc-out-all";
    //     this.typeNameNew = "btc-out-all";
    //     this.$store.commit("typeNewAll",this.typeNameNew);
    //     this.exchange();
    //   }
    // }
  },
  mounted() {
    this.solar_terms();
    $(".aside-wrap").show();
    $(".header").show();
    this.typeNameNew = "xiubi-show-usdt";
    this.$store.commit("typeNewAll", this.typeNameNew);
    var _this = this;
    setTimeout(function() {
      _this.exchange();
    }, 2000);
  },
  methods: {
    solar_terms() {
      var _this = this;
      var endTime = new Date().getTime() + 182 * 24 * 3600 * 1000;
      this.$http
        .get(
          "http://trendapi.show-fund.com/get_jieqi/1312156800000/" +
            endTime +
            "/"
        )
        .then(function(res) {
          console.log(res.data);
          var flag_all = [];
          for (var i = 0; i < res.data.length; i++) {
            var t_label = {
              label: {
                text: res.data[i].title, //标签的内容
                align: "left", //标签的水平位置，水平居左,默认是水平居中center
                x: 10 //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
              },
              color: "#9e9e9e", //线的颜色，定义为红色
              dashStyle: "longdashdot", //标示线的样式，默认是solid（实线），这里定义为长虚线
              value: res.data[i].x, //定义在哪个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
              width: 2 //标示线的宽度，2px
            };
            _this.solar.push(t_label);
          }
          console.log(_this.solar);
        });
    },
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
    exchange() {
      this.isshow2 = false;
      this.isshow = false;
      this.isList = false;
      const _that = this;
      var endTime = Date.parse(new Date());
      this.$http
        .get(
          "http://trendapi.show-fund.com/get_time_mark_count_in_range/0/" +
            endTime +
            "/" +
            this.$store.getters.times +
            "/" +
            this.typeNameNew +
            "/" +
            this.typeNameNew
        )
        .then(function(response) {
          //console.log(response);
          //console.log(_that);
          var res = response.data.content_in_range;
          var flag_content = [];
          var flag = [];
          var i = 0;
          var colorAll = [];
          var colorful;
          // {
          // 			x: 1525968000000,
          // 			title: '3'
          // 	}
          for (i; i < res.length; i += 1) {
            flag_content.push({
              x: res[i].mark_time,
              title: res[i].count
            });

            for (var t = 0; t < res[i].content_list.length; t += 1) {
              if (res[i].content_list[t].priority === 3) {
                colorful = "#eaeaea";
              } else if (res[i].content_list[t].priority === 2) {
                colorful = "#0080ff";
              } else if (res[i].content_list[t].priority === 1) {
                colorful = "red";
              }
              colorAll.push(colorful);
              _that.activeBackground = colorAll;
              console.log(_that.activeBackground);
              flag.push({
                type: "flags",
                tooltip: {
                  enabled: false
                },
                data: [
                  {
                    x: res[i].mark_time,
                    title: res[i].count
                  }
                ],
                color: colorful,
                fillColor: colorful,
                onSeries: "dataseries",
                shape: "squarepin"
              });
            }
          }
          _that.get_label(flag);
        });
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
    createChart(flag, flag2) {
      //console.log(flag);
      const _this = this;
      var endTime = parseInt(
        (new Date().getTime() + 182 * 24 * 3600 * 1000) / 1000
      );
      var urt_dev = "/goods/btc-out";
      var urt_pro =
        "http://trendapi.show-fund.com/getbitstampbtcprice/1312156800/" +
        endTime;
      // var urt_pro =
      //   "http://trendapi.show-fund.com/get_btc_day_amount" +
      //   "/" +
      //   "0/" +
      //   endTime +
      //   "/" +
      //   this.$store.getters.times;

      $.ajax({
        type: "get",
        url: urt_pro,
        dataType: "json",
        beforeSend: function() {
          $(".show_load").show();
        },
        success: function(data) {
          //console.log(data);
          var txt_title = "美元";
          if (window.innerWidth < 500) {
            txt_title = null;
          } else {
            txt_title = "美元";
          }
          var ohlc = [],
            series = [],
            series_all = [],
            volume = [],
            _flag = [],
            dataLength = data.data.kline_data.length,
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
            // ohlc.push([
            //   data.btc_day_tx_amount[i][0],
            //   parseInt(Number(data.btc_day_tx_amount[i][1])) // the date
            // ]);

            ohlc.push([
              data.data.kline_data[i][0] * 1000,
              data.data.kline_data[i][4]
            ]);
          }
          series_all.push({
            type: "line",
            name: "BTC价格与24节气",
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
          var call = series_all.concat(flag);
          console.log(call);
          //console.log(_flag);
          // create the chart
          Highcharts.setOptions({
            lang: {
              rangeSelectorZoom: "",
              printChart: "打印图表",
              downloadJPEG: "下载 JPEG 文件",
              downloadPDF: "下载 PDF  文件",
              downloadPNG: "下载 PNG  文件",
              downloadSVG: "下载 SVG  文件",
              downloadCSV: "下载 CSV  文件",
              downloadXLS: "下载 XLS  文件",
              viewData: "查看数据表格"
            },
            navigation: {
              menuItemStyle: {
                padding: "6px 14px"
              }
            },
            exporting: {
              url: "http://export.highcharts.com.cn"
            },
            credits: {
              text: "简数科技",
              url: "http://jianshukeji.com"
            },
            global: {
              useUTC: false
            }
          });
          this.stockChart = new Highcharts.stockChart(
            "container",
            {
              chart: {
                //type: 'line',
                height:900,
                renderTo: "container",
                zoomType: "y"
              },
              exporting: {
                filename: "数据"
              },
              rangeSelector: {
                selected: 4,
                // buttonTheme: {
                // display: 'none' // 不显示按钮
                // },
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
                text: "BTC价格与24节气"
              },
              annotations: [
                {
                  labelOptions: {
                    backgroundColor: "rgba(86, 77, 77, 0.16)",
                    style: {
                      fontSize: "1.2em",
                      textOutline: "1px white",
                      color: "red"
                    },
                    verticalAlign: "top",
                    y: 15
                  },
                  labels: flag2
                }
              ],
              tooltip: {
                followTouchMove: false,
                zoomType: "y",
                panning: true,
                panKey: "shift",
                formatter: function() {
                  const logsContent = this.y;
                  const timeNow = this.x;
                  _this.value1 = this.x;
                  _this.yAxi = this.y;
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
                  console.log(content);
                  _this.times_begin = content;
                  _this.get_time(timeNow, content, logsContent);
                  var re = /(?=(?!(\b))(\d{3})+$)/g;
                  var dy = String(this.y).replace(re, ",");
                  return "<b>" + content + "</b>  :  <b>" + dy +' $'+ "</b>";
                }
              },
              xAxis: {
                plotLines: _this.solar,
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
                    x: -10
                  },
                  crosshair: {
                    width: 2,
                    color: "red",
                    dashStyle: "shortdot"
                  },
                  title: {
                    text: txt_title
                  },
                  lineWidth: 2
                }
              ],
              series: call,
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
            },
            function() {
              // setTimeout(function() {
              // 	$('.highcharts-contextbutton').click();
              // }, 200);
            }
          );
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
    },
    reload() {
      this.isshow2 = false;
      this.isshow = false;
      this.isList = false;
      this.exchange();
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
  height: 400px;
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
