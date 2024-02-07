<div class="modalnav fixed-top">

  {{-- prima navbar --}}
  <nav class="navbar navbar-expand-xl bg-body-tertiary border border-bottom">
    
    <div class="container-lg">
      <a class="navbar-brand text-primary p-0"  href={{route('home')}}>        
        <img style="height:30px;" src="{{ asset('media/altrologo.png') }}" alt="Presto">        
      </a>

      @auth
      {{-- preferiti e posta --}}
      <ul class="navbar-nav flex-row ms-auto gap-4 me-4 d-lg-none">
        <li class="nav-item">
          <a class=" nav-link" href={{route('ads.favs')}}>
            <i class="fa-regular fa-heart text-muted opacity-50 fs-2"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href={{route('chatify')}}>
            <i class="fa-regular fa-envelope text-muted opacity-50 fs-2"></i>
          </a>
        </li>
      </ul>
      {{-- fine preferiti e posta --}}
      @endauth

      <button class="navbar-toggler opacity-75" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
          
          {{-- lingue --}}
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{__('ui.lang')}}
            </a>
            <ul class="dropdown-menu">
              <li class="nav-item d-flex align-items-center">
                <x-_locale lang="it" nation="it"/>
                <span>Italiano</span>
              </li>
              <li class="nav-item d-flex align-items-center">
                <x-_locale lang="en" nation="gb"/>
                <span>English</span>
              </li>
              <li class="nav-item d-flex align-items-center">
                <x-_locale lang="es" nation="es"/>
                <span>Español</span>
              </li>
            </ul>
          </li>
          {{-- fine lingue --}}      

        </ul>

        {{-- ricerca --}}
        <form action="{{route('ads.search')}}" method="GET" class="d-flex mx-xl-5 flex-grow-1 pb-2 pb-xl-0" role="search">
          <div class="input-group">
            <input name="searched" class="form-control" type="search" placeholder="{{__('ui.search_items')}}">
            <button class="btn btn-outline-primary" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </div>
        </form>
       {{-- fine ricerca --}}

        <ul class="navbar-nav gap-3">
          @auth
            {{-- zona revisore --}}
            @if (Auth::user()->is_revisor)
            <li class="nav-item">
              <livewire:notification-button>
                
              </a>
            </li>          
            @endif
            {{-- fine zona revisore --}}

            {{-- preferiti e posta --}}
            <li class="nav-item my-auto d-none d-lg-block">
              <a class="my-auto nav-link" href={{route('ads.favs')}}>
                <i class="fa-regular fa-heart text-muted opacity-75"></i>
              </a>
            </li>
            <li class="nav-item my-auto d-none d-lg-block">
              <a class="my-auto nav-link" href={{route('chatify')}}>
                <i class="fa-regular fa-envelope text-muted opacity-75"></i>
              </a>
            </li>
            {{-- fine preferiti e posta --}}
            <hr class="d-lg-none">
            {{-- categorie --}}
            <li class="nav-item d-lg-none">
              <p class="small opacity-50 mb-1">{{__('ui.categories')}}</p>
              @foreach ($categories as $category)
                <li class="d-lg-none row gx-1 align-items-center mb-0">
                  <div class="col-2 d-flex justify-content-center">
                    <i class="fs-5 text-primary fa-solid {{$category->icon}}"></i>
                  </div>
                  <a class="col-6 nav-link" href={{route('adsByCategory',$category)}}>
                    @if (app()->getLocale() == 'it')
                      {{ $category->title_it }}
                    @elseif (app()->getLocale() == 'en')
                      {{ $category->title_en }}
                    @elseif (app()->getLocale() == 'es')
                      {{ $category->title_es }}
                    @else
                      {{ $category->title_en }} 
                    @endif
                  </a>
                </li>                                
              @endforeach
            </li>
            {{-- fine categorie --}}
            <hr class="d-lg-none">
            {{-- account --}}
            @php
            $firstName = strtok(auth()->user()->name, ' ');              
            @endphp

            <p class="small opacity-50 mb-0 d-lg-none">{{__('ui.account')}}</p>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{$firstName}}
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href={{route('profile')}}>{{__('ui.profile')}}</a></li>  
                @if(!auth()->user()->is_revisor)              
                <li><a class="dropdown-item" href="{{route('workWithUs')}}">{{__('ui.work_with_us')}}</a></li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form class="dropdown-item" action={{route('logout')}} method="post">
                    @csrf
                    <button class="btn p-0 text-danger" type="submit">{{__('ui.logout')}}</button>
                  </form>
                </li>
              </ul>
            </li>
            {{-- fine account --}}

            {{-- bottone crea annuncio --}}
            <li class="mx-lg-2 mb-2 mb-lg-0 order-first order-lg-0">
              <a href="{{route('ad.create')}}" class="btn btn-primary w-100 text-white">{{__('ui.sell')}}</a>
            </li>
            {{-- fine bottone crea annuncio--}}
          @endauth
          
          @guest
  
          <!-- Button trigger modal -->
          <li class="mx-lg-2 mb-2 mb-xl-0">
            <button type="button" class="w-100 btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#loginregistermodal">
              {{__('ui.signup_login')}}
            </button>
          </li>
  
          <!-- Modal -->
          <div class="modal fade" id="loginregistermodal" tabindex="-1" aria-labelledby="loginregistermodalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                  <h2 class="text-center display-6 mb-4">{{__('ui.join_community')}}</h2>
                  <a class="my-5 btn btn-outline-success col-12 col-md-8 col-lg-6 mx-auto" href="/auth/google"><i class="fa-brands fa-google"></i> {{__('ui.with_google')}}</a>
                  <p>{{__('ui.register_with')}} <a href={{route('register')}}>Email</a></p>
                  <p>{{__('ui.already_registered')}} <a href={{route('login')}}>{{__('ui.login')}}</a></p>
                </div>              
              </div>
            </div>
          </div>
          {{-- fine modal --}}

          <li class="mx-lg-2">
            <button type="button" class="w-100 btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginregistermodal">
              {{__('ui.sell')}}
            </button> 
          </li>

          <hr class="d-lg-none">
          {{-- categorie --}}
          <li class="nav-item d-lg-none">
            <p class="small opacity-50 mb-1">{{__('ui.categories')}}</p>
            @foreach ($categories as $category)
              <li class="d-lg-none row gx-1 align-items-center mb-0">
                <div class="col-2 d-flex justify-content-center">
                  <i class="fs-5 text-primary fa-solid {{$category->icon}}"></i>
                </div>
                <a class="col-6 nav-link" href={{route('adsByCategory',$category)}}>
                  @if (app()->getLocale() == 'it')
                    {{ $category->title_it }}
                  @elseif (app()->getLocale() == 'en')
                    {{ $category->title_en }}
                  @elseif (app()->getLocale() == 'es')
                    {{ $category->title_es }}
                  @else
                    {{ $category->title_en }} 
                  @endif
                </a>
              </li>                                
            @endforeach
          </li>
          {{-- fine categorie --}}
          <hr class="d-lg-none">
          @endguest

          {{-- bottone per dark mode --}}
          <li class="nav-item my-auto text-center mt-2 mt-lg-1">
            <i id="theme-button" class="nav-link fa-regular fa-sun opacity-75" role="button"></i>
          </li>
          {{-- fine bottone dark mode --}}

        </ul>
        
      </div>
    </div>  
    
  </nav>
  {{-- fine prima navbar --}}

  {{-- seconda navbar --}}
    <nav class="d-none d-lg-block navbar bg-body-tertiary border-bottom">
      <div class="container-lg">
        @foreach($categories as $category)
        <a class="nav-link text-extramuted" href={{route('adsByCategory',$category)}}>
          @if (app()->getLocale() == 'it')
            {{ $category->title_it }}
          @elseif (app()->getLocale() == 'en')
            {{ $category->title_en }}
          @elseif (app()->getLocale() == 'es')
            {{ $category->title_es }}
          @else
            {{ $category->title_en }} 
          @endif
        </a>
        @endforeach
      </div>
    </nav>
{{-- fine seconda navbar --}}

</div>
