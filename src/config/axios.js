import Vue from 'vue'
import axios from 'axios';
import { Loading, Message } from 'element-ui';

var instance = axios.create({
    // baseURL: '/api/',
    baseURL: '/',
    timeout: 100000
});
// 添加请求拦截器
instance.interceptors.request.use(function (config) {
    // 在发送请求之前做些什么
    window.loading = Loading.service({
        background: 'rgba(255,255,255,0.05)',
        spinner:'el-icon-loading',
        fullscreen:false,
        text: '加载中...'
    });
    return config;
}, function (error) {
    window.loading.close();
    return Promise.reject(error);
});
instance.all = axios.all
instance.spread = axios.spread
// 添加响应拦截器
instance.interceptors.response.use(function (res) {
    // 对响应数据做点什么
    window.loading.close();
    return res;
}, function (error) {
    // 对响应错误做点什么
    Message({
        message: '接口异常',
        type: 'error'
    });
    window.loading.close();
    return Promise.reject(error);
});
// axios.defaults.retry = 8;
// axios.defaults.retryDelay = 1000;

// axios.interceptors.response.use(undefined, function axiosRetryInterceptor(err) {
//     var config = err.config;
//     // If config does not exist or the retry option is not set, reject
//     if(!config || !config.retry) return Promise.reject(err);

//     // Set the variable for keeping track of the retry count
//     config.__retryCount = config.__retryCount || 0;

//     // Check if we've maxed out the total number of retries
//     if(config.__retryCount >= config.retry) {
//         // Reject with the error
//         return Promise.reject(err);
//     }
//     // Increase the retry count
//     config.__retryCount += 1;

//     // Create new promise to handle exponential backoff
//     var backoff = new Promise(function(resolve) {
//         setTimeout(function() {
//             resolve();
//         }, config.retryDelay || 1);
//     });

//     // Return the promise in which recalls axios to retry the request
//     return backoff.then(function() {
//         return axios(config);
//     });
// });

Vue.prototype.$http = instance;

export { instance as $http }
