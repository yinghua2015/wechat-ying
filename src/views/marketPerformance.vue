<template>
  <div id="app">
    <div class="dq">
      <div id="container" style="height:700px"></div>
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

.table_main {
    width: 100%;
    /* margin-top: 3.8%;
    position: absolute;
    bottom: 0; */
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
      tableData: [],
      cols: [
        { prop: "name", label: "名称" },
        { prop: "key0", label: "涨幅1天" },
        { prop: "key1", label: "涨幅1周" },
        { prop: "key2", label: "涨幅1月" },
        { prop: "key3", label: "涨幅3月" },
        { prop: "key4", label: "涨幅6月" },
        { prop: "key5", label: "涨幅1年" },
        { prop: "key6", label: "涨幅今年" }
      ],

      // tableData:[],
      time2: [],
      leftPart: [{ name: "买卖盘总挂单量" }, { name: "买卖盘总挂单市值" }],
      changeLeftBackground: 0,
      markList: [],
      isShow: false,
      isShow1: false,
      isList2: false,
      isList: false,
      activeNames: ["1"],
      kv: "买卖盘总挂单量",
      kv1: "买卖盘总挂单市值",
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
    let _that = this;
    var seriesOptions = [],
      seriesCounter = 0,
      names = ["usd", "btc"];

    this.$http
      .get(
        "http://trendapi.show-fund.com/coinmarketdata/show/" + names[0] + "/"
      )
      .then(function(res) {
        var w1 = [];
        var w2 = [];
        var w3 = [];
        for (var i = 0; i < res.data.length; i++) {
          w1.push(res.data[i][1] / res.data[0][1]);
          w2.push(res.data[i][0]);
        }
        for (var i = 0; i < res.data.length; i++) {
          w3.push([w2[i], w1[i]]);
        }
        console.log(w3);
        seriesOptions.push({
          name: "show",
          color: "#ffa33b",
          data: w3
        });
        //_that.createChart(seriesOptions);
        $(".el-loading-spinner").hide();
        return;
      });
    this.$http
      .get(
        "http://trendapi.show-fund.com/coinmarketdata/bitcoin/" + names[0] + "/"
      )
      .then(function(res) {
        var ww1 = [];
        var ww2 = [];
        var ww3 = [];
        for (var i = 0; i < res.data.length; i++) {
          ww1.push(res.data[i][1] / res.data[0][1]);
          ww2.push(res.data[i][0]);
        }
        for (var i = 0; i < res.data.length; i++) {
          ww3.push([ww2[i], ww1[i]]);
        }
        console.log(ww3);
        // console.log(res.data);
        seriesOptions.push({
          name: names[1],
          color: "#000",
          data: ww3
        });
        for (var i = 0; i < res.data.length; i++) {
          _that.time2.push(res.data[i][0]);
        }
        $(".el-loading-spinner").hide();
        // _that.createChart(seriesOptions);
        // $(".el-loading-mask").remove();
        return;
      });

    this.$http
      .get("http://trendapi.show-fund.com/coinmarketdata/total/all/")
      .then(function(res) {
        var www1 = [];
        var www2 = [];
        var www3 = [];
        for (var i = 0; i < res.data.length; i++) {
          www1.push(res.data[i][1] / res.data[0][1]);
          www2.push(res.data[i][0]);
        }
        for (var i = 0; i < res.data.length; i++) {
          www3.push([www2[i], www1[i]]);
        }
        console.log(www3);

        // ----------------
        var time3 = [];
        var timeEnd = [];
        // console.log(res.data);
        for (var i = 0; i < res.data.length; i++) {
          time3.push(res.data[i][1]);
        }
        var tt = _that.time2;
        for (var t = 0; t < _that.time2.length; t++) {
          timeEnd.push([_that.time2[t], time3[t]]);
        }
        console.log(timeEnd);
        seriesOptions.push({
          name: "数字货币总市值",
          color: "#dd3bff",
          data: www3
        });
        console.log(seriesOptions)

        $(".el-loading-spinner").hide();
        setTimeout(() => {
          _that.createChart(seriesOptions);
          _that.table();
        }, 1500);

        $(".el-loading-mask").remove();
        return;
      });

    //   this.moreChart();
    //   this.highmaps();
  },
  methods: {
    leftChange(index) {
      this.changeLeftBackground = index;
    },
    createChart(seriesOptions) {
      var colors = ["#ffa33b", "#3bff46", "#dd3bff"];
      this.stockChart = new Highcharts.stockChart("container", {
        chart: {
          zoomType: null
          // pinchType: null
        },
        rangeSelector: {
          inputDateFormat: '%Y-%m-%d',
          selected: 0
        },
        title: {
          text: "一段时间内，数字货币总市值涨跌幅与BTC、SHOW的价格涨跌幅数据",
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
        yAxis: {
          labels: {
            formatter: function() {
              console.log(this.value);
              return (this.value > 0 ? " + " : "") + this.value + "%";
            }
          },
          plotLines: [
            {
              value: 0,
              width: 2,
              color: "silver"
            }
          ]
        },
        plotOptions: {
          series: {
            compare: "percent",
            showInNavigator: true
          }
        },
        tooltip: {
          //  formatter: function() {
          //     console.log(this)
          //     var date = new Date(this.x); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
          //     var Y = date.getFullYear() + "-";
          //     var M =(date.getMonth() + 1 < 10
          //         ? "0" + (date.getMonth() + 1)
          //         : date.getMonth() + 1) + "-";
          //     var D = date.getDate() + " ";
          //     var h = date.getHours() + ":";
          //     var m = date.getMinutes();
          //     var s = date.getSeconds();
          //     var content = Y + M + D
          //     var sq = "<b>" + content + "</b>";
          //     $.each(this.points, function() {
          //       sq += "<br/>" + this.series.name + ": " + this.y + "%";
          //     });
          //     return sq;
          //   },
          xDateFormat: '%Y-%m-%d',
          pointFormat:
            '<span style="color:{series.color}">{series.name}</span>: <b></b> {point.change}%<br/>',
          valueDecimals: 2,
          followTouchMove: false,
          split: true
        },
        series: seriesOptions
      });
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
        .get("http://trendapi.show-fund.com/coinmarketcsreport/show/")
        .then(function(res) {
          console.log(res.data.bitcoin);
          /*市场表现 sub_title*/
          var market_expression = res.data.bitcoin;
          var t_arr = [];
          var obj = {};
          var obj_1 = {};
          var obj_2 = {};
          for (var i = 0; i < res.data.bitcoin.length; i++) {
            eval(
              "obj.key" + i + "='" + res.data.bitcoin[i].toFixed(2) + "%" + "'"
            );
          }
          var o1 = {
            name: "BTC"
          };
          obj.name ="BTC";
          var oo1 = obj;
          // obj.name ="BTC";
          // console.log(obj)
          for (var i = 0; i < res.data.show.length; i++) {
            eval(
              "obj_1.key" + i + "='" + res.data.show[i].toFixed(2) + "%" + "'"
            );
          }
          var o2 = {
            name: "SHOW"
          };
          var oo2 = Object.assign(o2, obj_1);
          for (var i = 0; i < res.data.market.length; i++) {
            eval(
              "obj_2.key" + i + "='" + res.data.market[i].toFixed(2) + "%" + "'"
            );
          }
          var o3 = {
            name: "数字货币总市值"
          };
          var oo3 = Object.assign(o3, obj_2);
          console.log(oo3);

          _this.tableData.push(oo3, oo1, oo2);
          // _this.tableDatas = ty
          console.log(_this.tableData);
          //this.tableData = res.data.bitcoin
          // $(".market-expression").html(market_expression.summary);

          /*市场表现 table*/
          // var phase = market_expression;
          // var tableHtml = "";
          // var tq =['涨幅1天','涨幅1周','涨幅1月','涨幅3月','涨幅6月','涨幅今年','涨幅1年']
          // $.each(phase, function(k, val) {
          //   console.log(val)
          //   if ((k + 1) % 2 == 1) {
          //     //tableHtml +='<th>' + tq[k] + '</th>'
          //     tableHtml += "<tr>";
          //   }
          //   tableHtml += "<td>"+ tq[k]+ "</td>"+"<td>"+ val + "</td>";
          //   // tableHtml +=
          //   //   "<td class='text-center " +
          //   //   (val > 0 ? "text-success" : "text-danger") +
          //   //   "'>" +
          //   //   val +
          //   //   "</td>";
          //   // if ((k + 1) % 2 == 0) {
          //   //   tableHtml += "</tr>";
          //   // }
          // });
          // console.log(tableHtml)
          // $("#zhangfu>table").html(tableHtml);
        });
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
<style lang="css" scoped>
.dq{
  margin:0 !important
}
.el-table_1_column_1 {
  color: #ff0808ab !important;
  font-weight: bold !important;
}
.cell {
  color: #0741b7 !important;
}
</style>
<style lang="scss" scoped>
/* 设置当前选中行的背景颜色 */
.el-table__body tr.current-row > td {
  background: #c9eff5 !important;
}
/* 设置table header的背景颜色 */
.el-table__header th,
.el-table__header tr {
  background-color: #17b3a3;
  color: black;
}
/* 设置表主体的高度 */
.el-table__body td,
.el-table__body th {
  padding: 3px;
}
/* 设置表头的高度 */
.el-table__header td,
.el-table__header th {
  padding: 6px 0px;
}
/* 设置分页器的高度 */
.site-wrapper .el-pagination {
  margin-top: 5px;
  text-align: right;
}
.el-pager li.active {
  color: #080909;
  cursor: default;
  background-color: #17b3a3;
  border-radius: 2px;
}

.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
.table-bordered {
  border: 1px solid #ddd;
}
.highcharts-range-selector-buttons {
  display: none;
}
.dq {
  margin-top: 40px;
}
.aa {
  width: 200px;
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
  height: 100vh;
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
