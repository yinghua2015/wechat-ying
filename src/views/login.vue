<template>
<div class="back-login">
  <!-- <div class="el-loading-mask"></div> -->
  <div class="login">
    <el-row :gutter="10">
      <el-col :span="4"> 账号：</el-col>
      <el-col :span="20">
        <el-input
          placeholder="请输入账号"
          v-model="name">
        </el-input>
      </el-col>
    </el-row>
    <el-row :gutter="10">
      <el-col :span="4"> 密码：</el-col>
      <el-col :span="20">
        <el-input
          type="password"
          placeholder="请输入密码"
          v-model="password">
        </el-input>
      </el-col>
    </el-row>
    <el-button type="primary" @click="login" class="logins">登录</el-button>
  </div>
  </div>
</template>

<script>
import $ from "jquery";
export default {
  name: "login",
  data() {
    return {
      name: "",
      password: ""
    };
  },
  mounted() {
    $(".aside-wrap").hide();
    $(".header").hide();
  },
  methods: {
    login() {
      // localStorage.setItem('token','111');
      // router.push('./chain/chart01');
      // if(!this.name) return
      // if(!this.password) return
      // if(this.name === 'chen' && this.password === 'chen') {
      //   this.$router.push('/index')
      // } else {
      //   this.$message.error('账号或密码错了哦！！！');
      // }
      // this.$http.post('../login.php',{params:{'name':this.name,'pwd':this.password}}).then(res => {
      //   console.log(res)
      //   // localStorage.setItem('token', res)
      //   // location.replace('/index')
      // })
      var that = this;
      $.ajax({
        type: "post",
        url: "../login.php",
        data: { name: this.name, pwd: this.password },
        dataType: "json",
        success: function(response) {
          if (response.resultCode === 200) {
            that.$message({
              showClose: true,
              message: "登录成功，欢迎使用您的专属币圈工具一直涨",
              type: "success"
            });
            //sessionStorage.setItem("token", response.resultCode);
            localStorage.setItem("token", response.resultCode);
            router.push("./chain/chart01");
          } else if (response.resultCode === 500) {
            that.$message({
              showClose: true,
              message: "账号或密码错了哦",
              type: "error"
            });
            //this.$message.error('账号或密码错了！！！');
          }
        }
      });
    }
  }
  // created(){
  //  router.push('./Home.vue')
  // }
};
</script>
<style lang="less" scoped>
#app {
  position: relative;
  width: 100%;
  height: auto;
  min-height: 100%;
  margin-top: 0px !important;
}
.content {
  position: static !important;
}
.back-login {
  position: fixed;
  top: 0;
  background: url(../assets/images/Back01.png) no-repeat;
  width: 100%;
  height: 100vh;
  left: 0;
  background-position: center;
  background-size: cover;
}
.login {
  position: fixed;
  width: 500px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  background: rgba(39,147,206,.32156863);
  padding: 25px;
  color: #fff;
  border-radius: 10px;
  .el-row {
    margin-top: 10px;
    line-height: 40px;
  }
  .logins {
    width: 60%;
    margin-top: 50px;
  }
}
@media screen and (max-width: 768px) {
  #app {
    position: relative;
    width: 100%;
    height: auto;
    min-height: 100%;
    margin-top: 0px !important;
  }
  .content {
    position: static !important;
  }
  .back-login {
    position: fixed;
    top: 0;
    background: url(../assets/images/Back_IPhone.png) no-repeat;
    width: 100%;
    height: 100vh;
    left: 0;
    background-position: center;
    background-size: cover;
  }
  .login {
    position: absolute;
    width: 100%;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    background: rgba(39, 147, 206, 0.3215686274509804);
    padding: 25px;
    color: #fff;
  }
}
</style>
