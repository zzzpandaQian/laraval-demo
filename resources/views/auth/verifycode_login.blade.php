@extends('layouts.web')

@section('content')
<div class="container">
    <div class="auth-wrap shadow border-radius">
        <h1 class="text-center user-title">用户登录</h1>
        <form class="form-horizontal" method="POST" action="{{ route('login.verifycode_login') }}">
            {{ csrf_field() }}
            <div class="{{ $errors->has('mobile') ? ' has-error' : '' }}">
                <label for="mobile">手机号</label>
                <input id="mobile" class="form-control" placeholder="请输入手机号" name="mobile" value="{{ old('mobile') }}" required autofocus>
                @if ($errors->has('mobile'))
                    <span class="help-block">
                        <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
                @endif
            </div>
            <div class="{{ $errors->has('verifyCode') ? ' has-error' : '' }}">
                <label for="verifyCode" class="control-label">验证码</label>
                <div class="row tiny-row">
                    <div class="col-8">
                        <input type="text" placeholder="请输入短信验证码" class="form-control" id="verifyCode" name="verifyCode">
                    </div>
                    <div class="col-4">
                        <input type="button" value="获取验证码" id="sendVerifySmsButton" class="get-code">
                    </div>
                </div>
                @if ($errors->has('verifyCode'))
                    <span class="help-block">
                        <strong>{{ $errors->first('verifyCode') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-checkbox">
                <div class="form-checkbox-input">
                    <input id="remember" class="regular-checkbox" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember"></label>
                </div>
                <span>记住我</span>
            </div>
            <div class="form-btn-wrap">
                <button type="submit" class="btn btn-primary login-btn btn-block">登录</button>
            </div>
            <div class="forgot-wrap">
                <a class="pr-3 border-right" href="{{ route('login') }}">密码登录</a>
                <a class="pr-3 border-right" href="{{ route('register') }}">快速注册</a>
                <a class="pl-2" href="{{ route('login.password') }}">忘记密码?</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/laravel-sms.js') }}"></script>
<script>
$('#sendVerifySmsButton').sms({
  token       : "{{csrf_token()}}",
  //请求间隔时间
  interval    : 60,
  //请求参数
  requestData : {
    //手机号
    mobile : function () {
        return $('input[name=mobile]').val();
    },
    //手机号的检测规则
    mobile_rule : 'mobile_required'
  }
});
</script>
@endsection
