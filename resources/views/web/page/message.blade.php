@extends('layouts.web')
@section('title', '提示信息')

@section('content')
<div class="container">
    <div class="auth-wrap text-center shadow">
        <div class="alert alert-{{ (Session::has('flash_msg_type')) ? (Session::get('flash_msg_type')) : 'info' }}" role="alert">
          <h4 class="alert-heading">{{ (Session::has('flash_msg_head')) ? (Session::get('flash_msg_head')) : '提示信息' }}</h4>
          <p>
          @if (Session::has('flash_msg_body'))
            {{ Session::get('flash_msg_body') }}
          @else
            出错了，点击下方按钮回到首页
          @endif
          </p>

          @if (Session::has('flash_msg_foot'))
            <hr>
            <p class="mb-0">{{ Session::get('flash_msg_foot') }}</p>
          @endif

        </div>

        @if (Session::has('flash_msg_url'))
          <a class="btn btn-primary" href="{{ Session::get('flash_msg_url') }}">返回</a>
        @else
          <a class="btn btn-primary" href="{{ route('home') }}">返回首页</a>
        @endif

    </div>
</div>
@endsection
