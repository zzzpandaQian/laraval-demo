<!-- Header -->
<header class="swiper">
  <div class="swiper-container swiper-slider">
      <div class="swiper-wrapper">
        @foreach($slider as $item)
          <div class="swiper-slide {{ $item->light }}">
            <div class="container intro-text {{ $item->position }}">
              <h2 class="intro-heading">{{ $item->title }}</h2>
              <p class="intro-lead-in">{!! $item->description !!}</p>
              @if ($item->button == 1)
                <a class="btn btn-primary btn-lg" href="{{ $item->link }}" role="button">Read More</a>
              @endif
            </div>
            @if ($item->image)
              <div class="swiper-bgimg defaultimg"><img class="img-fluid" src="{{ $item->imageUrl }}" alt=""></div>
            @endif
          </div>
        @endforeach
      </div>
      <!-- 如果需要分页器 -->
      <div class="swiper-pagination"></div>

      <!-- 如果需要导航按钮 -->
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
  </div>
</header>
