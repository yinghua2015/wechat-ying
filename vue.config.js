const mockdata = require('./src/assets/btc_net.json');
const mockdata1 = require('./src/assets/btc_net.json');
const mockdata2 = require('./src/assets/btc_in.json');
const mockdata6 = require('./src/assets/k_line.json');
const mockdata7 = require('./src/assets/config.json');
const mockdata8 = require('./src/assets/show.json');
const mockdata9 = require('./src/assets/eth.json');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const debug = process.env.NODE_ENV !== 'production'
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
module.exports = {
  baseUrl: './', // 基本路径
  outputDir: 'dist', // 输出文件目录
  lintOnSave: false, // eslint-loader 是否在保存的时候检查
  // use the full build with in-browser compiler?
  // https://vuejs.org/v2/guide/installation.html#Runtime-Compiler-vs-Runtime-only
  runtimeCompiler: false,
  configureWebpack:(config) => {
   config.plugins.push(
            new HtmlWebpackPlugin({

                inject : true,
                minify:{

                    removeAttributeQuotes: false,
            },
            })
        )
},
configureWebpack: config => {
if(!debug){
  const plugins = [];
      plugins.push(
          // new UglifyJsPlugin({
          //     // uglifyOptions: {
          //     //   "warnings": value
          //     //     // compress: {
          //     //     //     warnings: false,
          //     //     //     drop_console: true,
          //     //     //     drop_debugger: false,
          //     //     //     pure_funcs: ['console.log']//移除console
          //     //     // }
          //     // },
          //     sourceMap: false,
          //     parallel: true
          // })
      );
      config.plugins = [
          ...config.plugins,
          ...plugins
      ];
};

// Object.assign(config, { // 开发生产共同配置
//   resolve: {
//       alias: {
//           '@': path.resolve(__dirname, './src'),
//           '@c': path.resolve(__dirname, './src/components'),
//           'vue$': 'vue/dist/vue.esm.js'
//       }
//   }
// })
},

  chainWebpack: () => {},
//   configureWebpack: (minify) => {},
  // 如果想要引入babel-polyfill可以这样写
  // configureWebpack: (config) => {
  //   config.entry = ["babel-polyfill", "./src/main.js"]
  // },
  // vue-loader 配置项
  // https://vue-loader.vuejs.org/en/options.html
  // vueLoader: {},
  productionSourceMap: false, // 生产环境是否生成 sourceMap 文件
  // css相关配置
  css: {
    extract: true, // 是否使用css分离插件 ExtractTextPlugin
    sourceMap: false, // 开启 CSS source maps?
    loaderOptions: {}, // css预设器配置项
    modules: false // 启用 CSS modules for all css / pre-processor files.
  },
  // 是否为 Babel 或 TypeScript 使用 thread-loader。该选项在系统的 CPU 有多于一个内核时自动启用，仅作用于生产构建。
  parallel: require('os').cpus().length > 1,
  // PWA 插件相关配置
  pwa: { // 单页插件相关配置 https://github.com/vuejs/vue-cli/tree/dev/packages/%40vue/cli-plugin-pwa
    name: '一直涨',
    themeColor: '#4DBA87',
    msTileColor: '#000000',
    display:'standalone',
    appleMobileWebAppCapable: 'yes',
    appleMobileWebAppStatusBarStyle: 'black',

    // configure the workbox plugin
    workboxPluginMode: 'InjectManifest',
    workboxOptions: {
    // swSrc is required in InjectManifest mode.
    swSrc: 'src/sw.js',
    // ...other Workbox options...
    }
  },
  // webpack-dev-server 相关配置
  devServer: {
    disableHostCheck: true,
    open: true, // 自动开启浏览器
    compress: false, // 开启压缩
    port:9001,
    proxy: {
        '/api': {
            target: 'http://bigdata.show-fund.com',
            changeOrigin: true,
            ws: true,
            pathRewrite: {
              '^/api': ''
            }
        }
    },
    before(app){
          app.get('/goods/list',(req,res,next)=>{
            res.json(mockdata);
          })
          app.get('/goods/info1',(req,res,next)=>{
            res.json(mockdata1);
          })
          app.get('/goods/info2',(req,res,next)=>{
            res.json(mockdata2);
          })
          app.get('/goods/info6',(req,res,next)=>{
            res.json(mockdata6);
          })
          app.get('/goods/config',(req,res,next)=>{
            res.json(mockdata7);
          })
          app.get('/goods/show',(req,res,next)=>{
            res.json(mockdata8);
          })
          app.get('/goods/eth',(req,res,next)=>{
            res.json(mockdata9);
          })

    }
},
parallel: require('os').cpus().length > 1,
  // 第三方插件配置
  pluginOptions: {
    // ...
  }
}
