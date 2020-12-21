<template>

  <div class="quill-wrap">
      <div>日志时间点：{{timesBengin}}</div>
      <el-input autofocus @focus="focus()" class="elinp" v-model="topic_content" placeholder="请输入标题" label="标题："></el-input>
      <div class="inp_radio">
      <el-radio v-model="radio" label="1">高</el-radio>
      <el-radio v-model="radio" label="2">中</el-radio>
      <el-radio v-model="radio" label="3">低</el-radio>
      </div>
    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px" class="demo-ruleForm" size="small">
    <quill-editor autofocus  v-focus class="quedit"
      v-model="contentall"
      ref="myQuillEditor"
      :options="editorOption"
      @blur="onEditorBlur($event)"
      @focus="onEditorFocus($event)"
      @change="onEditorChange($event)"
      @ready="onEditorReady($event)"
    >
    </quill-editor >
    <el-form-item>
<el-tree
  :data="data2"
  show-checkbox
  node-key="id"
  ref="tree"
  @check="handleNodeClick"
  highlight-current
  :props="defaultProps">
</el-tree>
  </el-form-item>
    </el-form-item>
       <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
                <el-button @click="resetForm('ruleForm')">重置</el-button>
              </el-form-item>
            </el-form>
  </div>
</template>
<style scoped>
.el-form {
  max-width: 1024px;
}
.el-checkbox-group {
  font-size: 0;
  text-align: left;
}
.active {
  display: none;
}
.elinp {
  display: block;
  width: 450px;
}
.inp_radio {
  margin: 10px;
}
</style>
<script>
import { mapGetters } from "vuex";
import { quillEditor, Quill } from "vue-quill-editor";
import { container, ImageExtend, QuillWatch } from "quill-image-extend-module";
import $ from "jquery";
Quill.register("modules/ImageExtend", ImageExtend);
export default {
  components: { quillEditor },
  directives: {
    focus: {
      // 指令的定义
      inserted: function(el) {
        el.focus();
      }
    }
  },
  data() {
    return {
      timeStart: "",
      radio: "3",
      textAll: "",
      topic_content: "",
      contentall: "",
      data2: [
        {
          id: "btc",
          label: "btc",
          children: [
            {
              id: "b01",
              label: "btc充值",
              children: [
                {
                  id: "btc-in-ok",
                  label: "okex交易所"
                },
                {
                  id: "btc-in-bin",
                  label: "binance交易所"
                },
                {
                  id: "btc-in-btf",
                  label: "bitfinex交易所"
                },
                {
                  id: "btc-in-hb",
                  label: "huobi交易所"
                },
                {
                  id: "btc-in-all",
                  label: "all"
                }
              ]
            },
            {
              id: "b07",
              label: "btc提现",
              children: [
                {
                  id: "btc-out-ok",
                  label: "okex交易所"
                },
                {
                  id: "btc-out-bin",
                  label: "binance交易所"
                },
                {
                  id: "btc-out-btf",
                  label: "bitfinex交易所"
                },
                {
                  id: "btc-out-hb",
                  label: "huobi交易所"
                },
                {
                  id: "btc-out-all",
                  label: "all"
                }
              ]
            },
            {
              id: "b02",
              label: "btc净值(柱)",
              children: [
                {
                  id: "btc-net-ok-z",
                  label: "okex交易所"
                },
                {
                  id: "btc-net-bin-z",
                  label: "binance交易所"
                },
                {
                  id: "btc-net-btf-z",
                  label: "bitfinex交易所"
                },
                {
                  id: "btc-net-hb-z",
                  label: "huobi交易所"
                },
                {
                  id: "btc-net-all-z",
                  label: "all"
                }
              ]
            },
            {
              id: "b03",
              label: "btc净值(折)",
              children: [
                {
                  id: "btc-net-ok-l",
                  label: "okex交易所"
                },
                {
                  id: "btc-net-bin-l",
                  label: "binance交易所"
                },
                {
                  id: "btc-net-btf-l",
                  label: "bitfinex交易所"
                },
                {
                  id: "btc-new-address-l",
                  label: "huobi交易所"
                },
                {
                  id: "btc-net-all-l",
                  label: "all"
                }
              ]
            },
            {
              id: "btc-deal",
              label: "btc成交额"
            },
            {
              id: "btc-deal-num",
              label: "btc成交笔数"
            },
            {
              id: "btc-new-address",
              label: "btc新增地址数"
            },
            {
              id: "btc-active-address",
              label: "btc活跃地址数"
            }
          ]
        },
        {
          id: "eth",
          label: "eth",
          children: [
            {
              id: "e01",
              label: "eth充值",
              children: [
                {
                  id: "eth-in-ok",
                  label: "okex交易所"
                },
                {
                  id: "eth-in-bin",
                  label: "binance交易所"
                },
                {
                  id: "eth-in-btf",
                  label: "bitfinex交易所"
                },
                {
                  id: "eth-in-hb",
                  label: "huobi交易所"
                },
                {
                  id: "eth-in-all",
                  label: "all"
                }
              ]
            },
            {
              id: "e07",
              label: "eth提现",
              children: [
                {
                  id: "eth-out-ok",
                  label: "okex交易所"
                },
                {
                  id: "eth-out-bin",
                  label: "binance交易所"
                },
                {
                  id: "eth-out-btf",
                  label: "bitfinex交易所"
                },
                {
                  id: "eth-out-hb",
                  label: "huobi交易所"
                },
                {
                  id: "eth-out-all",
                  label: "all"
                }
              ]
            },
            {
              id: "e02",
              label: "eth净值(柱)",
              children: [
                {
                  id: "eth-net-ok-z",
                  label: "okex交易所"
                },
                {
                  id: "eth-net-bin-z",
                  label: "binance交易所"
                },
                {
                  id: "eth-net-btf-z",
                  label: "bitfinex交易所"
                },
                {
                  id: "eth-net-hb-z",
                  label: "huobi交易所"
                },
                {
                  id: "eth-net-all-z",
                  label: "all"
                }
              ]
            },
            {
              id: "e03",
              label: "eth净值(折)",
              children: [
                {
                  id: "eth-net-ok-l",
                  label: "okex交易所"
                },
                {
                  id: "eth-net-bin-l",
                  label: "binance交易所"
                },
                {
                  id: "eth-net-btf-l",
                  label: "bitfinex交易所"
                },
                {
                  id: "eth-net-hb-l",
                  label: "huobi交易所"
                },
                {
                  id: "eth-net-all-l",
                  label: "all"
                }
              ]
            },
            {
              id: "eth-deal",
              label: "eth成交额"
            },
            {
              id: "eth-deal-num",
              label: "eth成交笔数"
            },
            {
              id: "eth-new-address",
              label: "eth新增地址数"
            },
            {
              id: "eth-active-address",
              label: "eth活跃地址数"
            }
          ]
        },
        {
          id: "usdt",
          label: "usdt",
          children: [
            {
              id: "usdt01",
              label: "usdt充值",
              children: [
                {
                  id: "usdt-in-ok",
                  label: "okex交易所"
                },
                {
                  id: "usdt-in-bin",
                  label: "binance交易所"
                },
                {
                  id: "usdt-in-btf",
                  label: "bitfinex交易所"
                },
                {
                  id: "usdt-in-hb",
                  label: "huobi交易所"
                },
                {
                  id: "usdt-in-all",
                  label: "all"
                }
              ]
            },
            {
              id: "usdt05",
              label: "usdt提现",
              children: [
                {
                  id: "usdt-out-ok",
                  label: "okex交易所"
                },
                {
                  id: "usdt-out-bin",
                  label: "binance交易所"
                },
                {
                  id: "usdt-out-bit",
                  label: "bitfinex交易所"
                },
                {
                  id: "usdt-out-hb",
                  label: "huobi交易所"
                },
                {
                  id: "usdt-out-all",
                  label: "all"
                }
              ]
            },
            {
              id: "usdt02",
              label: "usdt净值(柱)",
              children: [
                {
                  id: "usdt-net-ok-z",
                  label: "okex交易所"
                },
                {
                  id: "usdt-net-bin-z",
                  label: "binance交易所"
                },
                {
                  id: "usdt-net-btf-z",
                  label: "bitfinex交易所"
                },
                {
                  id: "usdt-net-hb-z",
                  label: "huobi交易所"
                },
                {
                  id: "usdt-net-all-z",
                  label: "all"
                }
              ]
            },
            {
              id: "usdt03",
              label: "usdt净值(折)",
              children: [
                {
                  id: "usdt-net-ok-l",
                  label: "okex交易所"
                },
                {
                  id: "usdt-net-bin-l",
                  label: "binance交易所"
                },
                {
                  id: "usdt-net-btf-l",
                  label: "bitfinex交易所"
                },
                {
                  id: "usdt-net-hb-l",
                  label: "huobi交易所"
                },
                {
                  id: "usdt-net-all-l",
                  label: "all"
                }
              ]
            },
            {
              id: "usdt-deal",
              label: "usdt成交额"
            },
            {
              id: "usdt-deal-num",
              label: "usdt成交笔数"
            }
          ]
        },
        {
          id: "show",
          label: "show",
          children: [
            {
              id: "show01",
              label: "show充值",
              children: [
                {
                  id: "show-in-ok",
                  label: "okex交易所"
                },
                {
                  id: "show-in-bin",
                  label: "binance交易所"
                },
                {
                  id: "show-in-btf",
                  label: "bitfinex交易所"
                },
                {
                  id: "show-in-hb",
                  label: "huobi交易所"
                },
                {
                  id: "show-in-all",
                  label: "all"
                }
              ]
            },
            {
              id: "show07",
              label: "show提现",
              children: [
                {
                  id: "show-out-ok",
                  label: "okex交易所"
                },
                {
                  id: "show-out-bin",
                  label: "binance交易所"
                },
                {
                  id: "show-out-btf",
                  label: "bitfinex交易所"
                },
                {
                  id: "show-out-hb",
                  label: "huobi交易所"
                },
                {
                  id: "show-out-all",
                  label: "all"
                }
              ]
            },
            {
              id: "show02",
              label: "show净值(柱)",
              children: [
                {
                  id: "show-net-ok-z",
                  label: "okex交易所"
                },
                {
                  id: "show-net-bin-z",
                  label: "binance交易所"
                },
                {
                  id: "show-net-btf-z",
                  label: "bitfinex交易所"
                },
                {
                  id: "show-net-hb-z",
                  label: "huobi交易所"
                },
                {
                  id: "show-net-all-z",
                  label: "all"
                }
              ]
            },
            {
              id: "show03",
              label: "show净值(折)",
              children: [
                {
                  id: "show-net-ok-l",
                  label: "okex交易所"
                },
                {
                  id: "show-net-bin-l",
                  label: "binance交易所"
                },
                {
                  id: "show-net-btf-l",
                  label: "bitfinex交易所"
                },
                {
                  id: "show-net-hb-l",
                  label: "huobi交易所"
                },
                {
                  id: "show-net-all-l",
                  label: "all"
                }
              ]
            },
            {
              id: "show-deal",
              label: "show成交额"
            },
            {
              id: "show-deal-num",
              label: "show成交笔数"
            },
            {
              id: "show-box-change",
              label: "show持仓变化"
            },
            {
              id: "show-box-change-ok",
              label: "okex内show持仓变化"
            },
            {
              id: "okex-show-eth",
              label: "okex-show-eth"
            },
            {
              id: "okex-show-btc",
              label: "okex-show-btc"
            },
            {
              id: "okex-show-usdt",
              label: "okex-show-usdt"
            }
          ]
        }
      ],
      defaultProps: {
        children: "children",
        label: "label"
      },
      allCheckedone: "",
      isshow: true,
      cityname3: "",
      cityname2: "",
      cityname1: "",
      cityname0: "",
      cityname: "",

      chainname: "",

      checkBox: [],
      checkBox2: [],
      checkAll: false,
      checkedCities: [],
      checkedCities0: [],
      checkedCities1: [],
      checkedCities2: [],
      checkedCities3: [],

      checkedChain: [],

      isIndeterminate: true,
      value1: 0,
      html: "",
      // 富文本框参数设置
      editorOption: {
        modules: {
          ImageExtend: {
            loading: true,
            name: "img",
            action: "", //oss上传url
            response: res => {
              console.log(res);
              return res.info;
            }
          },
          toolbar: {
            container: container,
            handlers: {
              image: function() {
                QuillWatch.emit(this.quill.id);
                console.log(this.quill);
              }
            }
          }
        }
      },
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
  props: [
    "typeNameNew",
    "trendType",
    "isday",
    "coinType",
    "markTime",
    "isList",
    "content",
    "record",
    "topText",
    "timesBengin"
  ],
  mounted() {
    //console.log(this.content)
    // this.contentall = this.content
    this.$refs.tree.setCheckedKeys([this.typeNameNew]);
    console.log(this.$refs.tree.getCheckedKeys());
  },
  methods: {
    focus() {
      console.log(this.topText);
      this.contentall = this.content;
      this.topic_content = this.topText;
      console.log(this.$store.getters.typeNew);
      this.$refs.tree.setCheckedKeys([this.$store.getters.typeNew]);
      console.log(this.topic_content);
    },
    handleNodeClick(data, node, ev) {
      console.log(this.radio);
      console.log(this.topText);
      console.log(data);
      console.log(node);
      const getCheckedNodes = node.checkedKeys;
      const getHalfCheckedNodes = node.halfCheckedKeys;
      console.log(getCheckedNodes);
      console.log(getHalfCheckedNodes);
      let arrcheckall = [];
      let strAll = "";
      if (getHalfCheckedNodes.length == 0) {
        for (var i = 0; i < getCheckedNodes.length; i += 1) {
          arrcheckall.push(getCheckedNodes[i]);
        }
      } else {
        // for (var t = 0; t < getHalfCheckedNodes.length; t += 1) {
        //   arrcheckall.push(getHalfCheckedNodes[t]);
        // }
        for (var q = 0; q < getCheckedNodes.length; q += 1) {
          arrcheckall.push(getCheckedNodes[q]);
        }
      }
      arrcheckall.sort(function(a, b) {
        return a - b;
      });
      console.log(arrcheckall);
      strAll = arrcheckall.join(",");
      this.allCheckedone = strAll;
      console.log(this.allCheckedone);
      this.$store.commit("checkedBox0", strAll);
      console.log(this.$store.getters.cityname0 + "更新map----success！");
      //localStorage.checkboxsAlldown = strAll;
    },
    getCheckedNodes(leafOnly, includeHalfChecked) {
      console.log(this.$refs.tree.getCheckedNodes());
      // console.log(this.$refs.tree.getCheckedNodes()[0].$treeNodeId);
      console.log(this.$refs.tree.getHalfCheckedNodes());
      // console.log(this.$refs.tree.getHalfCheckedNodes()[0].$treeNodeId);
      const getCheckedNodes = this.$refs.tree.getCheckedNodes();
      const getHalfCheckedNodes = this.$refs.tree.getHalfCheckedNodes();
      let arrcheckall = [];
      let strAll = "";
      if (this.$refs.tree.getHalfCheckedNodes().length == 0) {
        for (var i = 0; i < getCheckedNodes.length; i += 1) {
          arrcheckall.push(getCheckedNodes[i].$treeNodeId);
        }
      } else {
        for (var t = 0; t < getHalfCheckedNodes.length; t += 1) {
          arrcheckall.push(getHalfCheckedNodes[t].$treeNodeId);
        }
        for (var i = 0; i < getCheckedNodes.length; i += 1) {
          arrcheckall.push(getCheckedNodes[i].$treeNodeId);
        }
      }
      arrcheckall.sort(function(a, b) {
        return a - b;
      });
      console.log(arrcheckall);
      strAll = arrcheckall.join(";");
      this.allCheckedone = strAll;
      console.log(this.allCheckedone);
      this.$store.commit("checkedBox0", strAll);
      localStorage.checkboxsAlldown = strAll;
    },
    getCheckedKeys() {
      const halfCheckedKeys = this.$refs.tree.getHalfCheckedKeys();
      const checkedKeys = this.$refs.tree.getCheckedKeys();
      console.log(halfCheckedKeys);
      console.log(checkedKeys);
      // let arrcheckall = [];
      // let strAll = "";
      // for (var t = 0; t < halfCheckedKeys.length; t += 1) {
      //   arrcheckall.push(halfCheckedKeys[t]);
      // }
      // for (var i = 0; i < checkedKeys.length; i += 1) {
      //   arrcheckall.push(checkedKeys[i]);
      // }
      // //console.log(arrcheckall);
      // arrcheckall.sort(function(a, b) {
      //   return a - b;
      // })
      // strAll = arrcheckall.join("");
      // this.allCheckedone = strAll;
      // console.log(this.allCheckedone);
      // this.$store.commit("checkedBox0", strAll);
    },
    setCheckedNodes() {
      this.$refs.tree.setCheckedNodes([
        {
          id: 5,
          label: "二级 2-1"
        },
        {
          id: 9,
          label: "三级 1-1-1"
        }
      ]);
    },
    setCheckedKeys() {
      this.$refs.tree.setCheckedKeys([3]);
    },
    resetChecked() {
      this.$refs.tree.setCheckedKeys([]);
    },
    allChecked() {
      console.log(this.data2);
      var arrty = [];
      for (var i = 0; i < this.data2.length; i += 1) {
        arrty.push(this.data2[i].id);
      }
      console.log(arrty);
      //  strAll = arrty.join("");
      // this.allChecked = strAll;
      // console.log(this.allChecked);
      // this.$store.commit("checkedBox0", strAll);
      this.$refs.tree.setCheckedKeys(arrty);
    },
    onEditorBlur(editor) {
      console.log("editor blur!", editor);
    },
    onEditorFocus(editor) {
      console.log(this.coinType, this.trendType, this.isday, this.markTime);
      console.log("editor focus!", editor);
    },
    onEditorReady(editor) {
      console.log("editor ready!", editor);
    },
    timeer(markTime) {
      console.log(this.markTime);
      var date = new Date(this.markTime); //时间戳为10位需*1000，时间戳为13位的话不需乘1000
      var Y = date.getFullYear() + "-";
      var M =
        (date.getMonth() + 1 < 10
          ? "0" + (date.getMonth() + 1)
          : date.getMonth() + 1) + "-";
      var D = date.getDate() + " ";
      var h = date.getHours() + ":00";
      var m = date.getMinutes();
      var s = date.getSeconds();
      this.timeStart = Y + M + D + h;
      console.log(this.timeStart);
      return Y + M + D + h;
    },
    onEditorChange({ editor, html, text }) {
      console.log("editor change!", editor, html, text);

      this.contentall = html;
      this.topic_content = this.topText;

      console.log(this.topic_content);
    },
    add_time(post_data) {
      console.log(post_data + "-----post_data");
      // this.content = post_data.mark_content;
      const _this = this;
      this.$http
        .post(
          "http://trendapi.show-fund.com/update_time_mark/",
          {
            coin_type: post_data.coin_type,
            mark_content: post_data.mark_content,
            mark_time: post_data.mark_time,
            trend_type: post_data.trend_type,
            topic_content: post_data.topic_content,
            record_id: this.record,
            priority: this.radio
          },
          {
            emulateJSON: true
          }
        )
        .then(function(response) {
          console.log(response);
          if (response.data.errcode === 0) {
            alert("更新成功!");
            // $(".form-page").hide();
            //_this.reload();
            _this.$emit("reload", "");
          } else {
            alert("标记失败!");
          }
        });
    },
    submitForm(formName) {
      //console.log(this.content);
      console.log(this.coinType, this.trendType, this.isday, this.markTime);
      var _that = this;

      //console.log(22, this.$refs[formName].model.desc);
      this.$refs[formName].validate(valid => {
        if (valid) {
          let arrcheckalldata = [];
          let strAlldata = "";
          for (var i = 0; i < this.$refs.tree.getCheckedKeys().length; i += 1) {
            arrcheckalldata.push(this.$refs.tree.getCheckedKeys()[i]);
          }
          strAlldata = arrcheckalldata.join(",");
          this.allCheckedone = strAlldata;
          var post_data = {
            mark_time: this.markTime,
            coin_type: this.allCheckedone,
            trend_type: this.allCheckedone,
            mark_content: this.contentall,
            topic_content: this.topic_content,
            record_id: this.record,
            priority: this.radio
          };
          //var timecore = this.value1;
          this.add_time(post_data);
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
  created() {
    //console.log(this.content)
    this.timeer();
  }
};
</script>