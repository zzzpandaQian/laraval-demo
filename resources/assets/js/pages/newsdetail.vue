<template>
  <div class="">
    <app-header title="新闻详细"></app-header>
    <h2>{{news.title}}</h2>
    <div class="content" v-html="news.content"></div>
    <app-bottom></app-bottom>
  </div>
</template>

<script>
import AppHeader from "../components/AppHeader";
import AppBottom from "../components/AppBottom";
import { getNewsDetail } from "../http/api";

export default {
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      active: 0,
      news: []
    };
  },
  components: {
    AppHeader,
    AppBottom
  },
  created() {
    this.loadData();
  },
  methods: {
    loadData() {
      this.$toast.loading({
        mask: true,
        duration: 0
      });
      var id = this.$route.params.id;

      getNewsDetail(id).then(res => {
        that.news = res.data.news;
        that.isLoading = false;
        that.$toast.clear();
      });
    }
  }
};
</script>
