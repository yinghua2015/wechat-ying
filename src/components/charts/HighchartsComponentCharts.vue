<template>
  <div id="app">

    <div class="box">
      <!-- <h3>股票图</h3> -->
      <div id="container"></div>
      <button @click="updateStcockChart" :disabled="!stockChart"></button>
      <div class="show_load">        <div class="la-pacman la-2x">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
        </div></div>
    </div>
    <div class="form-page-show">
        1111111111111111
        <!-- <el-tabs type="card">
          <el-tab-pane label="已标记"></el-tab-pane>
        </el-tabs>
        <div class="wrapper bg-white b">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm" size="small">
              <el-form-item label="标记名称" prop="name" required>
                <el-input v-model="ruleForm.name"></el-input>
              </el-form-item>

              <el-form-item label="标记时间" required>
                  <el-form-item prop="date2">
                    <el-date-picker type="date" placeholder="选择时间" v-model="ruleForm.date2" style="width: 50%;display:inline-block;"></el-date-picker>
                    <el-time-select
                    v-model="ruleForm.data1"
                    :picker-options="{
                      start: '00:00',
                      step: '00:60',
                      end: '24:00'
                    }"
                    style="width: 50%;display:inline-block;"
                    placeholder="选择时间">
                  </el-time-select>
                  </el-form-item>
              </el-form-item>

              <el-form-item label="标记内容" prop="desc">
                <el-input type="textarea" v-model="ruleForm.desc"></el-input>
              </el-form-item>
            </el-form>
        </div> -->
        </div>
    <div class="form-page">
        <el-tabs type="card">
          <el-tab-pane label="日志"></el-tab-pane>
        </el-tabs>
        <div class="wrapper bg-white b">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm" size="small">
              <!-- <el-form-item label="标记名称" prop="name" required>
                <el-input v-model="ruleForm.name"></el-input>
              </el-form-item> -->

              <!-- <el-form-item label="标记时间" required>
                  <el-form-item prop="date2">
                    <el-date-picker type="date" placeholder="选择时间" v-model="ruleForm.date2" style="width: 50%;display:inline-block;"></el-date-picker>
                    <el-time-select
                    v-model="ruleForm.data1"
                    :picker-options="{
                      start: '00:00',
                      step: '00:60',
                      end: '24:00'
                    }"
                    style="width: 50%;display:inline-block;"
                    placeholder="选择时间">
                  </el-time-select>
                  </el-form-item>
              </el-form-item> -->

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

export default {
  name: "app",
  data() {
    return {
      markList: [],
      isList2:false,
      isList: false,
      activeNames: ["1"],
      stockChart: null,
      type: "drilldown",
      value1: 0,
      markcontent:[],
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
      chart:null,
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
    HighchartsComponent
  },
  mounted() {
    this.createChart();
    //   this.moreChart();
    //   this.highmaps();
  },
  methods: {
      timeer(time_e){
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
    createChart() {
    const _this = this;
      Highcharts.setOptions({
        lang: {
          rangeSelectorZoom: ""
        }
      });
      var endTime = Date.parse(new Date());
      var urt_dev = "/goods/list";
      var urt_pro =
        "http://trendapi.show-fund.com/pricedata/1535808486000/" + endTime;
        ////trendapi.show-fund.com/add_time_mark/

      $.ajax({
        type: "get",
        url: urt_dev,
        dataType: "json",
        beforeSend: function() {
          $(".show_load").show();
        },
        success: function(data) {
          console.log(data);
          var txt_title = "价格";
          if (window.innerWidth<500){
                   txt_title = null;
            }else{
                 txt_title = "价格";
          }
          var ohlc = [],
            volume = [],
            dataLength = data.okex_show.show_eth.length,
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
              data.okex_show.show_eth[i][0],
              Number(data.okex_show.show_eth[i][1]) // the date
            ]);
          }
          // create the chart
          Highcharts.setOptions({
        lang: {
          rangeSelectorZoom: ""
        },
        global: {
                useUTC: false
        }
      });
this.stockChart = new Highcharts.stockChart("container", {
            chart: {
              //type: 'line',
              zoomType: 'y'
            },
            rangeSelector: {
              selected: 0,
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
              text: "okex_show_eth"
            },
            tooltip: {
                    followTouchMove:false,
                    zoomType: 'y',
                    panning: true,
                    panKey: 'shift',
              formatter: function() {
                console.log(_this)
                console.log(this)
                //$('.form-page').hide();
                _this.value1 = this.x;
                const timecore = this.x
                console.log(_this.value1)
                _this.get_time(timecore)
                $('.form-page-show').show();
                $('.form-page-show').html('<span style="font-size: 20px;">' +'日志时间：'+ _this.timeer(this.x) + "</span><br/>"+'<span style="font-size: 20px;">' +'日志：'+ '<span id="sp_write">'+'无日志内容'+'</span>' + "</span><br/>");
                var content =
                  '<span style="font-size: 20px;">' + this.y + "</span><br/>";
                var content1 = '<span style="font-size: 20px;"></span><br/>';
                for (var i = 0; i < this.points.length; i++) {
                  content1 +=
                    '<span style="color: ' +
                    this.points[i].series.color +
                    '">' +
                    this.points[i].series.name +
                    "</span>: " +
                    this.points[i].y.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') +
                    "<br/>";
                  var date = new Date(this.points[i].key); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
                  var Y = date.getFullYear() + "-";
                  var M =
                    (date.getMonth() + 1 < 10
                      ? "0" + (date.getMonth() + 1)
                      : date.getMonth() + 1) + "-";
                  var D = date.getDate() + " ";
                  var h = date.getHours() + ":00";
                  var m = date.getMinutes();
                  var s = date.getSeconds();
                  content = Y + M + D + h;
                  return content + content1;

                }
              }
            },
            scrollbar: {
                    enabled: true,
            },
            xAxis: {
              crosshair: {
                  width: 2,
                  color: 'red',
                  dashStyle: 'shortdot'
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
                  color: 'red',
                  dashStyle: 'shortdot'
                },
title: {
                  text: txt_title
                },
                //height: '60%',
                lineWidth: 0
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
                // type: 'column',
                name: "okex_show_eth",
                color: "green",
                lineColor: "green",
                upColor: "red",
                upLineColor: "red",

                events: {
                                  mouseOver: function(e) {
                    console.log(e);
                    console.log(this);
                    const timecore =  _this.value1;
                    console.log(_this.value1);
                    _this.get_time(timecore);
                    $(".form-page-show").hide();
                    $(".form-page-show").show();
                    $(".form-page-show").html(
                      '<span style="font-size: 20px;">' +
                        "日志时间：" +
                        _this.timeer(_this.value1) +
                        "</span><br/>" +
                        '<span style="font-size: 20px;">' +
                        "日志：" +
                        '<span id="sp_write">' +
                        "无日志内容" +
                        "</span>" +
                        "</span><br/>"
                    );
                    var content =
                      '<span style="font-size: 20px;">' +
                      this.y +
                      "</span><br/>";
                    var content1 =
                      '<span style="font-size: 20px;"></span><br/>';
                    for (var i = 0; i < this.points.length; i++) {
                      content1 +=
                        '<span style="color: ' +
                        this.points[i].series.color +
                        '">' +
                        this.points[i].series.name +
                        "</span>: " +
                        this.points[i].y
                          .toFixed(1)
                          .replace(/(\d)(?=(\d{3})+\.)/g, "$1,") +
                        "<br/>";
                      var date = new Date(this.points[i].key); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
                      var Y = date.getFullYear() + "-";
                      var M =
                        (date.getMonth() + 1 < 10
                          ? "0" + (date.getMonth() + 1)
                          : date.getMonth() + 1) + "-";
                      var D = date.getDate() + " ";
                      var h = date.getHours() + ":00";
                      var m = date.getMinutes();
                      var s = date.getSeconds();
                      content = Y + M + D + h;
                      return content + content1;
                    }
                  },
                  click: function(e) {
                    //alert(e.point.category);
                    alert("启动智能标记模式")
                    $('.form-page').show();
                    //$('.form-page-show').html(this.y);
                    }
                },
                // tooltip: {},
                data: ohlc,
                dataGrouping: {
                  enabled: false
                }
              }
            ]
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
    get_time(timecore){
       console.log(this);
    $.ajax({
                        type: "get",
                        url: "http://trendapi.show-fund.com/get_time_mark/"+timecore+'/okex_show_eth/okex_show_eth',
                        dataType: "json",
                        success: function (response) {
                        console.log(response+"查询标记信息")
                        $("#sp_write").html(response.mark_content_list[0])
                        //console.log(_that.markcontent)
                        }
                    });

    },
    add_time(post_data){
        console.log(this)
        console.log(post_data+"-----post_data")
        const _this = this;
        $.ajax({
              type: "post",
              url: "http://trendapi.show-fund.com/add_time_mark/",
              data: post_data,
              dataType: "json",
              success: function (response) {
                  if(response.errcode === 0 ){
                     // console.log(_this+"-----------486")
                    //   alert(_that+"-----that")
                      alert("标记成功!");$('.form-page').hide();
                    //   $.ajax({
                    //     type: "get",
                    //     url: "http://trendapi.show-fund.com/get_time_mark/"+response.time+'/btc充值/btc充值',
                    //     dataType: "json",
                    //     success: function (response) {
                    //     console.log(response+"查询标记信息")
                    //    //_that.markcontent = response.mark_content_list
                    //    // console.log(_that.markcontent)
                    //     }
                    // });
                     // get_time()

                  }else{
                      alert("标记失败!");
                  }

              }
          });
    },
    submitForm(formName) {
        console.log(this);
         console.log(this.value1);

      var _that = this;
      console.log(22, this.$refs[formName].model.desc);
      this.$refs[formName].validate(valid => {
        if (valid) {
          var post_data = {
            mark_time:this.value1,
            coin_type:"okex_show_eth",
            trend_type:"okex_show_eth",
            mark_content:this.$refs[formName].model.desc
          }
        //var timecore = this.value1;
         this.add_time(post_data)
          //this.get_time(timecore)
        } else {
          console.log("errcode submit!!");
          return false;
        }
      });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    }
  },
  created(){
      if (window.innerWidth<500) { if(this.$store.getters.asideFolded == false){
          $('#app').attr('class','aside-folded')}
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
