import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  base: "/wechat/",
  routes: [
    {
      path: "/",
      // meta: { auth: false },
      component: require("./pages/home.vue")
    },
    {
      path: "/news",
      // meta: { auth: false },
      component: require("./pages/news.vue")
    },
    {
      path: "/newsdetail/:id",
      component: require("./pages/newsdetail.vue")
    }, {
      path: "/contact",
      component: require("./pages/contact.vue")
    }, {
      path: "/login",
      component: require("./pages/login.vue")
    }
  ]
});
