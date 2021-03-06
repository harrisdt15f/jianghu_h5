import tipWin from "../pages/components/tipWin";

const Tool = {//工具汇总

    //TODO 本地存储类工具*************************************************************************//

    setStore: (key, val) => sessionStorage.setItem(key, JSON.stringify(val)),//保存本地信息
    getStore: key => JSON.parse(sessionStorage.getItem(key)),//获取本地信息
    clearStore: key => sessionStorage.removeItem(key),  // 清除session
    setCookie: (key, val) => document.cookie = key + '=' + val,//保存本地cookie信息
    getCookie: key => { //获取本地cookie信息
        let val = false;
        document.cookie.split("; ").map(item => {
            if (item.split("=")[0] === key)
                val = item.split("=")[1]
        });
        return val
    },
    delCookie: key => {//删除本地cookie信息
        let exp = new Date();
        exp.setTime(exp.getTime() - 1);
        if (all.tool.getCookie(key) !== null) {
            all.tool.setCookie(key, all.tool.getCookie(key) + ";expires=" + exp.toGMTString())
        }
    },
    setLocal: (key, val) => localStorage.setItem(key, JSON.stringify(val)), // 设置localStorage
    getLocal: key => JSON.parse(localStorage.getItem(key)),  // 获取localStorage
    //工具类别分割线---------------------------------------------------------------------------------------------//

    //TODO 屏幕控制类工具*************************************************************************//
    clientIos: () => { //判断是否苹果设备工具
        if(window.navigator.platform.slice(0, 2) === 'iP')return true;
        return false;
    },
    fullScreen: element => {//屏幕全屏工具
        if(!element)element=document.documentElement;
        element.requestFullScreen && element.requestFullScreen();
        element.webkitRequestFullScreen && element.webkitRequestFullScreen();
        element.mozRequestFullScreen && element.mozRequestFullScreen();
    },
    exitFullScreen: () => {//退出全屏工具
        document.exitFullscreen && document.exitFullscreen();
        document.msExitFullscreen && document.msExitFullscreen();
        document.mozCancelFullScreen && document.mozCancelFullScreen();
        document.webkitExitFullscreen && document.webkitExitFullscreen()
    },
    isFullScreen: () => document.fullscreenEnabled || document.mozFullscreenElement || document.webkitFullscreenElement,//判断是否全屏工具
    rotationScreenIos: () => {//IOS设备屏幕旋转事件工具
        setTimeout(()=>{
            if(window.innerHeight<window.innerWidth){
                // alert("横版屏幕旋转事件");
                all.store.commit("isHorizontal",true)
            }else {
                // alert("竖版屏幕旋转事件");
                all.store.commit("isHorizontal",false)
            }
        },200)

    },
    rotationScreenAndroid: () => {//Android设备屏幕旋转事件工具
        if(window.screen.availWidth>window.screen.availHeight){
            // console.log("横版屏幕旋转事件");
            all.store.commit("isHorizontal",true)
        }else {
            // console.log("竖版屏幕旋转事件");
            all.store.commit("isHorizontal",false)
        }
    },

    //工具类别分割线---------------------------------------------------------------------------------------------//

    //TODO 网络请求类工具*************************************************************************//
    send:(url,data,success,fail)=>{console.log("向接口"+url+"发送数据",data);
        let apiUrl=null;
        let sendType=null;
        if(url.slice(0,8)==="openGame"){apiUrl=url.slice(8);sendType="get"}
        /*else if(url.slice(0,6)==="online"){apiUrl=url.slice(31);sendType="post"}*/
        else if(url.slice(0,11)==="setPassword"){apiUrl=url.slice(11);sendType="post"}
        else if(!all.config.api[url])return all.tool.editTipShow("API不存在或已失效");
        else {apiUrl=all.config.api[url].url;sendType=all.config.api[url].method}
        all.http({
            method:sendType,
            url:apiUrl,
            data:data
        }).then(res=>{console.log('接口'+url+'返回数据',res);typeof(success)==="function"?success(res):null}).catch(err=>{typeof(fail)==="function"?fail(err):null});
    },
    encrypt:data=>{
        let IV=all.tool.randomString(16);
        let KEY=all.tool.randomString(16);
        let publicKey="-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCgy6JOupuDqE9itVQvGSBDJotBEJFASuklIwvcMNtXUH99PdihJ+TJN2AjNphzCdgL9KlguDG+u4C719DZOC3YrGn7Ps9vWOFtQYLzh69cGd+nlqOR4LKVSAYRn2NtrV9elAzBjie/Y7ITMsU9+ZTsccRqb+qd+OlBsYdg9dhvVQIDAQAB-----END PUBLIC KEY-----";
        if(data!==null && Object.keys(data).length!==0){
            let key_utf8 = all.CryptoJS.enc.Utf8.parse(KEY);// 秘钥
            let iv_utf8= all.CryptoJS.enc.Utf8.parse(IV);//向量iv
            let srcs = typeof (data)==='string'?all.CryptoJS.enc.Utf8.parse(data):typeof (data)==='object'?all.CryptoJS.enc.Utf8.parse(JSON.stringify(data)):all.CryptoJS.enc.Utf8.parse(data.toString());
            //AES 加密
            let encrypted = all.CryptoJS.AES.encrypt(srcs, key_utf8, { iv: iv_utf8, mode: all.CryptoJS.mode.CBC, padding: all.CryptoJS.pad.Pkcs7}).toString();
            //RSA 加密 组包
            let jsencrypt = new all.JSEncrypt();
            jsencrypt.setKey(publicKey);
            let rsa_iv =  jsencrypt.encrypt(IV);
            let rsa_key = jsencrypt.encrypt(KEY);
            let splitFlag = 'aesrsastart';
            return encrypted+splitFlag+rsa_iv+splitFlag+rsa_key;
        }
    },
    decrypt:data=>{
        if (Object.keys(data).length === 1){
            let cryptData = data.data;
            if (cryptData !== null) {
                let cryptDataArr = cryptData.split("hDdoAPaXI3S");
                if (cryptDataArr.length === 3) {
                    let cryptDataStr = cryptDataArr[0];
                    let privateKey = "-----BEGIN PRIVATE KEY-----MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAPTYUA2oNnnEwCM+firQEh3qtvhzy2sPcCCPBuk1ALN98ThFtwbsAIXn4iflC8cL74OxsW5LhVLqRaNJwrj19nUWRNg2V0UG0qiSMDoFQzcf14Tl3YEMVhHmhT60KEc/mcOkGp7BGFneNRkUrnAedUPaI18hHfwlOXCTBOXjsLEHAgMBAAECgYAOsZCUUTz7r8gMFWsC7Lu5meVjIafag/GpsouqoSiqnOtGAkEKpE0fvBvBYyiCyH+WOqq4QMX+hNqrAvkxmmkw3Zj6pqGIGBm8qP0sC7kV9l3+1GyNweBaPqnZs02Kb3WCZnw8h1NaJRR9uqXFITzLkNgxEOuq9oiQqmI9UmP7sQJBAP1qL2O32RS/i08lCHR1r/XQTF/0pkSPX+a6SEf25iewzKm5do8hOtSG7+zjOlOQwsGwCPuNovz5g8BPMv2juQ8CQQD3V78skMtTp+0c6WjVh5ORIkkYAyOnSfl3nigkQKCfGyiTwX1cm3GLTHkDHZBVJjFyz8U/ngZZbG8ScHZCMtiJAkEAroiApQxNXaXiu5rE7PjVPNa+k2P7U8LviQiJmc7pizKQcuDCUCfRzeg1vJBvbniIOkAUn7RYKiVrYXrqopgtbwJAd+zzpIgQDd+99+a0DdROmHAnQJ1FDDex3W2xyOIM/xgL9Jg8UEqOIxxREFGlSaPbFe/nk5DrQzBwKmCc9jvxAQJALe9ZaKqPeZywh2aUa8huotTe5lj/iDeGdHOgxx4xkDK9ddzuSks1dbJQ/gHl8lA7MjOI6TvtgeLB9FOOvsi5EQ==-----END PRIVATE KEY-----";
                    let jsencrypt = new all.JSEncrypt();
                    jsencrypt.setPrivateKey(privateKey);
                    let iValue = jsencrypt.decrypt(cryptDataArr[1]);
                    let iKey = jsencrypt.decrypt(cryptDataArr[2]);
                    let decrypted = '';
                    decrypted=all.CryptoJS.AES.decrypt(cryptDataStr,all.CryptoJS.enc.Utf8.parse(iKey),{
                        iv : all.CryptoJS.enc.Utf8.parse(iValue),
                        mode : all.CryptoJS.mode.CBC,
                        padding : all.CryptoJS.pad.Pkcs7
                    });
                    return JSON.parse(decrypted.toString(all.CryptoJS.enc.Utf8));
                }
            }
        }
    },
    randomString:len=>{
        len = len || 32;
        let chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678'; //默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1
        let maxPos = chars.length;
        let pwd = '';
        for (let i = 0; i < len; i++) {
          pwd += chars.charAt(Math.floor(Math.random() * maxPos));
        }
        return pwd;
    },
    //工具类别分割线---------------------------------------------------------------------------------------------//

    //TODO 项目控制类工具*************************************************************************//

    tipWinShow:(content,callback,type)=>{
        all.store.commit("tipWin",{isShow:true,content:content,callback:typeof(callback)==="function"?callback:null,type:type?{icon:type.icon?type.icon:"right",name:type.name?type.name:"确定"}:{icon:"right",name:"确定"}})
    },
    tipWinHide:()=>{all.store.commit("tipWin",{isShow:false,content:"",type:null})},
    editTipShow:content=>{all.store.commit("editTip",{isShow:true,content:content})},
    editTipHide:()=>{all.store.commit("editTip",{isShow:false,content:""})},
    setLoginData:data=>{
        all.store.commit("isLogin",true);
        all.tool.setStore("isLogin",true);
        all.store.commit("nickName",data.nickname);
        all.store.commit("guid",data.guid);
        all.store.commit("userPicture",data.avatar);
    },
    setLogoutData:()=>{
        all.store.commit("isLogin",false);
        all.tool.clearStore("isLogin");
        all.store.commit("nickName","");
        all.store.commit("guid","");
        all.store.commit("userPicture",require("../assets/homePage/img_User.png"));
        all.store.commit("amount","");
        all.tool.clearStore("Authorization")
    },
    setInformation:data=>{
        all.store.commit("amount",data.balance);
        all.store.commit("vipLevel",data.grade);
        all.store.commit("experience",data.experience);
    },
    getBeforeDate:(today,n)=>{//获取N天前日期
        let date = new Date(today);
        let year = date.getFullYear();
        let mon=date.getMonth()+1;
        let day=date.getDate();
        if(day<=n){
            if(mon>1)mon=mon-1;
            else {year=year-1;mon=12}
        }
        date.setDate(date.getDate()-n);
        year=date.getFullYear();
        mon=date.getMonth()+1;
        day=date.getDate();
        return year+"-"+(mon<10?('0'+mon):mon)+"-"+(day<10?('0'+day):day)+" "+"00:00:00";
    },

    //工具类别分割线---------------------------------------------------------------------------------------------//
};
export default Tool;
