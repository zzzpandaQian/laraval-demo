@extends('layouts.web')

@section('content')
<div class="container">
  <div class="auth-wrap shadow border-radius">
    <h1 class="text-center user-title">修改密码</h1>
    <form class="form-horizontal" method="POST" action="{{ route('user.password') }}">
      {{ csrf_field() }}
      @if (isset($msg) && $msg == '密码修改成功')
      <div class="alert alert-success">密码修改成功</div>
      @endif
      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="control-label">旧密码</label>
        <input id="password" type="password" class="form-control" name="password" required>
        @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
      </div>
      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="control-label">新密码</label>
        <input id="password" type="password" class="form-control" name="passwordnew" required>
        @if ($errors->has('passwordnew'))
        <span class="help-block">
          <strong>{{ $errors->first('passwordnew') }}</strong>
        </span>
        @endif
      </div>
      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="control-label">确认密码</label>
        <input id="passwordnew_confirmation" type="password" class="form-control" name="passwordnew_confirmation" required>
        @if ($errors->has('passwordnew'))
        <span class="help-block">
          <strong>{{ $errors->first('passwordnew') }}</strong>
        </span>
        @endif
      </div>
      <button type="submit" class="btn btn-primary btn-block">修改密码</button>
    </form>
  </div>
</div>
@endsection
