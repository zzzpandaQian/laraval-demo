@extends('layouts.web')

@section('js-head')
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=rknlfS9Bifp4itWAcCYV55Uds3i0eQhm"></script>
@endsection

@section('header')
    @include('web.partials.navbar')
    @include('web.partials.slider-home')
@endsection

@section('content')
<!-- Services -->
<section id="services">
<div class="container">
    <div class="row">
    <div class="col-lg-12 text-center">
        <h2 class="section-heading">Services</h2>
        <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
    </div>
    </div>
    <div class="row text-center">
    @for ($i = 0; $i < 3; $i++)
    <div class="col-md-4">
        <span class="fa-stack fa-4x">
        <i class="fa fa-circle fa-stack-2x text-primary"></i>
        <i class="fa fa-star-half-full fa-stack-1x fa-inverse"></i>
        </span>
        <h4 class="service-heading">E-Commerce</h4>
        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
    </div>
    @endfor
    </div>
</div>
</section>

<!-- Team -->
<section id="team">
<div class="container">
    <div class="row">
    <div class="col-lg-12 text-center">
        <h2 class="section-heading">Our Amazing Team</h2>
        <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
    </div>
    </div>
    <div class="row">
    @for ($i = 0; $i < 3; $i++)
    <div class="col-sm-4">
        <div class="team-member">
        <img class="mx-auto rounded-circle" src="{{ asset('images/avatar.png') }}" alt="">
        <h4>Kay Garland</h4>
        <p class="text-muted">Lead Designer</p>
        <ul class="list-inline social-buttons">
            <li class="list-inline-item">
            <a href="#">
                <i class="fa fa-twitter"></i>
            </a>
            </li>
            <li class="list-inline-item">
            <a href="#">
                <i class="fa fa-facebook-f"></i>
            </a>
            </li>
            <li class="list-inline-item">
            <a href="#">
                <i class="fa fa-linkedin"></i>
            </a>
            </li>
        </ul>
        </div>
    </div>
    @endfor
    </div>
    <div class="row">
    <div class="col-lg-8 mx-auto text-center">
        <p class="large text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
    </div>
    </div>
</div>
</section>

<!-- Map -->
<section>
  <div id="allmap"></div>
</section>

<!-- Clients -->
<section class="bg-light py-5">
  <div class="swiper-container swiper-logo">
    <div class="swiper-wrapper">
      @foreach ($partner as $item)
        <div class="swiper-slide">
            <a href="{{ $item->link }}">
              <img class="img-circle" src="{{ $item->imageUrl }}" alt="">
            </a>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Contact -->
<section id="contact">
<div class="container">
    <div class="row">
    <div class="col-lg-12 text-center">
        <h2 class="section-heading">Contact Us</h2>
        <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
    </div>
    </div>
    <div class="row">
    <div class="col-lg-12">
        <form id="contactForm" method="POST" name="sentMessage" novalidate="novalidate">
        <div class="row">
            <div class="col-md-6">
            <div class="form-group">
                <input class="form-control" id="name" name="name" type="text" placeholder="Your Name *" required="required" data-validation-required-message="Please enter your name.">
                <p class="help-block text-danger"></p>
            </div>
            <div class="form-group">
                <input class="form-control" id="email" name="email" type="email" placeholder="Your Email *" required="required" data-validation-required-message="Please enter your email address.">
                <p class="help-block text-danger"></p>
            </div>
            <div class="form-group">
                <input class="form-control" id="phone" name="phone" type="tel" placeholder="Your Phone *" required="required" data-validation-required-message="Please enter your phone number.">
                <p class="help-block text-danger"></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <textarea class="form-control" id="message" name="message" placeholder="Your Message *" required="required" data-validation-required-message="Please enter a message."></textarea>
                <p class="help-block text-danger"></p>
            </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-12 text-center">
                <div id="success"></div>
                <button id="sendMessageButton" class="btn btn-primary btn-xl" type="submit">Send Message</button>
            </div>
        </div>
        </form>
    </div>
    </div>
</div>
</section>
@endsection

@section('js')
@include('web.partials.map')
<script>
$(function() {

$("#contactForm input,#contactForm textarea").jqBootstrapValidation({
    preventSubmit: true,
    submitError: function($form, event, errors) {
        // additional error messages or events
    },
    submitSuccess: function($form, event) {
        event.preventDefault(); // prevent default submit behaviour

        $this = $("#sendMessageButton");
        $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages

        var data = $('#contactForm').serialize();

        var layer_loading;
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            type:"POST",
            url:"{{ route('contact.submit') }}",
            data: data,
            beforeSend: function( xhr ) {
                layer_loading = layer.load(2, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
            }
        })
        .done(function( result ) {
            layer.close(layer_loading);
            // Success message
            $('#success').html("<div class='alert alert-success'>");
            $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
            $('#success > .alert-success')
            .append("<strong>Your message has been sent. </strong>");
            $('#success > .alert-success')
            .append('</div>');
            //clear all fields
            $('#contactForm').trigger("reset");
        })
        .fail(function() {
            // Fail message
            $('#success').html("<div class='alert alert-danger'>");
            $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
            .append("</button>");
            $('#success > .alert-danger').append($("<strong>").text("Sorry " + name + ", it seems that my mail server is not responding. Please try again later!"));
            $('#success > .alert-danger').append('</div>');
            //clear all fields
            $('#contactForm').trigger("reset");
        })
        .always(function() {
            setTimeout(function() {
            $this.prop("disabled", false); // Re-enable submit button when AJAX call is complete
            }, 1000);
        });

    },
    filter: function() {
        return $(this).is(":visible");
    },
});

});

/*When clicking on Full hide fail/success boxes */
$('#name').focus(function() {
  $('#success').html('');
});

  var swiper = new Swiper('.swiper-logo', {
    slidesPerView: 5,
    paginationClickable: true,
    pagination: '.swiper-pagination',
    spaceBetween: 30
  });

</script>
@endsection
