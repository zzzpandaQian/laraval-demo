@extends('layouts.web')

@section('header')
    @include('web.partials.navbar')
    @include('web.partials.header')
@endsection

@section('content')
<!-- 页面 -->
<section id="page">
<div class="container">
  <div class="row">
    <div class="col-lg-12 text-center">

    </div>
    </div>
    <div class="row">
    @foreach ($portfolio as $item)
    <input type="hidden" class="hidden_id" value="{{$item->id}}" />
      <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" href="{{ route('portfolio.detail', $item->id) }}">
          <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fa fa-plus fa-3x"></i>
              </div>
          </div>
          <img class="img-fluid" src="{{ $item->imageUrl }}" alt="">
          </a>
          <div class="portfolio-caption">
            <a class="portfolio-link" href="{{ route('portfolio.detail', $item->id) }}">
              <h4>{{ $item->title }}</h4>
              <p class="text-muted">{{ $item->sub_title }}</p>
            </a>
          </div>
      </div>
    @endforeach
    </div>
</div>
</section>
@endsection
