<template>
    <div class="homePage">
        <div class="pageTitle">
            <div class="userInfo animated bounceInLeft" v-if="this.$store.state.isLogin">
                <img class="imgUser" @click="fullScreen" :src="this.$store.state.userPicture"/>
                <div class="nameId">
                    <div class="name" v-text="this.$store.state.nickName"></div>
                    <div class="id" v-text="'ID：'+this.$store.state.guid">ID：189673</div>
                </div>
                <div class="amountBar">
                    <img class="iconGoldCoin" src="../assets/homePage/icon_GoldCoin.png"/>
                    <div class="amount" v-text="this.$store.state.amount"></div>
                    <img class="iconAdd" @click="toReCharge" src="../assets/homePage/icon_Add.png"/>
                </div>
            </div>
            <div class="shortcutMenu">
                <img class="iconLogo animated flipInX" src="../assets/login/icon_Logo.png"/>
                <img class="iconService animated bounceInRight" @click="open('onlineService')" src="../assets/homePage/icon_Service.png"/>
                <div class="menuText animated bounceInRight" v-if="!this.$store.state.isLogin" @click="open('/login')">登录</div>
                <div class="menuText animated bounceInRight" v-if="!this.$store.state.isLogin" @click="open('/register')">注册</div>
            </div>
        </div>
        <div class="contentView">
            <div class="bannerBox animated fadeInDown faster" @touchstart.capture="touchStart" @touchend.capture="touchEnd" @touchmove.capture="touchMove">
                <div class="bannerImg">
                    <img v-for="item in bannerList" class="banner" :src="item.pic_path" @click="connect(item)"/>
                </div>
                <div class="bannerPoint">
                    <div v-for="(item,index) in bannerList" class="point" :class="{currentPoint:index===currentIndex}"></div>
                </div>
            </div>
            <div class="noticeBox animated flipInX faster">
                <img class="noticeIcon animated tada infinite" src="../assets/homePage/icon_Notice.png"/>
                <marquee class="noticeText" align="left" behavior="scroll" direction="left" scrollamount="5" scrolldelay="100">
                    恭喜玩家 “江湖王者”在飞禽走兽中一掷1000金币，成功登上本周单次下注榜首...
                </marquee>
            </div>
            <div class="gameBox">
                <div class="gameItem animated fast" @click="open('/gameList',item)" :class="{flipInX:index%2===0,flipInY:index%2===1}" v-for="(item,index) in gameList">
                  <img class="gameBg" :src="gameBg[index]"/>
                  <img class="gameTitle" :src="gameTitle[index]"/>
                  <img :class="gameIconClass[index]" :src="gameIcon[index]"/>
                  <div class="gameText" v-text="gameText[index]">赚现金 赢大奖</div>
                </div>
                <!--<div class="gameItem animated flipInX fast">
                    <img class="gameBg" src="../assets/homePage/bg_GameA.png"/>
                    <img class="gameTitle" src="../assets/homePage/title_GameA.png"/>
                    <img class="gameIconA" src="../assets/homePage/icon_GameA.png"/>
                    <div class="gameText">赚现金 赢大奖</div>
                </div>
                <div class="gameItem animated flipInY fast">
                    <img class="gameBg" src="../assets/homePage/bg_GameB.png"/>
                    <img class="gameTitle" src="../assets/homePage/title_GameB.png"/>
                    <img class="gameIconB" src="../assets/homePage/icon_GameB.png"/>
                    <div class="gameText">最热门的都在这里</div>
                </div>
                <div class="gameItem animated flipInY fast">
                    <img class="gameBg" src="../assets/homePage/bg_GameC.png"/>
                    <img class="gameTitle" src="../assets/homePage/title_GameC.png"/>
                    <img class="gameIconC" src="../assets/homePage/icon_GameC.png"/>
                    <div class="gameText">更大威力炮台发射</div>
                </div>
                <div class="gameItem animated flipInX fast">
                    <img class="gameBg" src="../assets/homePage/bg_GameD.png"/>
                    <img class="gameTitle" src="../assets/homePage/title_GameD.png"/>
                    <img class="gameIconD" src="../assets/homePage/icon_GameD.png"/>
                    <div class="gameText">娱乐赚钱两不误</div>
                </div>
                <div class="gameItem animated flipInX fast">
                    <img class="gameBg" src="../assets/homePage/bg_GameE.png"/>
                    <img class="gameTitle" src="../assets/homePage/title_GameE.png"/>
                    <img class="gameIconE" src="../assets/homePage/icon_GameE.png"/>
                    <div class="gameText">真人荷官现在发牌</div>
                </div>
                <div class="gameItem animated flipInY fast">
                    <img class="gameBg" src="../assets/homePage/bg_GameF.png"/>
                    <img class="gameTitle" src="../assets/homePage/title_GameF.png"/>
                    <img class="gameIconF" src="../assets/homePage/icon_GameF.png"/>
                    <div class="gameText">中奖几率翻一翻</div>
                </div>-->
            </div>
            <div class="shortcutTitle animated flash">热门游戏</div>
            <div class="shortcutGameBox animated fadeInUp faster" :class="{downloadHeight:isShowDownLoad}">
                <div class="hotGame" @click="getGame(item)" v-for="(item,index) in hotGame" v-if="index<10">
                    <img class="imgGame" :src="item.icon"/>
                    <span class="nameGame" v-text="item.name"></span>
                </div>
            </div>
            <div class="downloadBox animated fadeInUp fast delay-500" v-if="isShowDownLoad">
                <div class="downloadContent">
                    <img class="iconFish animated bounce infinite slower" src="../assets/homePage/icon_Fish.png"/>
                    <img class="textDownload animated flash infinite slower" src="../assets/homePage/text_Download.png"/>
                    <img class="iconGold animated pulse infinite" src="../assets/homePage/icon_Gold.png"/>
                    <img class="btnDownload animated wobble infinite slower" src="../assets/homePage/btn_Download.png"/>
                </div>
            </div>
        </div>
        <comMenu/>
        <setGamePassword v-if="this.$store.state.setGamePassword.isShow"/>
    </div>
</template>

<script>
    import comMenu from '../pages/components/menu'
    import setGamePassword from '../pages/components/setGamePassword'
    export default {
        components:{
            comMenu,
            setGamePassword
        },
        data () {
            return {
                isShowDownLoad:all.tool.getStore("isShowDownLoad"),
                currentIndex:0,
                bannerList:[],
                gameList:[],
                gameDetailList:[],
                gameText:[
                    "赚现金　赢大奖",
                    "最热门的都在这里",
                    "更大威力炮台发射",
                    "娱乐赚钱两不误",
                    "真人性感荷官发牌",
                    "超高中奖机率"
                ],
                gameBg:[
                    require("../assets/homePage/bg_GameA.png"),
                    require("../assets/homePage/bg_GameB.png"),
                    require("../assets/homePage/bg_GameC.png"),
                    require("../assets/homePage/bg_GameD.png"),
                    require("../assets/homePage/bg_GameE.png"),
                    require("../assets/homePage/bg_GameF.png"),
                ],
                gameTitle:[
                    require("../assets/homePage/title_GameA.png"),
                    require("../assets/homePage/title_GameB.png"),
                    require("../assets/homePage/title_GameC.png"),
                    require("../assets/homePage/title_GameD.png"),
                    require("../assets/homePage/title_GameE.png"),
                    require("../assets/homePage/title_GameF.png"),
                ],
                gameIcon:[
                    require("../assets/homePage/icon_GameA.png"),
                    require("../assets/homePage/icon_GameB.png"),
                    require("../assets/homePage/icon_GameC.png"),
                    require("../assets/homePage/icon_GameD.png"),
                    require("../assets/homePage/icon_GameE.png"),
                    require("../assets/homePage/icon_GameF.png"),
                ],
                gameIconClass:[
                    "gameIconA",
                    "gameIconB",
                    "gameIconC",
                    "gameIconD",
                    "gameIconE",
                    "gameIconF",
                ],
                timeRun:null,
                hotGame:[],
            }
        },
        watch:{
            currentIndex:{
                handler(newVal,oldVal){
                    all.$(".bannerImg").animate({left:0-this.currentIndex*parseInt(all.$(".bannerImg").width())},200);
                },
                deep:true
            },
        },
        methods:{
            open(path,item){
                if(item)all.tool.setStore("gameClass",item);
                if(item)all.tool.setStore("gameDetailList",this.gameDetailList);
                all.router.push(path)
            },
            getGame(item){
                all.tool.send("openGame"+item.url,null,res=>{
                    if(res.data.type===1){
                        all.tool.setStore("gameFrameTitle",item.name);
                        all.tool.setStore("gameFrameUrl",res.data.url);
                        all.router.push("/gameFrame")
                    }
                    if(res.data.type===2){
                        all.store.commit("setGamePassword",{isShow:true,registerUrl:res.data.url,item:item})
                    }
                });
            },
            closeDownLoad(){
                all.$(".downloadBox").removeClass("delay-500").addClass("fadeOutDown");
                setTimeout(()=>{
                    all.tool.setStore("isShowDownLoad",false);
                    this.isShowDownLoad=false
                },500)
            },
            connect(item){
                if(item.type===1)this.open(item.redirect_url);
                if(item.type===2)window.open(item.redirect_url);
            },
            toReCharge(){
                all.tool.setStore("currentMenu",2);
                this.open("/reCharge")
            },
            fullScreen(){all.tool.fullScreen()},
            touchStart(e){
                clearInterval(this.timeRun);
                this.timeRun=null;
                this.startX=e.touches[0].clientX;
                this.left=parseInt(all.$(".bannerImg").css("left"));
            },
            touchMove(e){
                let move=this.startX-e.changedTouches[0].clientX;
                let moveLeftAvail=all.$(".bannerImg").width()*(this.bannerList.length-this.currentIndex-1);
                let moveRightAvail=all.$(".bannerImg").width()*this.currentIndex;
                if(move>moveLeftAvail)return;
                if(move<0-moveRightAvail)return;
                all.$(".bannerImg").css("left",this.left-move);
            },
            touchEnd(e){
                this.endX=e.changedTouches[0].clientX;
                if((this.startX-this.endX)>all.$(".banner").width()/4 && this.currentIndex<this.bannerList.length-1)this.currentIndex+=1;
                if((this.startX-this.endX)<0-all.$(".banner").width()/4 && this.currentIndex>0)this.currentIndex-=1;
                all.$(".bannerImg").animate({left:0-this.currentIndex*parseInt(all.$(".bannerImg").width())},150);
                this.startX=0;
                this.endX=0;
                this.timeRun=setInterval(()=>{this.currentIndex<this.bannerList.length-1?this.currentIndex+=1:this.currentIndex=0},4000);
            },
        },
        created() {
            setTimeout(()=>{this.closeDownLoad()},10000);
            this.timeRun=setInterval(()=>{this.currentIndex<this.bannerList.length-1?this.currentIndex+=1:this.currentIndex=0},4000);
            all.tool.send("slides",{flag:"1"},res=>{this.bannerList=res.data});
            all.tool.send("gameList",{device:2},res=>{
                this.gameList=res.data.raw;
                this.gameDetailList=res.data.list;
                for(let key in res.data.list){
                    for(let item in res.data.list[key]){
                        res.data.list[key][item].forEach(game=>{
                            if(game.hot_new===1){
                                this.hotGame.push(game);
                            }
                        })
                    }
                }
            })
        },
        destroyed() {
            clearInterval(this.timeRun);
            this.timeRun=null;
        },
    }
</script>

<style scoped>
    .homePage{
        display:flex;
        flex-direction:column;
    }
    .pageTitle{
        height:0.9rem;
        background:#1d7ef0;
        display:flex;
        align-items:center;
        color:#fff;
        padding:0 0.3rem;
        position:relative;
        flex-shrink:0;
    }
    .userInfo{
        display:flex;
        align-items:center;
        flex-shrink:0;
    }
    .imgUser{
        width:0.52rem;
        height:0.52rem;
        margin-right:0.2rem;
    }
    .nameId{
        font-size:0.2rem;
        font-weight:400;
        margin-right:0.4rem;
    }
    .amountBar{
        display:flex;
        align-items:center;
        font-size:0.18rem;
        position:relative;
        width:2.2rem;
        height:0.5rem;
        background:url("../assets/homePage/bg_Amount.png") no-repeat ;
        background-size:100% 100%;
    }
    .iconGoldCoin{
        height:0.4rem;
        width:auto;
        position:absolute;
        left:-0.2rem;
    }
    .amount{
        width:2.2rem;
        height:0.5rem;
        text-align:center;
        line-height:0.5rem;
        font-weight:bold;
        background:linear-gradient(180deg,#fff991,#ffce24);
        -webkit-background-clip: text;
        color:transparent;
        -webkit-text-stroke:0.01rem #501300;
    }
    .iconAdd{
        height:0.4rem;
        width:auto;
        position:absolute;
        right:-0.1rem;
    }
    .shortcutMenu{
        width:100%;
        font-size:0.3rem;
        font-weight:400;
        display:flex;
        justify-content:flex-end;
        align-items:center;
    }
    .iconLogo{
        width:1.2rem;
        height:auto;
        margin-left:0.2rem;
        margin-right:0.15rem;
    }
    .iconService{
        width:0.45rem;
        height:0.38rem;
    }
    .menuText{
        margin-left:0.25rem;
    }
    .contentView{
        margin:0 0.3rem;
        flex:1;
        display:flex;
        flex-direction:column;
        align-items:center;
        overflow:scroll;
    }
    .bannerBox{
        width:6.9rem;
        height:3.15rem;
        flex-shrink:0;
        margin-top:0.2rem;
        border-radius:0.15rem;
        display:flex;
        position:relative;
        overflow:hidden;
    }
    .bannerImg{
        display:flex;
        width:6.9rem;
        height:3.14rem;
        position:absolute;
        left:0;
    }
    .banner{
        width:6.9rem;
        height:3.14rem;
        flex-shrink:0;
        border-radius:0.15rem;
        box-shadow:0 0.01rem 0.03rem rgba(0,27,97,0.5);
    }
    .bannerPoint{
        position:absolute;
        right:0.3rem;
        bottom:0.2rem;
        display:flex;
    }
    .point{
        width:0.08rem;
        height:0.08rem;
        border-radius:50%;
        border:0.01rem solid #ffffff;
        margin-left:0.06rem;
    }
    .currentPoint{
        background:#ffffff;
    }
    .noticeBox{
        width:6.74rem;
        height:0.44rem;
        flex-shrink:0;
        display:flex;
        font-size:0.2rem;
        color:#ffffff;
        font-weight:400;
        background:#1d7ef0;
        border-radius:0.25rem;
        align-items:center;
        margin:0.2rem 0;
        border:0.01rem solid #a9cffd;
        padding:0 0.25rem;
        box-shadow:0 0.01rem 0.08rem rgba(0,27,97,0.8);
    }
    .noticeIcon{
        width:0.26rem;
        height:0.21rem;
        margin-right:0.1rem;
    }
    .gameBox{
        width:100%;
        display:flex;
        justify-content:space-between;
        flex-wrap:wrap;
        flex-shrink:0;
    }
    .gameItem{
        position:relative;
        width:3.35rem;
        height:1.8rem;
        border-radius:0.1rem;
        box-shadow:0 0.01rem 0.03rem rgba(0,27,97,0.5);
        margin-bottom:0.2rem;
        overflow:hidden;
    }
    .gameBg{
        width:3.35rem;
        height:1.8rem;
    }
    .gameTitle{
        height:0.4rem;
        width:auto;
        position:absolute;
        top:0.4rem;
        left:0.2rem;
    }
    .gameIconA{
        width: 1.24rem;
        height:1.07rem;
        position:absolute;
        right:-0.02rem;
        bottom:-0.1rem;
    }
    .gameIconB{
        width:0.76rem;
        height:0.78rem;
        position:absolute;
        right:0.15rem;
        bottom:0.05rem;
    }
    .gameIconC{
        width:1.18rem;
        height:1.05rem;
        position:absolute;
        right:0.05rem;
        bottom:0;
    }
    .gameIconD{
        width:1.09rem;
        height:1.09rem;
        position:absolute;
        right:0;
        bottom:-0.05rem
    }
    .gameIconE{
        width:0.83rem;
        height:1.37rem;
        position:absolute;
        right:0.2rem;
        bottom:-0.2rem
    }
    .gameIconF{
        width:1.3rem;
        height:0.67rem;
        position:absolute;
        right:-0.1rem;
        bottom:0.1rem;
    }
    .gameText{
        font-size:0.2rem;
        color:#ffffff;
        position:absolute;
        left:0.2rem;
        top:0.9rem;
    }
    .shortcutTitle{
        width:100%;
        height:0.4rem;
        line-height:0.4rem;
        background:url("../assets/homePage/icon_Heart.png") no-repeat 0.2rem center;
        background-size:0.28rem 0.23rem;
        padding-left:0.6rem;
        font-size:0.24rem;
        color:#333333;
        margin-bottom:0.1rem;
        font-weight:400;
    }
    .shortcutGameBox{
        width:6.9rem;
        height:1.6rem;
        background:url("../assets/homePage/bg_ShortcutGame.png") no-repeat;
        background-size:100% 100%;
        margin-bottom:0.2rem;
        flex-shrink:0;
        display:flex;
        align-items:center;
        padding:0 0.5rem;
        border-radius:0.12rem;
        box-shadow:0 0.01rem 0.05rem rgba(0,27,97,0.8);
        overflow:scroll;
    }
    .hotGame{
        width:1.6rem;
        height:1.6rem;
        font-size:0.16rem;
        color:#ffffff;
        font-weight:bold;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        margin-right:0.35rem;
    }
    .downloadHeight{
        margin-bottom:1.1rem
    }
    .imgGame{
        width:1.2rem;
        height:auto;
        flex-shrink:0;
    }
    .downloadBox{
        width:100%;
        height:0.9rem;
        background:linear-gradient(to bottom,#ffa0a0,#a10920);
        flex-shrink:0;
        position:absolute;
        bottom:1rem;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:0.26rem;
        color:#ffffff;
        opacity:0;
    }
    .downloadContent{
        width:7.3rem;
        height:0.7rem;
        border-radius:0.1rem;
        border:0.01rem solid #fff6d5;
        position:relative;
        display:flex;
        align-items:center;
    }
    .iconFish{
        width:0.89rem;
        height:0.98rem;
        position:absolute;
        left:0.25rem;
        top:-0.3rem;
    }
    .textDownload{
        height:0.27rem;
        width:auto;
        margin-left:1.3rem;
        margin-right:0.3rem;
    }
    .iconGold{
        width:0.68rem;
        height:0.59rem;
    }
    .btnDownload{
        width:1.62rem;
        height:0.48rem;
        position:absolute;
        right:0.1rem;
    }
</style>
