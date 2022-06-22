<template>
    <div class="appBottom">
        <van-tabbar v-model="active" @change="itemChange" style="box-shadow: 1px 1px 20px #ccc;">
              <van-tabbar-item icon="wap-home" to="/">首页</van-tabbar-item>
              <van-tabbar-item icon="bullhorn-o" to="/news">新闻</van-tabbar-item>
              <van-tabbar-item icon="service-o" to="/contact">联系</van-tabbar-item>
              <van-tabbar-item icon="user-o" to="/user">我的</van-tabbar-item>
        </van-tabbar>
    </div>
</template>

<script>
export default {
    data() {
        return {
          active: window.mm_tabbar_active
        }
  },
  methods: {
      itemChange(index){
          window.mm_tabbar_active = index;
      }
  }
}
</script>

<style lang="css">
.appBottom{
    position:fixed;
    bottom:0;
    z-index: 99;
}
</style>
