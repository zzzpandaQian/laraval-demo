@extends('layouts.web')

@section('content')
<div class="container">
  <div class="auth-wrap shadow border-radius">
    <h1 class="text-center user-title">用户登录</h1>
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
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
      <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password">密码</label>
        <input id="password" type="password" placeholder="请输入密码" class="form-control" name="password" required>
        @if ($errors->has('password'))
        <span class="help-block">
          <strong>{{ $errors->first('password') }}</strong>
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
        <a class="pr-3 border-right" href="{{ route('login.verifycode_login') }}">手机验证码登录</a>
        <a class="pr-3 border-right" href="{{ route('register') }}">快速注册</a>
        <a class="pl-2" href="{{ route('login.password') }}">忘记密码?</a>
      </div>
    </form>
  </div>
</div>
@endsection
