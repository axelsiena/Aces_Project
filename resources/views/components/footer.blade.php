<div class="border border-top">
  <footer class="p-5">
    <div class="row">
      <div class="col-6 col-md-2 mb-3">
        <h5>{{__('ui.categories')}}</h5>
        <ul class="nav flex-column">
          @foreach(\App\Models\Category::all() as $category)
          <li class="nav-item mb-2">
            <a href={{route('adsByCategory',$category)}} class="nav-link p-0 text-muted">
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
        </ul>
      </div>

      <div class="col-6 col-md-2 mb-3">
        <h5>{{__('ui.work_with_us')}}</h5>
        <ul class="nav flex-column">
          
          <li class="nav-item mb-2">
            <a href={{route('workWithUs')}} class="nav-link p-0 text-muted">
              {{__('ui.revisor')}}
            </a>
          </li>
         
        </ul>
      </div>

      <div class="d-flex flex-column flex-sm-row justify-content-center pt-4 mt-4 border-top">
      <p>© 2024 {{config('app.name')}}, Inc. All rights reserved.</p>
      
      </div>
  </footer>
</div>