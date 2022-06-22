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
        <h2 class="section-heading text-uppercase">{{ $item->title }}</h2>
        <h3 class="section-subheading text-muted">
            @foreach ($item->tags as $tag)
                {{ $tag->name }}
            @endforeach
        </h3>
    </div>
    </div>

    <div class="row">
        {!! $item->content !!}
    </div>

</div>
</section>
@endsection
