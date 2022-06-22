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
        <h2 class="section-heading text-uppercase">{{ $pages->title }}</h2>
    </div>
    </div>

    <div class="row">
        {!! $pages->content !!}
    </div>

</div>
</section>
@endsection
