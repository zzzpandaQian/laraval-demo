@extends('layouts.web')

@section('content')
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4">功能合集</h1>
  <p class="lead">CMS 通用功能合集，欢迎补充!</p>
</div>

<div class="container">
  <div class="row">

    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">发送邮件</h4>
        </div>
        <div class="card-body">
          <p>配置 `.env` 文件中的 `MAIL_*` 参数</p>
          <p><a href="{{ route('example.email') }}" target="_blank" class="btn btn-lg btn-block btn-primary">测试 »</a></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">发送短信</h4>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mt-3 mb-4">
            <li>@Dorothy</li>
            <li>开通账号</li>
            <li>设置模板</li>
          </ul>
          <a href="{{ route('example.sendsms') }}" class="btn btn-lg btn-block btn-primary">测试</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">提示信息跳转</h4>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mt-3 mb-4">
          </ul>
          <a href="{{ route('example.message') }}" target="_blank" class="btn btn-lg btn-block btn-primary">测试</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">Guzzle HTTP请求</h4>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mt-3 mb-4">
            <li>@Dorothy</li>
          </ul>
          <a href="{{ route('example.guzzle') }}" target="_blank" class="btn btn-lg btn-block btn-primary">测试</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">Ajax Modals</h4>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mt-3 mb-4">
            <li>@William</li>
          </ul>
          <a href="{{ route('example.modals') }}" target="_blank" class="btn btn-lg btn-block btn-primary">测试</a>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
