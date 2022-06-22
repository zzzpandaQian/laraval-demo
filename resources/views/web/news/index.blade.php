@extends('layouts.web')

@section('header')
    @include('web.partials.navbar')
    @include('web.partials.header')
@endsection

@section('content')
<!-- 新闻中心 -->
<section id="news">
<div class="container">
    <div class="row">
    <div class="col-lg-12 text-center">
        <h2 class="section-heading">新闻中心</h2>
        <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
    </div>
    </div>
    @include('web/news/search')
    <div class="row">
        @foreach ($cats as $k => $v)
        <div class="col-sm-6">
            <article>
                <h2 class="text-center post-title">
                    <a href="{{ route('news.list', $v->id) }}">{{$v->name}}</a>
                    <span>
                        <a href="{{ route('news.list', $v->id) }}" rel="nofollow">更多</a>
                    </span>
                </h2>
                <ul class="post-list">
                    @foreach ($results[$v->id] as $key => $item)
                    <li class="post-item">
                    <div class="row">
                        <div class="post-image col-sm-4">
                            <a href="{{ route('news.detail', $item->id) }}">
                                <img class="img-fluid" src="{{ asset('images/demo-3.jpg') }}" alt="">
                            </a>
                        </div>
                        <div class="entry-content col-sm-8">
                            <h5 class="post-title"><a href="{{ route('news.detail', $item->id) }}">{{ $item->title }}</a></h5>
                            <div class="entry-meta"><span>{{ date("Y-m-d", strtotime($item->created_at)) }}</span></div>
                        </div>
                    </div>
                    </li>
                    @endforeach
                </ul>
            </article>
        </div>
        @endforeach
    </div>
</div>
</section>
@endsection

@section('js')
<script>
$("document").ready(function(){


})
</script>
@endsection
