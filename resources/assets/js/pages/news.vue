<template>
  <div class="">
    <app-header title="新闻列表"></app-header>
    <van-list v-model="loading" :finished="finished" finished-text="没有更多了" @load="onLoad">
      <van-list>
        <van-cell
          v-for="item in news"
          :key="item.id"
          :title="item.title + ''"
          is-link
          :to="'/newsdetail/'+item.id"
        />
      </van-list>
    </van-list>
    <app-bottom></app-bottom>
  </div>
</template>

<script>
import AppHeader from "../components/AppHeader";
import AppBottom from "../components/AppBottom";
import { getNewsList } from "../http/api";

export default {
  mounted() {
  },
  data() {
    return {
      active: 0,
      currentPage: 1,
      loading: false,
      finished: false,
      news: []
    };
  },
  components: {
    AppHeader,
    AppBottom
  },
  created() {},
  methods: {
    onLoad() {
      getNewsList({
        page: this.currentPage,
      }).then(res => {
        // 没有数据
        if (res.meta.total == 0) {
          this.finished = true;
        }
        // 数据全部加载完成
        if (res.meta.to == res.meta.total) {
          this.finished = true;
        }
        this.news = [...this.news, ...res.data];
        this.currentPage += 1;
        // 加载状态结束
        this.loading = false;
      });
    }
  }
};
</script>
