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
    <div class="row text-center">
    @foreach ($results as $key => $item)
    <div class="col-md-4">
        <a href="{{ route('news.detail', $item->id) }}">
            <img class="img-fluid" src="{{ asset($item->image) }}" alt="">
            <h4 class="service-heading">{{ $item->title }}</h4>
        </a>
        <p class="text-muted">{{ $item->first_tag }}</p>
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
