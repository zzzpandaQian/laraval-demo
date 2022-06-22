<template>
  <div class="">
    <app-header title="首页"></app-header>
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">Bootstrap Panel</div>
            <div class="panel-body">I'm an example panel!</div>
          </div>
        </div>
      </div>
    </div>
    <van-panel title="Vant Panel" desc>
      <div>I'm an example panel!</div>
    </van-panel>
    <div class="van-ellipsis">This is a paragraph of 250px width limit, the back will be omitted.</div>
    <van-button type="primary" @click="onClickLogin">Login</van-button>
    <app-bottom></app-bottom>
  </div>
</template>

<script>
import AppHeader from "../components/AppHeader";
import AppBottom from "../components/AppBottom";

export default {
  mounted() {
  },
  data() {
    return {
      active: 0
    };
  },
  components: {
    AppHeader,
    AppBottom
  },
  methods: {
    onClickLogin() {
      this.$router.push("login");
    }
  }
};
</script>
