@extends('layouts.web')
@section('content')
<div class="container">
  <!-- 编辑我的信息 -->
  <div class="col-12 col-md-12">
    <div class="panel mb-4">
      <h3 class="panel-heading pb-4 mb-4">编辑个人信息</h3>
      <form method="post">
        {{ csrf_field() }}
        @if (isset($message) && $message == '修改成功')
          <div class="alert alert-success">修改成功</div>
        @endif
        <div class="form-group">
          <label>姓名</label>
          <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="请输入姓名">
        </div>
        <div class="form-group">
          <label>性别</label>
          <div class="global-radio-wrap">
            @foreach ($gender as $key => $value)
              <input type="radio" name="gender" value="{{ $key }}" {{ $gender[$user->gender] == $value ? "checked" : "" }}> {{ $value }} &nbsp;&nbsp;
            @endforeach
          </div>
        </div>
        <div class="form-group">
          <label>手机号码</label>
          <input type="tel" class="form-control" name="mobile" value="{{ $user->mobile }}" placeholder="请输入手机号码">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="请输入Email">
        </div>
        <div class="form-group">
          <label>出生日期</label>
          <input type="date" class="form-control" name="birthdate" value="{{ $user->birthdate }}" placeholder="请输入出生日期">
        </div>
        <div class="form-group">
          <label>地址</label>
          <input type="text" class="form-control" name="address" value="{{ $user->address }}" placeholder="请输入地址">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block save-btn-btn"><i class="flaticon-save-button mr-2"></i>保存</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

