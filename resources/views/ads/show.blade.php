<x-main title="{{$ad->title}}">

    <div class="row mt-2">        
        <div class="col-12 col-lg-6 mt-5 d-flex">
            <div class="col-2 ">
                <!-- Lista delle anteprime -->
                <div class="d-flex flex-column align-items-center">
                    @if(count($ad->images)>0)
                        @foreach ($ad->images as $img)
                        <a type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$loop->index}}" class="my-2 rounded @if($loop->first) active @endif">                
                          <img src="{{$img->getUrl(600,600)}}" class="rounded small-preview">                  
                        </a>
                        @endforeach
                        @else  
                        <a type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="my-2 rounded">
                            <img class="rounded small-preview" src=" https://picsum.photos/id/{{$ad->id}}/600/600" alt="Card image cap"> 
                        </a>
                        <a type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class="my-2 rounded">
                            <img class="rounded small-preview" src=" https://picsum.photos/id/{{$ad->id+1}}/600/600" alt="Card image cap"> 
                        </a>
                        <a type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class="my-2 rounded">
                            <img class="rounded small-preview" src=" https://picsum.photos/id/{{$ad->id+2}}/600/600" alt="Card image cap"> 
                        </a>
                          
                     @endif
                </div>
            </div>
            <div class="col-10">
                <div id="carouselExampleIndicators" class="carousel slide">
                    
                    <div class="carousel-inner">
                        @if(count($ad->images)>0)
                        @foreach ($ad->images as $img)
                        <div class="carousel-item @if($loop->first) active @endif">                
                          <img src="{{$img->getUrl(600,600)}}" class="d-block w-100 rounded">                  
                        </div>
                        @endforeach
                        @else  
                        <div class="carousel-item active">
                            <img class="card-img-top rounded" src=" https://picsum.photos/id/{{$ad->id}}/600/600" alt="Card image cap"> 
                          </div>
                          <div class="carousel-item">
                            <img class="card-img-top rounded" src=" https://picsum.photos/id/{{$ad->id+1}}/600/600" alt="Card image cap"> 
                          </div>
                          <div class="carousel-item">
                            <img class="card-img-top rounded" src=" https://picsum.photos/id/{{$ad->id+2}}/600/600" alt="Card image cap"> 
                          </div>    
                        
                        @endif
                       
                    </div>
                    
                    <button class="carousel-control-prev @if($ad->images->count() == 1) d-none @endif" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next @if($ad->images->count() == 1) d-none @endif" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                </div>
            </div>
        </div>

       

  
        <div class="col-12 col-lg-6 mt-5 d-flex flex-column justify-content-between ">
            <div class="card mb-3">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item display-6">€ {{number_format($ad->price, 2, ',', '.')}}</li>
                    <li class="list-group-item fw-bold">{{$ad->title}}</li>
                    <li class="list-group-item">
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
                    </li>
                    <li class="list-group-item">{{$ad->description}}</li> 
                    @guest
                    <li class="list-group-item">
                        <i role="button" class="d-inline fa-regular fa-heart opacity-50" data-bs-toggle="modal" data-bs-target="#loginregistermodal"></i>
                        <p class="opacity-50 d-inline ms-1">{{$ad->favBy()->count()}}</p>
                    </li>                    
                    @endguest
                    @auth
                    <li class="list-group-item"><livewire:favourite-ad-button adId="{{ $ad->id }}"/></li> 
                    @endauth
                </ul>
            </div>     
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item fst-italic d-flex gap-2">
                        <a class="nav-link" href="{{route('adsByUser',$ad->user)}}">{{$ad->user->name}}</a>  
                        <a href={{route('user',$ad->user)}}>
                            <i class="fa-regular fa-comment text-primary"></i>
                        </a>
                    </li>                                             
                </ul>
            </div>             
        </div>        
            
    </div>

</x-main>