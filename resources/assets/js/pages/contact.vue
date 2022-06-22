<template>
  <div class="">
    <app-header title="联系我们"></app-header>
    <van-cell-group>
      <van-field v-model="name" placeholder="Username"/>
      <van-field v-model="tel" label="Tel" placeholder="133xxxxxxxx"/>
    </van-cell-group>
    <van-button type="primary" size="large" @click.native="saveForm">保存</van-button>
    <app-bottom></app-bottom>
  </div>
</template>

<script>
import AppHeader from "../components/AppHeader";
import AppBottom from "../components/AppBottom";
import { contactForm } from "../http/api";

export default {
  mounted() {
    console.log("Component mounted.");
  },
  data() {
    return {
      active: 0,
      name: "",
      tel: ""
    };
  },
  components: {
    AppHeader,
    AppBottom
  },
  created() {},
  methods: {
    saveForm() {
      if (this.name.trim().length == 0) {
        this.$toast("请输入姓名");
        return false;
      }

      var form_info = {
        name: this.name,
        tel: this.tel
      };

      contactForm(form_info).then(res => {
        if (res.data.code == 200) {
          that.$dialog
            .alert({
              message: "提交成功"
            })
            .then(() => {
              that.$router.push("/");
            });
        }
      });
    }
  }
};
</script>
