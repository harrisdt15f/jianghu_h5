<template>
    <div class="login">
        <div class="pageTitle">
            <div class="textTitle">
                <span>登录</span>
                <div class="iconBack" @click="back"></div>
                <span class="forget" @click="open('/forgetPassword')">忘记密码</span>
            </div>
            <img class="circleC" src="../assets/mine/img_CircleC.png"/>
            <img class="circleA" src="../assets/mine/img_CircleA.png"/>
            <img class="circleB" src="../assets/mine/img_CircleB.png"/>
        </div>
        <div class="contentView">
            <img class="banner" :src="banner"/>
            <div class="loginBox">
                <img class="bgLogin" src="../assets/login/bg_Login.png"/>
                <img class="iconLogo" src="../assets/login/icon_Logo.png"/>
                <div class="editBar">
                    <div class="inputItem">
                        <div class="itemIcon">
                            <img class="icon" src="../assets/login/icon_Mobile.png"/>
                        </div>
                        <input type="text" class="inputEdit" v-model="mobile" placeholder="请输入手机号码（11位数字）" @blur="checkMobile" @keyup="limitMobile" maxlength="11">
                    </div>
                    <div class="inputItem">
                        <div class="itemIcon">
                            <img class="icon" src="../assets/login/icon_Lock.png"/>
                        </div>
                        <input class="inputEdit" :type="placeholderState" v-model="password" placeholder="请输入密码（8-16位英文和数字组合）" @blur="checkPassword" @keyup="limitPassword" maxlength="16">
                        <img v-if="placeholderState==='password'" class="iconEye" @click="eyeState('text')" src="../assets/mine/icon_EyeClose.png"/>
                        <img v-if="placeholderState==='text'" class="iconEye" @click="eyeState('password')" src="../assets/mine/icon_EyeOpen.png"/>
                    </div>
                </div>
                <div class="commit" @click="toDoLogin">登录</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                banner:require("../assets/homePage/bannerA.png"),
                placeholderState:"password",
                mobile:"18844446666",
                password:"12345Eth",
            }
        },

        methods:{
            open(path){all.router.push(path)},
            back(){
                all.tool.clearStore("guardPath");
                all.router.push("/");
            },
            eyeState(value){this.placeholderState=value},
            limitMobile(){this.mobile=this.mobile.match(/[0-9]*/i)[0]},
            checkMobile(){
                if(this.mobile.length===0){
                    all.tool.editTipShow("手机号码不能为空！");
                    return false;
                }
                else if(!/^1[3456789][0-9]{9}$/.test(this.mobile)){
                    all.tool.editTipShow("请输入正确的11位手机号码！");
                    return false
                }
                else return true;
            },
            limitPassword(){this.password=this.password.match(/[a-zA-Z0-9]*/i)[0]},
            checkPassword(){
                if(this.password.length===0){
                    all.tool.editTipShow("密码不能为空！");
                    return false
                }
                else if(!/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,16}$/.test(this.password)){
                    all.tool.editTipShow("密码为8-16位字母和数字组合！");
                    return false
                }
                else return true;
            },
            toDoLogin(){
                if(this.checkMobile() && this.checkPassword()){
                    all.tool.send("login",{mobile:this.mobile,password:this.password},res=>{
                        all.tool.setStore("Authorization",res.data.token_type+" "+res.data.access_token);
                        all.tool.send("information",null,res=>{
                            all.tool.setLoginData(res.data);
                            all.tool.send("dynamicInformation",null,res=>{
                               all.tool.setInformation(res.data);
                                if(all.tool.getStore("guardPath")){
                                    all.router.push(all.tool.getStore("guardPath"));
                                    all.tool.clearStore("guardPath");
                                }
                                else all.router.push("/");
                            });
                        });
                    });
                }
            },
        },
        created() {
            all.tool.send("slides",{flag:"2"},res=>{res.data.forEach(item=>{if(item.redirect_url==="login")this.banner=item.pic_path})})
        }
    }
</script>

<style scoped>
    .login{
        display:flex;
        flex-direction:column;
        background:#eeeeee;
    }
    .pageTitle{
        height:3.3rem;
        background:linear-gradient(90deg,#51a1ff,#1d7ef0);
        color:#fff;
        padding:0 0.3rem;
        flex-shrink:0;
    }
    .iconBack{
        width:0.5rem;
        height:0.5rem;
        background:url("../assets/activity/btn_Back.png") no-repeat left center;
        background-size:0.18rem 0.34rem;
        position:absolute;
        left:0.3rem;
        z-index:5;
    }
    .textTitle{
        height:1rem;
        display:flex;
        justify-content:center;
        align-items:center;
        font-size:0.36rem;
        font-weight:400;
        position:relative;
    }
    .forget{
        font-size:0.24rem;
        color:#ffffff;
        position:absolute;
        right:0;
    }
    .circleA{
        width:2.58rem;
        height:auto;
        position:absolute;
        top:0.2rem;
        left:0.5rem;
        z-index:1;
    }
    .circleB{
        width:1.65rem;
        height:auto;
        position:absolute;
        top:1.8rem;
        left:4.8rem;
        z-index:1;
    }
    .circleC{
        width:1.1rem;
        height:auto;
        position:absolute;
        top:0.7rem;
        left:2.7rem;
        z-index:1;
    }
    .contentView{
        margin:-2.3rem 0 0;
        flex:1;
        display:flex;
        align-items:center;
        flex-direction:column;
        overflow:scroll;
    }
    .banner{
        width:6.9rem;
        height:3rem;
        margin-bottom:0.3rem;
        flex-shrink:0;
        border-radius:0.15rem;
        box-shadow:0 0.01rem 0.03rem rgba(0,27,97,0.5);
    }
    .loginBox{
        width:6.9rem;
        height:5.1rem;
        border-radius:0.08rem;
        background:#20a6f9;
        box-shadow:0 0.01rem 0.03rem rgba(0,27,97,0.5);
        position:relative;
        display:flex;
        flex-direction:column;
        align-items:center;
        flex-shrink:0;
        margin-bottom:0.5rem;
    }
    .bgLogin{
        width:6.61rem;
        height:1.35rem;
        position:absolute;
        left:0;
        top:0;
    }
    .iconLogo{
        width:1.93rem;
        height:0.5rem;
        margin:0.3rem 0;
    }
    .editBar{
        width:6.5rem;
        height:2.7rem;
        border-radius:0.08rem;
        background:#ffffff;
        padding-top:0.4rem;
        display:flex;
        flex-direction:column;
        align-items:center;
    }
    .inputItem{
        width:5.4rem;
        height:0.8rem;
        background:url("../assets/login/bg_Edit.png") no-repeat;
        background-size:100% 100%;
        display:flex;
        align-items:center;
        margin-bottom:0.3rem;
        position:relative;
        flex-shrink:0;
    }
    .inputItem:last-child{
        margin-bottom:0;
    }
    .itemIcon{
        width:0.8rem;
        height:0.8rem;
        display:flex;
        justify-content:center;
        align-items:center;
    }
    .icon{
        height:0.3rem;
        width:auto
    }
    .inputEdit{
        flex:1;
        height:0.8rem;
        border:none;
        background:none;
        font-size:0.3rem;
        color:#ffffff;
    }
    .inputEdit::placeholder{
        font-size:0.24rem;
        color:#e9e9e9
    }
    .iconEye{
        width:0.35rem;
        height:auto;
        position:absolute;
        right:0.2rem;
    }
    .commit{
        font-size:0.34rem;
        color:#ffffff;
        width:4.8rem;
        height:0.7rem;
        border-radius:0.08rem;
        background:url("../assets/login/bg_Commit.png") no-repeat;
        background-size:100% 100%;
        display:flex;
        justify-content:center;
        align-items:center;
        margin-top:0.3rem;
        box-shadow:0 0.01rem 0.03rem rgba(0,27,97,0.5);
    }
</style>
