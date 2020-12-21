<template>
  <div id="app">
    <div class="dq">
      <!-- <h3>股票图</h3> -->
      <el-button
        v-for="(list,index) in leftPart"
        class="aa"
        :class="{ liBackground:changeLeftBackground == index}"
        @click="allData(list.name,index)"
      >{{list.name}}</el-button>
      <div class="tb"  v-if="isShow1">
      <el-button @click="tochange(11)">真实成交量</el-button>
      <el-button @click="tochange(12)">全部成交量</el-button>
      </div>
      <div class="tb"  v-if="isShow">
      <el-button @click="tochange(6)">真实交易金额</el-button>
      <el-button @click="tochange(8)">全部交易金额</el-button>
      </div>
      <div style="clear:both"></div>
      <div id="container" style="height:810px"></div>
      <!-- <button @click="updateStcockChart" :disabled="!stockChart"></button> -->
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
    <div class="textP" style="text-align:center" v-if="isShow">
      <p>黑线为每日SHOW全部交易金额</p>
      <p>红线为每日SHOW真实交易金额</p>
      <p>数据日期为：2018年7月1日～至今</p>
    </div>
    <div class="textP" style="text-align:center" v-if="isShow1">
      <p>黑线为每日SHOW全部交易量</p>
      <p>红线为每日SHOW真实交易量</p>
      <p>数据日期为：2018年7月1日～至今</p>
      <p></p>
    </div>

    <div class="table_main">
      <el-table
        :data="tableData"
        style="width: 100%"
        :row-style="tableRowStyle"
        :cell-style="tableColStyle"
        :header-cell-style="tableHeaderColor"
        :cell-class-name="changeCellStyle"
      >
        <el-table-column v-for="col in cols" :prop="col.prop" :label="col.label"></el-table-column>
      </el-table>
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
      dData:"",
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
      leftPart: [{ name: "OKEx内SHOW交易量" }, { name: "OKEx内SHOW交易金额" }],
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
  components: {},
  mounted() {
    var startTime = "1338163200";
    var endTime = "1484006400";
    var flag = [
      {
        x: 1351382400,
        title: "11111111111111111"
      }
    ];
    var flagend = [
      {
        x: 1470758400,
        title: "2222222222222"
      }
    ];
    let _that = this;
    let timestamp = (new Date()).getTime();
    this.$http
      .get(
          `//trendapi.show-fund.com/showusdt_okdeal_amount_all/0/${timestamp}/1/`
      )
      .then(function(res) {
        //console.log(res.data.askamount);
        var names = [
          "SHOW全部交易量",
          "SHOW真实交易金额",
          "SHOW真实交易量",
          "SHOW真实交易金额"
        ];
        var seriesOptions = [
          {
            name: names[0],
            color: "#ff0000",
            data: res.data.realvolume
          },
          {
            name: names[2],
            color: "#000000",
            data: res.data.allvolume
          }
        ];

        _that.createChart(seriesOptions);
        _that.isShow1 = true;
        _that.table()
        $(".el-loading-spinner").hide();
        return;
      });
    //   this.moreChart();
    //   this.highmaps();
  },
  methods: {
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
              obj_6 = {}
          for (var i = 0; i < res.data.allvolume.length; i++) {
            eval(
              "obj.key" + i + "='" + _this.get_thousand_num(res.data.allvolume[i].toFixed(0)) + " show" + "'"
            );
          }
          var o1 = {
            name: "总成交量"
          };
          obj.name ="总成交量";
          console.log(obj)
          var oo1 = obj;
          for (var i = 0; i < res.data.realvolume.length; i++) {
            eval(
              "obj_1.key" + i + "='" + _this.get_thousand_num(res.data.realvolume[i].toFixed(0))+ " show" + "'"
            );
          }
          var o2 = {
            name: "真实成交量"
          };
          var oo2 = Object.assign(o2, obj_1);
          console.log(oo2)
          for (var i = 0; i < res.data.volumepercent.length; i++) {
            eval(
              "obj_2.key" + i + "='" + _this.get_thousand_num(res.data.volumepercent[i].toFixed(2)) + "%" + "'"
            );
          }
          var o3 = {
            name: "真实成交量占比"
          };
          var oo3 = Object.assign(o3, obj_2);
          for (var i = 0; i < res.data.allamount.length; i++) {
            eval(
              "obj_3.key" + i + "='" + _this.get_thousand_num(res.data.allamount[i].toFixed(0))+ " $" + "'"
            );
          }
          var o5 = {
            name: "总成交金额"
          };
          var oo5 = Object.assign(o5, obj_3);
          for (var i = 0; i < res.data.realamount.length; i++) {
            eval(
              "obj_5.key" + i + "='" + _this.get_thousand_num(res.data.realamount[i].toFixed(0)) + " $" + "'"
            );
          }
          var o6 = {
            name: "真实成交金额"
          };
          var oo6 = Object.assign(o6, obj_5);
           for (var i = 0; i < res.data.amountpercent.length; i++) {
            eval(
              "obj_6.key" + i + "='" + _this.get_thousand_num(res.data.amountpercent[i].toFixed(2)) + "%" + "'"
            );
          }
          var o7 = {
            name: "真实成交金额占比"
          };
          var oo7 = Object.assign(o7, obj_6);
          _this.tableData.push(oo1,oo2,oo3,oo5,oo6,oo7);
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
      var sdk = "";
      if (index == 0) {
        var sdk = "OKEx内SHOW交易量";
      } else if (index == 1) {
        var sdk = "OKEx内SHOW交易金额";
      } else {
        var sdk = "OKEx内SHOW交易量";
      }
      this.stockChart = new Highcharts.stockChart("container", {
        global: { useUTC: false },
        rangeSelector: {
          // inputEnabled: false,
          inputDateFormat: "%Y-%m-%d",
          selected: 0
          // buttonTheme: {
          //   display: "none" // 不显示按钮
          // }
          // buttonTheme: {
          // display: 'none' // 不显示按钮
          // },
          // allButtonsEnabled: false,
          // inputDateFormat: "%Y-%m-%d",
          // inputEditDateFormat: "%Y-%m-%d",
          // enabled: true,
        },
        // yAxis: {
        //   labels: {
        //     formatter: function() {
        //       return (this.value > 0 ? " + " : "") + this.value + "%";
        //     }
        //   },
        //   plotLines: [
        //     {
        //       value: 0,
        //       width: 2,
        //       color: "silver"
        //     }
        //   ]
        // },
        title: {
          text: sdk,
          align: "center",
          x: 70
        },
        plotOptions: {
          series: {
            // type:'type',
            //compare: "percent",
            showInNavigator: true
          }
        },
        xAxis: {
          type: "datetime",
          title: {
            enabled: false
          }
        },
        yAxis: {
          title: {
            text: ""
          },
          labels: {
            enabled: false
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
            if(index == "11"){
                  return (
                content +
                "<br>" +
                "<p>" +
                "SHOW真实交易量:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                "</p>" +
                " show"
              );
            }else if (index == "12") {
              return (
                content +
                "<br>" +
                "<p>" +
                "SHOW全部交易量:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                " show"
              );
            } else if(index == "6"){
              return (
                content +
                "<br>" +
                "SHOW真实交易金额:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                " $"
              );
            }else if(index == "8"){
              return (
                content +
                "<br>" +
                "SHOW全部交易金额:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                " $"
              );
            }else if (index == "1") {
              //console.log("显示1");
              return (
                content +
                "<br>" +
                "SHOW真实交易金额:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                " $" +
                "<br>" +
                "SHOW全部交易金额:" +
                get_thousand_num(parseInt(this.points[1].y)) +
                " $"
              );
            } else if (index == "0") {
              //console.log("显示000000000");
              return (
                content +
                "<br>" +
                "SHOW全部交易量:" +
                get_thousand_num(parseInt(this.points[1].y)) +
                " show" +
                "<br>" +
                "<br>" +
                "<p>" +
                "SHOW真实交易量:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                "</p>" +
                " show"
              );
            }
            return (
              content +
              "<br>" +
              "SHOW全部交易量:" +
              get_thousand_num(parseInt(this.points[1].y)) +
              " show" +
              "<br>" +
              "<br>" +
              "<p>" +
              "SHOW真实交易量:" +
              get_thousand_num(parseInt(this.points[0].y)) +
              "</p>" +
              " show"
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
        //console.log("进入0");
        let timestamp = (new Date()).getTime();
        this.$http
          .get(
            `//trendapi.show-fund.com/showusdt_okdeal_amount_all/0/${timestamp}/1/`
          )
          .then(function(res) {
            var names = [
              "SHOW全部交易量",
              "SHOW真实交易金额",
              "SHOW真实交易量",
              "SHOW真实交易金额"
            ];
            var seriesOptions = [
              {
                name: names[0],
                color: "#ff0000", //红色
                data: res.data.realvolume //真量
              },
              {
                name: names[2],
                color: "#000000", //黑色
                data: res.data.allvolume //假量
              }
            ];
            that.isShow1 = true;
            that.isShow = false;
            that.createChart(seriesOptions, index);
            return;
          });
      } else if (index == "1") {
        //console.log("进入1");
        let timestamp = (new Date()).getTime();
        this.$http
          .get(
            `//trendapi.show-fund.com/showusdt_okdeal_amount_all/0/${timestamp}/1/`
          )
          .then(function(res) {
            var names = [
              "SHOW全部交易量",
              "SHOW真实交易金额",
              "SHOW真实交易量",
              "SHOW真实交易金额"
            ];
            // var flag2 = [];
            // for (var i = 0; i < res.data.askcap.length; i += 1) {
            //   flag2.push({});
            // }
            var seriesOptions = [
              {
                name: names[1],
                color: "#ff0000",
                data: res.data.realamount //真金额
              },
              {
                name: names[3],
                color: "#000000",
                data: res.data.allamount //假金额
              }
            ];
            that.isShow1 = false;
            that.isShow = true;
            that.createChart(seriesOptions, index);
          });
      }
    },
    tochange(index){
        console.log(index)
        var that = this;
        if (index == "11" && this.isShow1 == true) {
        //console.log("进入0");
        let timestamp = (new Date()).getTime();
        this.$http
          .get(
            `//trendapi.show-fund.com/showusdt_okdeal_amount_all/0/${timestamp}/1/`
          )
          .then(function(res) {
            var names = [
              "SHOW全部交易量",
              "SHOW真实交易金额",
              "SHOW真实交易量",
              "SHOW真实交易金额"
            ];
            var seriesOptions = [
              {
                name: names[0],
                color: "#ff0000", //红色
                data: res.data.realvolume //真量
              },
            ];
            that.isShow1 = true;
            that.isShow = false;
            that.dData = "realvolume"
            that.createChart(seriesOptions, index);
            return;
          });
      } else if (index == "8" && this.isShow == true) {
        //console.log("进入1");
        let timestamp = (new Date()).getTime();
        this.$http
          .get(
            `//trendapi.show-fund.com/showusdt_okdeal_amount_all/0/${timestamp}/1/`
          )
          .then(function(res) {
            var names = [
              "SHOW全部交易量",
              "SHOW真实交易金额",
              "SHOW真实交易量",
              "SHOW真实交易金额"
            ];
            var seriesOptions = [
              // {
              //   name: names[1],
              //   color: "#ff0000",
              //   data: res.data.realamount //真金额
              // },
              {
                name: names[3],
                color: "#000000",
                data: res.data.allamount //假金额
              }
            ];
            that.isShow1 = false;
            that.isShow = true;
            that.dData = "allamount"
            that.createChart(seriesOptions, index);
          });
      }else if (index == "12" && this.isShow1 == true) {
        //console.log("进入0");
        let timestamp = (new Date()).getTime();
        this.$http
          .get(
            `//trendapi.show-fund.com/showusdt_okdeal_amount_all/0/${timestamp}/1/`
          )
          .then(function(res) {
            var names = [
              "SHOW全部交易量",
              "SHOW真实交易金额",
              "SHOW真实交易量",
              "SHOW真实交易金额"
            ];
            var seriesOptions = [
              // {
              //   name: names[0],
              //   color: "#ff0000", //红色
              //   data: res.data.realvolume //真量
              // },
              {
                name: names[2],
                color: "#000000", //黑色
                data: res.data.allvolume //假量
              }
            ];
            that.isShow1 = true;
            that.isShow = false;
            that.dData = "allvolume"
            that.createChart(seriesOptions, index);
            return;
          });
      } else if (index == "6" && this.isShow == true) {
        //console.log("进入1");
        let timestamp = (new Date()).getTime();
        this.$http
          .get(
            `//trendapi.show-fund.com/showusdt_okdeal_amount_all/0/${timestamp}/1/`
          )
          .then(function(res) {
            var names = [
              "SHOW全部交易量",
              "SHOW真实交易金额",
              "SHOW真实交易量",
              "SHOW真实交易金额"
            ];
            var seriesOptions = [
              {
                name: names[1],
                color: "#ff0000",
                data: res.data.realamount //真金额
              },
              // {
              //   name: names[3],
              //   color: "#000000",
              //   data: res.data.allamount //假金额
              // }
            ];
            that.isShow1 = false;
            that.isShow = true;
            that.dData = "realamount"
            that.createChart(seriesOptions, index);
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

.tb {
    display: inline-block;
    float: right;
    margin: 10px;
}
</style>
