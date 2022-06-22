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
        <h2 class="section-heading text-uppercase">新闻中心</h2>
        <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
    </div>
    </div>
    @include('web/news/search')
    <h3>关键词：{{ request()->input('keyword') }}</h3><hr>
    <div class="row text-center">
        @foreach ($results as $k => $item)
        <div class="col-sm-6">
            <article>
                <h2>
                    <a href="{{ route('news.detail', $item->id) }}">{{ $item->title }}</a>
                    <img class="img-fluid" src="{{ asset($item->image) }}" alt="">
                    @if (!empty($item->description))
                    <p>{!! str_limit($item->description, 50) !!}</p>
                    @else
                    <p>{!! str_limit($item->content, 50) !!}</p>
                    @endif
                    <p>{{ date('Y-m-d', strtotime($item->created_at)) }}</p>
                </h2>
            </article>
            <a href="{{ route('news.detail', $item->id) }}">阅读全文</a>
        </div>
        @endforeach
    </div>
    {!! $results->render() !!}
</div>
</section>
@endsection

@section('js')
<script>
$("document").ready(function(){


})
</script>
@endsection
