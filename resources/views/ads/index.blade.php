<x-main>
       
  <div class="d-flex justify-content-between align-items-center">    
    <h3 class="my-4">{{$title}}</h3>

    {{-- ordinamento annunci --}}   
    <form action={{route(Route::currentRouteName(),$id ?? '')}} method="GET">
      <input type="hidden" name="searched" value={{ $query ?? ''}}>
      <select class="form-select" name="orderby" onchange="submit()">
        <option {{ $orderby === 'default' ? 'selected' : '' }} value="default">{{__('ui.featured')}}</option>
        <option {{ $orderby === 'asc' ? 'selected' : '' }} value="asc">{{__('ui.cheapest')}}</option>
        <option {{ $orderby === 'desc' ? 'selected' : '' }} value="desc">{{__('ui.most_expensive')}}</option>
      </select>
    </form>
    
  </div>

  <div class="row mt-3">
    @forelse($ads as $ad)
    <div class="col-12 col-md-6 col-lg-4 col-xl-3 my-2">
      <x-card :ad="$ad"/>
    </div>
    @empty

      <div>
        @if(Route::currentRouteName() == 'ads.favs')
          <p class="fst-italic my-5 text-center">{{__('ui.no_fav')}}</p>
        @else
          <p class="fst-italic my-5 text-center">{{__('ui.no_items')}}</p>
        @endif
        <button class="btn btn-primary d-block mx-auto">
          <a class="text-white nav-link" href="{{route('ads.news')}}">{{__('ui.browse')}}</a>
        </button>
      </div>    

    @endforelse
    {{ $ads->links() }}

  </div>
   
</x-main>