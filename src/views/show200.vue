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
      <!-- <el-button @click="allData(kv)">{{kv1}}</el-button>
      <el-button @click="allData(kv)">{{kv2}}</el-button>
      <li >{{list.name}}</li>-->
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
    
      <p>红线为卖盘200档挂单SHOW挂单总市值</p>
      <p>绿线为买盘200档挂单SHOW挂单总市值</p>
      <p>数据日期为：2019年5月14日～至今</p>
    </div>
    <div class="textP" style="text-align:center" v-if="isShow1">
    
      <p>红线为卖盘200档挂单SHOW总量</p>
      <p>绿线为买盘200档挂单SHOW总量</p>
      <p>数据日期为：2019年5月14日～至今</p>
      <p></p>
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
      
      leftPart: [{ name: "买卖盘总挂单量" }, { name: "买卖盘总挂单市值" },{ name: "秀多空比" }],
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
    this.$http
      .get("http://trendapi.show-fund.com/show_depth/all/")
      .then(function(res) {
        //console.log(res.data.askamount);
        var names = [
          "卖盘总挂单量",
          "买盘总挂单市值",
          "买盘总挂单量",
          "买盘总挂单市值"
        ];
        var seriesOptions = [
          {
            name: names[0],
            color: "#ff0000",
            data: res.data.askamount
          },

          {
            name: names[2],
            color: "#01a701",
            data: res.data.bidamount
          }
        ];

        _that.createChart(seriesOptions);
        _that.isShow1 = true;
        $(".el-loading-spinner").hide();
        return;
      });
    //   this.moreChart();
    //   this.highmaps();
  },
  methods: {
    leftChange(index) {
      this.changeLeftBackground = index;
    },
    createChart(seriesOptions, index) {
       var sdk = ''
      if(index == 0){
      var sdk = '每分钟获取SHOW在OKEx内买卖盘200档的挂单SHOW总量'
      }else if(index == 1){
        var sdk = '每分钟获取SHOW在OKEx内买卖盘200档的SHOW挂单总市值'
      }else if(index == 2){
        var sdk = ''
      }else{
        var sdk = '每分钟获取SHOW在OKEx内买卖盘200档的挂单SHOW总量'
      }
      this.stockChart = new Highcharts.stockChart("container", {
        global: { useUTC: false },
        rangeSelector: {
          // inputEnabled: false,
          inputDateFormat: '%Y-%m-%d',
          selected: 0,
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
        title:{
          text:sdk ,
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
            var content = Y + M + D + h + m;
            //console.log("显示0");
            if (index == "1") {
              //console.log("显示1");
              return (
                content +
                "<br>" +
                "卖盘总挂单市值:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                " $" +
                "<br>" +
                "买盘总挂单市值:" +
                get_thousand_num(parseInt(this.points[1].y)) +
                " $"
              );
            } else if (index == "0") {
              //console.log("显示000000000");
              return (
                content +
                "<br>" +
                "买盘总挂单量:" +
                get_thousand_num(parseInt(this.points[1].y)) +
                " show" +
                "<br>" +
                "<br>" +
                "<p>" +
                "卖盘总挂单量:" +
                get_thousand_num(parseInt(this.points[0].y)) +
                "</p>" +
                " show"
              );
            }else if (index == "2") {
              //console.log("显示000000000");
              return (
                content +
                "<br>" +
                // "买盘总挂单量:" +
                // get_thousand_num(parseInt(this.points[1].y)) +
                // " show" +
                // "<br>" +
                // "<br>" +
                // "<p>" +
                "多空比:" +
                (Number(this.points[0].y) * 100).toFixed(2) +
                "</p>" +
                "%"
              );
            }
            return (
              content +
              "<br>" +
              "买盘总挂单量:" +
              get_thousand_num(parseInt(this.points[1].y)) +
              " show" +
              "<br>" +
              "<br>" +
              "<p>" +
              "卖盘总挂单量:" +
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
        this.$http
          .get("http://trendapi.show-fund.com/show_depth/all/")
          .then(function(res) {
            var names = [
              "卖盘总挂单量",
              "买盘总挂单市值",
              "买盘总挂单量",
              "买盘总挂单市值"
            ];
            var seriesOptions = [
              {
                name: names[0],
                color: "#01a701", //绿色
                data: res.data.bidamount //买单总量
              },
              {
                name: names[2],
                color: "#ff0000", //红色
                data: res.data.askamount //卖单总量
              }
            ];
            that.isShow1 = true;
            that.isShow = false;
            that.createChart(seriesOptions, index);
            return;
          });
      } else if (index == "1") {
        //console.log("进入1");
        this.$http
          .get("http://trendapi.show-fund.com/show_depth/all/")
          .then(function(res) {
            var names = [
              "卖盘总挂单量",
              "买盘总挂单市值",
              "买盘总挂单量",
              "买盘总挂单市值"
            ];
            var flag2 = [];
            for (var i = 0; i < res.data.askcap.length; i += 1) {
              flag2.push({});
            }
            var seriesOptions = [
              {
                name: names[1],
                color: "#cc4a4a",
                data: res.data.askcap //卖单总市值
              },
              {
                name: names[3],
                color: "#03ff03",
                data: res.data.bidcap //买单总市值
              }
            ];
            that.isShow1 = false;
            that.isShow = true;
            that.createChart(seriesOptions, index);
          });
      }else if (index == "2") {
        console.log("进入2");
        this.$http
          .get("http://trendapi.show-fund.com/show_depth/all/")
          .then(function(res) {
            var names = [
              "卖盘总挂单量",
              "买盘总挂单市值",
              "买盘总挂单量",
              "买盘总挂单市值"
            ];
            var flag6 = [];
            var flag8 = [];
            var flag9 = [];
            var flag10 = [];
            for (var i = 0; i < res.data.askcap.length; i += 1) {
              flag6.push(res.data.askcap[i][1]);
            }
            for (var i = 0; i < res.data.bidcap.length; i += 1) {
              flag8.push(res.data.bidcap[i][1]);
            }
            for (var i = 0; i < flag8.length; i += 1) {
             flag9.push(flag8[i]/flag6[i])
            }
            for (var i = 0; i < res.data.bidcap.length; i += 1) {
            flag10.push([res.data.bidcap[i][0],flag9[i]])
            }
            console.log(flag10)
            let q1 = res.data.bidcap/res.data.askcap
            var seriesOptions = [
              {
                name: names[1],
                color: "#cc4a4a",
                data: flag10 //卖单总市值
              }
            ];
            that.isShow1 = false;
            that.isShow = true;
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
.dq{
  margin:0 !important
}
@media screen and (max-width: 768px) {
  .dq{
  margin-top: 40px !important
}
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
