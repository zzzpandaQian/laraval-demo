<template>
  <div class="">
    <app-header title="联系我们"></app-header>
    <van-cell-group>
      <van-field
        center
        v-model="mobile"
        label="SMS"
        placeholder="请输入手机号"
        icon="clear"
        @click-icon="mobile = ''"
      >
        <van-button slot="button" size="small" type="primary" @click="onClickSend">Send SMS</van-button>
      </van-field>
    </van-cell-group>
    <van-cell-group>
      <van-field v-model="sms_code" label="Code" placeholder="Code" rows="1"/>
    </van-cell-group>
    <van-button type="primary" size="large" @click.native="onClickSubmit">保存</van-button>
    <app-bottom></app-bottom>
  </div>
</template>

<script>
import AppHeader from "../components/AppHeader";
import AppBottom from "../components/AppBottom";
import { VerifyCodeSms, VerifyCodeWechat } from "../http/api";
export default {
  mounted() {},
  data() {
    return {
      active: 0,
      mobile: "13788921860",
      sms_code: ""
    };
  },
  components: {
    AppHeader,
    AppBottom
  },
  created() {},
  methods: {
    onClickSend() {
      if (this.mobile.trim().length == 0) {
        this.$toast("请输入手机号");
        return false;
      }
      var form_info = {
        mobile: this.mobile
      };

      VerifyCodeSms(form_info).then(res => {
        if (res.code == 200) {
          that.$toast(res.data.message);
        } else {
          that.$toast(res.msg);
        }
      });
    },
    onClickSubmit() {
      if (this.mobile.trim().length == 0) {
        this.$toast("请输入手机号");
        return false;
      }
      var form_info = {
        mobile: this.mobile,
        sms_code: this.sms_code
      };
      VerifyCodeWechat(form_info)
        .then(res => {
          if (res.code == 200) {
            this.$toast.success(res.message);
            window.location.href = "/wechat";
          } else {
            this.$toast(res.message);
          }
        })
        .catch(function(error) {});
    }
  }
};
</script>
