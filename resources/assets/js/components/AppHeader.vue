<template>
    <div style="padding-bottom:2.875rem">
        <van-nav-bar
        :title="title"
        :left-text="lefttext"
        :left-action="leftaction"
        :right-text="righttext"
        :left-arrow="leftarrow"
        fixed
        style="background-color:#666666;color:#fff"
        @click-left="onClickLeft"
        @click-right="onClickRight"
      />
    </div>
</template>

<script>
export default {
    data(){
        return{

        }
    },
    props: {
        title: {
          type: String,
          default: 'Title'
        },
        lefttext: {
          type: String,
          default: ''
        },
        leftaction: {
          type: Boolean,
          default: false
        },
        righttext: {
          type: String,
          default: ''
        },
        leftarrow: {
          type: Boolean,
          default: false
        }
    },
    methods: {
        onClickLeft() {
            //如果不能后退，跳转到首页
            if (window.history.length <= 1) {
                this.$router.push('/');
            } else {
                if (this.leftaction) {
                    this.$emit('backto');
                } else {
                    this.$router.back();
                }
            }
        },
        onClickRight() {
            if (this.righttext!='') {
                this.$emit('refreshbizlines');
            }
        }
  }
}
</script>

