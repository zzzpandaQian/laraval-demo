@extends('layouts.web')

@section('title', '错误')

@section('content')
<div class="panel panel-default">
    <div class="panel-body text-center">
        <h1>404 未找到页面</h1>
        <a class="btn btn-primary" href="{{ route('home') }}">返回首页</a>
    </div>
</div>
@endsection
