
  <div class="card mx-auto mb-auto border-0 shadow rounded-0 h-100" style="width: 250px;">
    <a href={{route('ad.show',$ad)}}>
      @if(count($ad->images)>0)
      <img class="card-img-top rounded-0" src="{{$ad->images()->first()->getUrl(600,600)}}" alt="Card image cap">
      @else
      
      <img class="card-img-top rounded-0" src=" https://picsum.photos/id/{{$ad->id}}/250/250" alt="Card image cap"> 
      @endif
    </a>     
    <div class="card-body pb-0 ">
      <a href={{route('ad.show',$ad)}} class="card-title fs-6 fw-semibold card-link title-card-h">{{$ad->title}}</a>
      <div class="d-flex justify-content-between mt-3 mb-0 small">
        <p class="card-text text-muted">€ {{number_format($ad->price, 2, ',', '.')}}</p>
        <a href="{{route('adsByUser',$ad->user)}}" class="nav-link text-extramuted">{{$ad->user->name}}</a>            
      </div>                    
    </div>        
    @auth
    <div class="ms-3">
      <livewire:favourite-ad-button adId="{{ $ad->id }}" />
    </div>
    @endauth
    @guest
    <div>
      <i role="button" class="d-inline fa-regular fa-heart mb-3 ms-3 opacity-50" data-bs-toggle="modal" data-bs-target="#loginregistermodal"></i>
      <p class="small opacity-50 d-inline ms-1">{{$ad->favBy()->count()}}</p>
    </div>
    @endguest
    <div class="card-footer border-0 small opacity-75 mt-2 d-flex justify-content-between">
      <div>
        <i class="fa-solid fa-tag me-1"></i>
        <a href="{{route('adsByCategory',$ad->category)}}" class="d-inline nav-link text-extramuted">
          @if (app()->getLocale() == 'it')
            {{ $ad->category->title_it }}
          @elseif (app()->getLocale() == 'en')
            {{ $ad->category->title_en }}
          @elseif (app()->getLocale() == 'es')
            {{ $ad->category->title_es }}
          @else
            {{ $ad->category->title_en }} 
          @endif
        </a>
      </div>
      <div>
        <i class="fa-solid fa-calendar-days me-1"></i>
        <p class="small d-inline text-muted">{{$created_at}}</p>
      </div>
    </div>
  </div> 

