import $ from 'jquery';
<template>
  <div>
    <div class="main">
      <el-row :gutter="12">
        <el-col :span="3">
          <div class>
            <el-date-picker
              v-model="starttime"
              type="date"
              placeholder="开始日期"
              value-format="timestamp"
            ></el-date-picker>
            <!-- <el-input class="int" v-model.trim="starttime" size="mini" placeholder="开始时间"/> -->
          </div>
        </el-col>
        <el-col :span="5">
          <div class="grid-content bg-purple">
            <!-- <el-input class="int" v-model.trim="endtime" size="mini" placeholder="结束时间"/> -->
            <el-date-picker
              v-model="endtime"
              type="date"
              placeholder="结束日期"
              value-format="timestamp"
            ></el-date-picker>
            <el-button @click="toTime()">确定</el-button>
          </div>
        </el-col>
        <!-- <el-col :span="2">
          <div class="grid-content bg-purple">
            <el-button @click="toTime()">确定</el-button>
          </div>
        </el-col>-->
        <el-col :span="1">
          <div class="grid-content bg-purple yu">
            USDT
          </div>
        </el-col>
        <el-col :span="2">
          <div class="grid-content bg-purple">
            <el-input class v-model.trim="prices" size="mini" placeholder="开始金额"/>
          </div>
        </el-col>
        <el-col :span="2">
          <div class="grid-content bg-purple">
            <el-input class v-model.trim="toprices" size="mini" placeholder="最大金额"/>
          </div>
        </el-col>
        <el-col :span="2">
          <div class="grid-content bg-purple">
            <el-button @click="toPrices()">确定</el-button>
          </div>
        </el-col>
        <!-- <el-col :span="3">
          <div class="grid-content bg-purple">
            <el-input placeholder="请输入学校名称"  v-model="schfilter" class="search-input"></el-input>
          </div>
        </el-col>-->
        <el-col :span="3">
          <div class="grid-content bg-purple">
            <el-input placeholder="Address / Txn Hash" v-model="schfilter" class="search-input"></el-input>
          </div>
        </el-col>
        <el-select
              style="right: 30px;width: 100px !important;"
              v-model="value2"
              placeholder="类型"
              @change="change_select(value2)"
            >
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              ></el-option>
          </el-select>
          <router-link :to="{path:'./table2'}" replace>USDT增发销毁记录</router-link>
          <router-view></router-view>
      </el-row>
    </div>
    <!-- .slice((currpage - 1) * pagesize, currpage * pagesize) -->
    <el-table :data="tableData" style="width: 100%" @selection-change="handleSelectionChange">
      <!-- <el-table-column type="selection" width="55"></el-table-column> -->
      <el-table-column prop="idx" label="#" min-width="85"></el-table-column>
      <el-table-column prop="Hash" label="Txn Hash" min-width="335px">
        <template slot-scope="scope">
          <a
            :href="toTx2+scope.row.txhash"
            style="margin-left: 10px"
            target="_blank"
            v-if="scope.row.txhash.substring(0, 2) != '0x'"
          >{{ scope.row.txhash.substring(0, 18)+'...' }}</a>
          <a
            :href="toTx+scope.row.txhash"
            style="margin-left: 10px"
            target="_blank"
            v-if="scope.row.txhash.substring(0, 2) == '0x'"
          >{{ scope.row.txhash.substring(0, 18)+'...' }}</a>
        </template>
      </el-table-column>
      <el-table-column prop="time" label="Timestamp" min-width="305px"></el-table-column>
      <el-table-column prop="fromwallet" label="Form" min-width="295px">
        <template slot-scope="scope">
          <!-- <i class="el-icon-d-arrow-right" style="color:#0080ff"></i> -->
          <a
            :href="q1(scope)"
            style="margin-left: 10px"
            target="_blank"
            v-if="scope.row.fromwallet.length >30"
          >{{ scope.row.fromwallet.substring(0, 15)+'...' }}</a>
          <a
            :href="q1(scope)"
            style="margin-left: 10px"
            target="_blank"
           v-if="scope.row.fromwallet.length < 30"
          >{{ scope.row.fromwallet }}</a>
        </template>
      </el-table-column>

      <el-table-column prop="towallet" label="TO" min-width="295px" >
        <template slot-scope="scope">
          <i class="el-icon-d-arrow-right" style="color:rgb(192, 0, 255)"></i>
          <a
            :href="q1(scope)"
            style="margin-left: 10px"
            target="_blank"
            v-if="scope.row.towallet.length >30"
          >{{scope.row.towallet.substring(0, 15)+'...'}}</a>
          <a
            :href="q1(scope)"
            style="margin-left: 10px"
            target="_blank"
            v-if="scope.row.towallet.length < 30"
          >{{ scope.row.towallet }}</a>
          <!-- {{q1(scope)}} -->
        </template>
      </el-table-column>
      <el-table-column prop="value" label="Quantity" min-width="285px"></el-table-column>
      <!-- <el-table-column prop="txtype" label="Types" width="185px"></el-table-column> -->
      <!-- <el-table-column prop="usdamount" label="USD-value" width="185px"></el-table-column>
      <el-table-column prop="btcamount" label="BTC-value" width="185px"></el-table-column>
      <el-table-column prop="ethamount" label="ETH-value" width="185px"></el-table-column> -->
    </el-table>
    <el-pagination
      background
      layout="prev, pager, next, total, jumper"
      :page-size="pagesize"
      :total="Number(totalcount)"
      @current-change="handleCurrentChange"
      @size-change="handleSizeChange"
    ></el-pagination>
  </div>
</template>

<script>
export default {
  data() {
    return {
      options: [
        {
          value: "0",
          label: "全部"
        },
        {
          value: "1",
          label: "流出"
        },
        {
          value: "2",
          label: "流入"
        }
      ],
      currpage: 1, //初始页
      pagesize: 50, //每页数据
      toTx2:'//www.omniexplorer.info/tx/',
      toTx3:'//www.omniexplorer.info/address/',
      toTx: "http://etherscan.io/tx/",
      tohref: "http://etherscan.io/address/",
      value: "show",
      search1: "",
      schfilter: "0x",
      starttime: "",
      endtime: "",
      prices: "0",
      toprices: "10000000000",
      tableDataName: "",
      tableDataEnd: [],
      currentPage: 4,
      totalItems: 0,
      filterTableDataEnd: [],
      flag: false,
      filterTableDataEnd: [],
      tableData: [],
      otableData: [],
      value1: "",
      value2: "0",
      totalcount: ""
    };
  },
  watch: {
    schfilter: function() {
       this.toSearch();
    }

  },

  mounted() {
    const that = this;
    let dateTime=new Date()
    let startstamp = dateTime.setDate(dateTime.getDate()-1);//计算前一天24小时
    console.log(startstamp)
    let timestamp = new Date().getTime();
    this.$http
    // //trendapi.show-fund.com/usdt_tx_amount_report/0/1562330552876/100/500/0x/1/50/
      .get(
        `//trendapi.show-fund.com/usdt_tx_amount_report/${startstamp}/${timestamp}/0/10000000000/0x/0/${this.currpage}/100/` //0-10000000000
      )
      .then(function(res) {
        //console.log(res.data.data.list);
        //window.loading.close();
        that.totalcount = res.data.data.totalcount;
        let _tableData = [];
        for (let index = 0; index < res.data.data.list.length; index++) {
          const t9 = res.data.data.list;
          const element = t9[index];
          element.time = that.getdate(element.time);
          // element.value = that.get_thousand_num(element.value);
          // element.price_btc = that.get_thousand_num(element.btcamount);
          // element.price_usd = that.get_thousand_num(element.usdamount);
          // element.price_eth = that.get_thousand_num(element.ethamount);
          _tableData.push(element);
        }
        that.tableData = _tableData;
        that.otableData = _tableData;
      });
      this.schfilter =""
  },
  methods: {
    q1(scope){
      if(scope.row.txhash.substring(0, 2) == '0x'){
      return this.tohref+scope.row.toaddress
      }else{
        return this.toTx3+scope.row.fromaddress
      }
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
    change_select(val) {
      console.log(val);
      this.value2 = val
      //this.prices = 1000;
      this.currpage = 1;
      this.tofetch(this.timefix(this.starttime), this.timefix(this.endtime));
    },
    toSearch() {
      const searchData = this.schfilter;
      if (searchData == "") {
        this.currpage = 1;
        //this.$message.warning("查询条件不能为空！");
        this.tableData = this.otableData;
        return;
      }
      if (searchData) {
          this.currpage = 1;
          this.tofetch()
        // let resultData = this.tableData.filter(data => {
        //   //日期假设date,人名 name
        //   if (
        //     data.txhash == searchData ||
        //     String(data.fromaddress)
        //       .toLowerCase()
        //       .indexOf(searchData) > -1 ||
        //     String(data.toaddress)
        //       .toLowerCase()
        //       .indexOf(searchData) > -1
        //   ) {
        //     //此处根据具体需求判断
        //     return true;
        //   }
        // });
        // this.tableData = resultData;
      } else {
        this.tableData = this.tableData;
      }
    },
    toTime() {
      console.log(this.starttime);
      console.log(this.endtime);
      this.currpage = 1;
      this.tofetch(this.starttime, this.endtime);
    },
    toPrices() {
      console.log(this.prices);
      if (this.prices == "" || this.toprices == "") {
        this.prices = "0";
        this.toprices = "10000000000";
        console.log(this.prices);
        this.tofetch(this.starttime, this.endtime);
      } else {
        this.currpage = 1;
        this.tofetch(this.starttime, this.endtime);
      }
    },
    getdate(x) {
      var date = new Date(x),
        Y = date.getFullYear() + "-",
        M =
          (date.getMonth() + 1 < 10
            ? "0" + (date.getMonth() + 1)
            : date.getMonth() + 1) + "-",
        D = date.getDate() + " ",
        h = date.getHours() + ":",
        m = date.getMinutes() + ":",
        s = date.getSeconds();
      return Y + M + D + h + m + s;
    },
    timefix(val) {
      var strtime = val;
      var date = new Date(strtime);
      //传入一个时间格式，如果不传入就是获取现在的时间了，这样做不兼容火狐。
      // 可以这样做
      var date = new Date(strtime.replace(/-/g, "/"));

      // 有三种方式获取，在后面会讲到三种方式的区别
      return date.getTime();
      // time2 = date.valueOf();
      // time3 = Date.parse(date);
    },
    tofetch(starttime, endtime) {
      const that = this;

      let timestamp = new Date().getTime();
      if (this.starttime == "" || this.endtime == "") {
        let dateTime=new Date()
        starttime = dateTime.setDate(dateTime.getDate()-1);
        endtime = timestamp;
      }
      if (this.schfilter == "" || this.schfilter == null || this.schfilter == undefined) {
        this.schfilter = "0x"
      }
      this.$http
        .get(
          `//trendapi.show-fund.com/usdt_tx_amount_report/${starttime}/${endtime}/${this.prices}/${this.toprices}/${this.schfilter}/${this.value2}/${this.currpage}/50/`
        )
        .then(function(res) {
          console.log(res.data.data.list);
          that.totalcount = res.data.data.totalcount;
          //that.pagesize = [50, res.data.data.list.length];
          let _tableData = [];
          for (let index = 0; index < res.data.data.list.length; index++) {
            const element = res.data.data.list[index];
            //res.data.data.list[index].id = index + 1;
            element.time = that.getdate(element.time);
            // element.value = that.get_thousand_num(element.value);
            // element.price_btc = that.get_thousand_num(element.btcamount);
            // element.price_usd = that.get_thousand_num(element.usdamount);
            // element.price_eth = that.get_thousand_num(element.ethamount);
            _tableData.push(element);
          }
          that.tableData = _tableData;
          //that.otableData = _tableData
          console.log(that.pagesize);
          //console.log(that.formatDate('1515650976'))
        });
    },
    handleCurrentChange(cpage) {
      this.currpage = cpage;
      this.tofetch(this.starttime, this.endtime);
      console.log(cpage);
    },
    handleSizeChange(psize) {
      this.pagesize = psize;
      console.log(psize);
    },
    handleSelectionChange(val) {
      console.log(val);
    },
    handleEdit(index, row) {
      console.log(index, row);
    },
    handleDelete(index, row) {
      console.log(index, row);
    }
  },
  created() {}
};
</script>
<style>
.el-table th {
    padding-left: 10px !important;
}
.el-table thead {
    color: #121315 !important;
    font-weight: 500;
}
.el-table .cell {
    box-sizing: border-box;
    white-space: normal;
    word-break: break-all;
    line-height: 23px;
    font-weight: bold;
}
.yu{
  height: 40px;
    line-height: 40px;
    text-align: right;
}
.el-input--mini .el-input__inner {
  height: 40px !important;
  line-height: 40px !important;
}
.main {
  margin-bottom: 30px;
}
.cell {
  font-size: 16px !important;
}
a {
  color: #3498db !important;
}
</style>