<template>
    <div class="menuBox">
        <div class="menuItem" @click="open(item.path,index)" v-for="(item,index) in menuItem">
            <img class="menuIcon" :src="currentIndex===index?item.iconActive:item.icon"/>
            <div class="menuText" v-text="item.name">首页</div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                currentIndex:0,
                menuItem:[
                    {name:"首页",icon:require('../../assets/component/icon_Home.png'),iconActive:require('../../assets/component/icon_HomeActive.png'),path:"/"},
                    {name:"佣金",icon:require('../../assets/component/icon_Brokerage.png'),iconActive:require('../../assets/component/icon_BrokerageActive.png'),path:"/promote"},
                    {name:"充值",icon:require('../../assets/component/icon_ReCharge.png'),iconActive:require('../../assets/component/icon_ReChargeActive.png'),path:"/reCharge"},
                    {name:"活动",icon:require('../../assets/component/icon_Activity.png'),iconActive:require('../../assets/component/icon_ActivityActive.png'),path:"/activity"},
                    {name:"我的",icon:require('../../assets/component/icon_Mine.png'),iconActive:require('../../assets/component/icon_MineActive.png'),path:"/mine"},
                ]
            }
        },
        methods:{
            open(path,index){
                all.router.history.current.path!==path && all.router.push(path)
            },
        },
        created() {
            let path=all.router.history.current.path;
            path==="/"?this.currentIndex=0:path==="/promote"?this.currentIndex=1:path==="/reCharge"?this.currentIndex=2:path==="/activity"?this.currentIndex=3:this.currentIndex=4;
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .menuBox{
        height:1rem;
        background:#4596f5;
        display:flex;
        align-items:center;
        font-size:0.18rem;
        color:#fff;
        flex-shrink:0;
        z-index:1000;
    }
    .menuItem{
        flex:1;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }
    .menuIcon{
        height:0.52rem;
        width:auto;
        margin-bottom:0.05rem;
    }

</style>