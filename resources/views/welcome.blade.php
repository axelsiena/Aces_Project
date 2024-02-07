<x-main>
  {{-- novità --}}
  <div class="mb-2 d-flex justify-content-between align-items-center">
    <h4>{{__('ui.last_items')}}</h4>
    <a class="see-all p-2" href="{{route('ads.news')}}">{{__('ui.see_all')}}</a>
  </div>

  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      @forelse($last_ads as $last_ad)
        <div class="swiper-slide">
          <div class="custom-h">
            <x-card :ad="$last_ad"/>
          </div>
        </div>
      @empty
        <p class="fst-italic">{{__('ui.no_items')}}</p>
      @endforelse
    </div>    
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div> 
  </div>

  {{-- più popolari (liked) --}}
  <div class="mb-2 mt-4 d-flex justify-content-between align-items-center">
    <h4>{{__('ui.popular')}}</h4>
    <a class="see-all p-2" href="{{route('ads.popular')}}">{{__('ui.see_all')}}</a>
  </div>

  {{-- swiper popular ads --}}
  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      @forelse($popular_ads as $popular_ad)
        <div class="swiper-slide">
          <div class="custom-h">
            <x-card :ad="$popular_ad"/>
          </div>
        </div>
      @empty
        <p class="fst-italic">{{__('ui.no_items')}}</p>
      @endforelse
    </div>    
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div> 
  </div>

  <!-- Initialize Swiper -->
  <script type="module">
    import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'
  
    var swiper = new Swiper(".mySwiper", {      
      
      navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },

      breakpoints: {
      
      480: {
        slidesPerView: 1,
      },
      
      768: {
        slidesPerView: 2,
      },

      992: {
        slidesPerView: 3,
      },
      
      1024: {
        slidesPerView: 4,
      },
    }
    });
  </script>
 
    
</x-main>