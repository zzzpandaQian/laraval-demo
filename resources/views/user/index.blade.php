@extends('layouts.web')
@section('title', '用户中心')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12 col-lg-9">
      <div class="user-content shadow">

        <div class="row">
          <div class="media col-12 col-sm-6 d-flex align-items-center">
            <a href="#" class="avatar mr-4">
              @if($user->avatar != null)
                <img src="{{ $user->avatarUrl }}" alt='' />
              @else
                @if($user->wx_avatar != null)
                  <img src="{{ $user->wx_avatarUrl }}" alt='' />
                @else
                  <img src="images/avatar.png" alt='' />
                @endif
              @endif
            </a>
            <div class="media-body user-info">
              <h1>{{ $user->name }}</h1>
              <p>欢迎您！</p>
              <p><a href="{{ route('user.password') }}">修改密码</a></p>
              <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                <i class="flaticon-exit-to-app-button"></i>退出登录
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </div>
          </div>
          <div class="col-12 col-sm-6 d-flex align-items-center">
            <ul class="user-info list-unstyled">
              <li>邮箱：<span>{{ $user->email }}</span></li>
              <li>性别：<span>{{ config('array.gender')[$user->gender] }}</span></li>
              <li><a href="{{ route('user.edit') }}">修改个人信息 &gt;</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection



