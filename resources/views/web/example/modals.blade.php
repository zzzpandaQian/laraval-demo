@extends('layouts.web')
<section class="bg-light" id="portfolio">
  <div class="container">
      <div class="row">
      <div class="col-lg-12 text-center">
          <h2 class="section-heading">Portfolio</h2>
          <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
      </div>
      </div>
      <div class="row">
      @foreach ($portfolio as $item)
      <input type="hidden" class="hidden_id" value="{{$item->id}}" />
      <div class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal" href="#portfolioModal1">
          <div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i class="fa fa-plus fa-3x"></i>
              </div>
          </div>
          <img class="img-fluid" src="{{ $item->imageUrl }}" alt="">
          </a>
          <div class="portfolio-caption">
          <h4>{{ $item->title }}</h4>
          <p class="text-muted">{{ $item->sub_title }}</p>
          </div>
      </div>
      @endforeach
      </div>
  </div>
</section>

@section('footer-bot')
<!-- Portfolio Modals -->
<!-- Modal 1 -->
<div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="close-modal" data-dismiss="modal">
        <div class="lr">
        <div class="rl"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="modal-body">
            <!-- Project Details Go Here -->
            <h2 class="text-uppercase">Project Name</h2>
            <p class="item-intro text-muted sub_title">Lorem ipsum dolor sit amet consectetur.</p>
            <p class="project_content"></p>
            <div class="swiper-container more_images">
              <div class="swiper-wrapper" id="more_images">
              </div>
              <!-- 如果需要分页器 -->
              <div class="swiper-pagination"></div>

              <!-- 如果需要导航按钮 -->
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
            <button class="btn btn-primary" data-dismiss="modal" type="button">
                <i class="fa fa-times"></i>
                Close Project</button>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
</div>
@endsection

@section('js')
<script>
$('.portfolio-link').click(function(){
  id = $('.hidden_id').val();
  $.get( "{{url('portfolio')}}/" + id, function(data) {// 回调函数
    data = JSON.parse(data);
    $('.text-uppercase').replaceWith("<h2 class='text-uppercase'>"+data['title']+"</h2>");
    $('.sub_title').replaceWith("<p class='item-intro text-muted sub_title'>"+data['sub_title']+"</p>");
    $('.project_content').replaceWith("<p class='project_content'>"+data['content']+"</p>");
    $("#more_images").empty();
    var option = "";
    for(i=0;i<data['more_images_url_thumb'].length;i++){
      option += "<div class='swiper-slide'><img src="+data['more_images_url_thumb'][i]+"></div>";
    }
    $("#more_images").append(option);

    var mySwiper = new Swiper ('.more_images', {
    direction: 'horizontal', // 垂直切换选项
    width: window.innerWidth,
    loop: true,

    // 如果需要分页器
    pagination: {
      el: '.swiper-pagination',
    },

    // 如果需要前进后退按钮
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
      },
    })

  });
});
</script>
@endsection
