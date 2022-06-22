@extends('layouts.web')

@section('header')
    @include('web.partials.navbar')
    @include('web.partials.header')
@endsection

@section('content')
<!-- 新闻中心 -->
<section id="portfolio">
<div class="container">

    <div class="row">
    <div class="col-lg-12 text-center">
        <h2 class="section-heading text-uppercase">{{ $portfolio->title }}</h2>
        <h3 class="section-heading text-uppercase">{{ $portfolio->sub_title }}</h3>
    </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <h3><label>简介：</label></<h3><br/>
            @foreach ($portfolio->introduction as $introduction)
              <h4 class=" text-center">{{ $introduction->title }}</h4>
              <h6>{{ $introduction->content }}</h6>
            @endforeach
      </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-lg-12">
          <h3><label>内容：</label></h3>
          <div>{!! $portfolio->content !!}</div>
        </div>
    </div>

</div>
</section>
@endsection
