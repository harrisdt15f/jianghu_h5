// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './js/router'
import store from './js/vuex'
import tool from './js/tool'
import config from './js/config'
import animate from 'animate.css'
import $ from 'jquery'
import http from 'axios'
import forge from 'node-forge'
import CryptoJS from 'crypto-js'
import {JSEncrypt} from 'jsencrypt'
import VueClipboard from 'vue-clipboard2'


Vue.config.productionTip = false;
Vue.use(VueClipboard,animate);
window.all={};
all.store=store;
all.router=router;
all.tool=tool;
all.config=config;
all.forge=forge;
all.CryptoJS=CryptoJS;
all.JSEncrypt=JSEncrypt;
all.http=http.create({
    baseURL:all.config.basePath,
    timeout:5000,
    header:{
        'X-Requested-With':'XMLHttpRequest',
        'content-type':'application/x-www-form-urlencoded'
    },
    // validateStatus:status=>{return status>=100 && status<=600}
});
// all.http.defaults.withCredentials=true;
all.tool.setStore("isShowDownLoad",true);
all.http.interceptors.request.use(req=>{
    let Authorization=all.tool.getStore("Authorization");
    let notLoginApi=req.url.indexOf("h5-api/login")===-1;
    if(Authorization && notLoginApi)req.headers.Authorization=Authorization;
    let encryptData=all.tool.encrypt(req.data);
    req.data={};
    req.data.data=encryptData;
    all.store.commit("isLoading",true);
    return req;
});
if(all.tool.getStore("Authorization")){
    all.tool.send("information",null,res=>{
        all.store.commit("isLoading",false);
        all.tool.setLoginData(all.tool.decrypt(res.data).data);console.log("个人信息",all.tool.decrypt(res.data))
    },err=>{
        all.store.commit("isLoading",false);
    });
    all.tool.send("dynamicInformation",null,res=>{
        all.store.commit("isLoading",false);
        all.tool.setInformation(all.tool.decrypt(res.data).data);console.log("频繁个人信息",all.tool.decrypt(res.data))
    },err=>{
        all.store.commit("isLoading",false);
    });
}
all.http.interceptors.response.use(res=>{
    all.store.commit("isLoading",false);
    return Promise.resolve(all.tool.decrypt(res.data));
    },error=>{
    all.store.commit("isLoading",false);
    error.response.data=all.tool.decrypt(error.response.data);
    console.log("拦截器",error.response);
    if(error.response.status===401){
        all.tool.clearStore("isLogin");
        all.tool.tipWinShow(error.response.data.message,()=>{all.router.push("/login")},{icon:"warn",name:"前往登陆"});
    }
    if(error.response.status===403){
        let code=error.response.data.code;
        if(code==="100700" || code==="100701" || code==="100702" || code==="100703" || code==="100704" || code==="100705" || code==="100706" || code==="100707" || code==="100708"){
            all.tool.tipWinShow("游戏维护中...",()=>{},{icon:"warn"});
        }else {
            all.tool.tipWinShow(error.response.data.message,()=>{},{icon:"error"});
        }
    }
    if(error.response.status===404)all.tool.tipWinShow("页面丢失",()=>{},{icon:"error"});
    if(error.response.status===405)all.tool.tipWinShow("系统故障，请联系客服",()=>{},{icon:"error"});
    if(error.response.status===429)all.tool.tipWinShow(error.response.data.message,()=>{},{icon:"warn"});
    if(error.response.status===500)all.tool.tipWinShow(error.response.data.message,()=>{},{icon:"error"});
    return Promise.reject(error)
});
all.$=$;
all.router.beforeEach((to,from,next)=>{
    let safePath=false;
    if(all.tool.getStore("isLogin")){safePath=true}
    all.config.routerGuard.forEach(item=>{
        if(to.path===item)safePath=true
    });
    if(safePath)next();
    else {
        all.tool.editTipShow("请先登录！");
        all.tool.setStore("guardPath",to.path);
        all.router.push("/login");
    }
});
/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App/>'
});

all.tool.clientIos()?window.onorientationchange=all.tool.rotationScreenIos:window.screen.orientation.onchange=all.tool.rotationScreenAndroid;
if(window.screen.availWidth>window.screen.availHeight || window.innerWidth>window.innerHeight)all.store.commit("isHorizontal",true);
