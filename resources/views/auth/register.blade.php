@extends('layouts.web')

@section('content')
<div class="container">
  <div class="panel register">
    <p class="login-tips">已经有账号？<a class="pl-2" href="{{ route('login') }}">请登录?</a></p>
    <h3 class="user-form-title">用户注册</h3>
    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
      {{ csrf_field() }}
      <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
        <label for="mobile" class="control-label"><i class="flaticon-smartphone-with-three-buttons mr-1"></i>手机号<span>*</span></label>
        <div class="user-form-field">
          <input id="mobile" type="text" placeholder="请输入手机号" class="form-control" name="mobile" value="{{ old('mobile') }}" required autofocus>
        </div>
        @if ($errors->has('mobile'))
        <span class="help-block">
          {{ $errors->first('mobile') }}
        </span>
        @endif
      </div>
      <div class="form-group {{ $errors->has('verifyCode') ? ' has-error' : '' }}">
        <label for="verifyCode" class="control-label"><i class="flaticon-add-comment-button mr-1"></i>验证码<span>*</span></label>
        <div class="row tiny-row sm-row">
          <div class="col-12 col-sm-8">
            <div class="user-form-field">
              <input type="text" placeholder="请输入短信验证码" class="form-control" id="verifyCode" name="verifyCode">
            </div>
          </div>
          <div class="col-12 col-sm-4">
            <button type="button" id="sendVerifySmsButton" class="get-code btn form-control btn-secondary btn-block">获取验证码</button>
          </div>
        </div>
        @if ($errors->has('verifyCode'))
        <span class="help-block">
          {{ $errors->first('verifyCode') }}
        </span>
        @endif
      </div>
      <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="control-label"><i class="flaticon-locked-padlock-outline mr-1"></i>密码<span>*</span></label>
        <div class="user-form-field">
          <input id="password" type="password" placeholder="请输入密码" class="form-control" name="password" required>
        </div>
        @if ($errors->has('password'))
        <span class="help-block">
          {{ $errors->first('password') }}
        </span>
        @endif
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block btn-icon"><i class="flaticon-tick-inside-circle mr-2"></i>注册</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/laravel-sms.js') }}"></script>
<script>
$('#sendVerifySmsButton').sms({
  token: "{{csrf_token()}}",
  //请求间隔时间
  interval: 60,
  //请求参数
  requestData: {
    //手机号
    mobile: function() {
      return $('input[name=mobile]').val();
    },
    //手机号的检测规则
    mobile_rule: 'mobile_required'
  }
});
</script>
@endsection
