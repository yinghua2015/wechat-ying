<template>
    <div class="header">
      <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect" menu-trigger="click">
        <li class="el-menu-item" @click="asideToggle">
          <i class="iconfont" :class="{'icon-dedent':!asideFolded,'icon-indent':asideFolded}"></i>
        </li>
        <!-- <el-menu-item index="1">处理中心</el-menu-item>
        <el-submenu index="2">
          <template slot="title">我的工作台</template>
          <el-menu-item index="2-1">选项1</el-menu-item>
          <el-menu-item index="2-2">选项2</el-menu-item>
          <el-menu-item index="2-3">选项3</el-menu-item>
        </el-submenu> -->
      <!-- <select  v-bind:class="{active:isActive}" @change="moreChart_times()" v-model="times">
          <option v-for="s in moreTimes" :value="s.code">{{s.name}}</option>
      </select> -->
       <!-- <select v-bind:class="{active:isActive}" @change="moreChart_type()" v-model="ex">
          <option v-for="s in moreType" :value="s.code">{{s.name}}</option>
      </select> -->
        <el-select  v-bind:class="{active:isActive}" @change="moreChart_times()" v-model="times">
          <el-option v-for="s in moreTimes" :value="s.code" :label="s.name">{{s.name}}</el-option>
        </el-select>
        <el-select  v-bind:class="{active:isActive}" @change="moreChart_type()" v-model="ex">
          <el-option v-for="s in moreType" :value="s.code" :label="s.name">{{s.name}}</el-option>
        </el-select>

        <!-- <el-submenu index="4" class="login-info fr">
          <template slot="title">Admin</template>
          <el-menu-item index="4-1">退出登录</el-menu-item>
          <el-menu-item index="4-2">设置</el-menu-item>
        </el-submenu> -->
      </el-menu>
    </div>
</template>
<style scoped>
.active {
  width: 100px;
}
</style>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      formInline: {
        user: "",
        region: ""
      },
      isActive: true,
      activeIndex: "1",
      times: "1",
      ex: "Okex",
      moreTimes: [
        {
          name: "Day",
          code: "1"
        },
        {
          name: "hour",
          code: "0"
        }
      ],
      moreType: [
        {
          name: "Binance",
          code: "Binance"
        },
        {
          name: "Bitfinex",
          code: "Bitfinex"
        },
        {
          name: "Huobi",
          code: "Huobi"
        },
        {
          name: "Okex",
          code: "Okex"
        },
        {
          name: "all",
          code: "all"
        }
      ]
    };
  },
  created() {
    this.checkWidth();
    window.onresize = this.checkWidth;
  },
  methods: {
    checkWidth: function() {
      if (window.innerWidth > 500) {
        this.active = false;
        console.log(this.active);
        this.$store.commit("ASIDE_TOGGLE", false);
      } else {
        this.active = true;
        console.log(this.active);
        this.$store.commit("ASIDE_TOGGLE", true);
      }
    },
    asideToggle() {
      this.$store.commit("ASIDE_TOGGLE");
    },
    moreChart_times() {
      this.$store.commit("more_Times", this.times);
      console.log("切换选项" + this.times);
    },
    moreChart_type() {
      this.$store.commit("more_Type", this.ex);
      console.log("切换选项" + this.ex);
    },
    handleSelect(key, keyPath) {
      console.log(key, keyPath);
    }
  },
  computed: {
    ...mapGetters(["asideFolded"]),
    ...mapGetters(["more_Type"]),
    ...mapGetters(["more_Times"])
  }
};
</script>