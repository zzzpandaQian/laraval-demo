@extends('layouts.web')

@section('header')
    @include('web.partials.navbar')
    @include('web.partials.header')
@endsection

@section('content')
<!-- 页面 -->
<section id="page">
<div class="container">
  <div class="accordion" id="accordionExample">
    @foreach ($faq as $item)
    <div class="card">
      <div class="card-header" id="heading-{{ $item->id }}">
        <h2 class="mb-0">
          <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ $item->id }}" aria-expanded="true" aria-controls="collapse-{{ $item->id }}">
            {{ $item->title }}
          </button>
        </h2>
      </div>

      <div id="collapse-{{ $item->id }}" class="collapse" aria-labelledby="heading-{{ $item->id }}" data-parent="#accordionExample">
        <div class="card-body">
          {!! $item->description !!}
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
</section>
@endsection

