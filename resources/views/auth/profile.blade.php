@php
    use Carbon\Carbon;
@endphp
<x-main title="{{config('app.name')}} | Profile">
    <div class="row mt-4 justify-content-between">
        <div class="col-12 col-md-3 bg-body-tertiary border p-3">
            {{-- accordion --}}
            <div class="accordion accordion-flush" id="accordionExample">
                <div class="accordion-item">
                  <h4 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      {{__('ui.account')}}
                    </button>
                  </h4>
                  <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="small accordion-body">
                      <div class="d-flex justify-content-between">
                        <p>
                          <span class="text-muted">{{__('ui.fullname')}}:</span> 
                          {{$user->name}}
                        </p>                          
                      </div>
                        
                      <p><span class="text-muted">E-mail:</span> {{$user->email}}</p>
                      <p><span class="text-muted">{{__('ui.created')}}:</span> {{$created_at}}</p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h4 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      {{__('ui.ads')}}
                    </button>
                  </h4>
                  <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="small accordion-body">
                        <p><span class="text-muted">{{__('ui.created_ads')}}:</span> {{$user->ads()->withTrashed()->count()}}</p>
                        <p><span class="text-muted">{{__('ui.ads_in_review')}}:</span> {{$user->ads()->where('is_accepted',false)->count()}}</p>
                        <p><span class="text-muted">{{__('ui.accepted_ads')}}:</span> {{$user->ads()->where('is_accepted',true)->count()}}</p>
                        <p><span class="text-muted">{{__('ui.rejected_ads')}}:</span> {{$user->ads()->onlyTrashed()->count()}}</p>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h4 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Accordion Item #3
                    </button>
                  </h4>
                  <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="small accordion-body">
                      <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
            </div>
           
        </div>
        <div class="col-12 col-md-8">
            <h3>{{__('ui.your_ads')}}</h3>
            <table class="table table-striped border">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('ui.title')}}</th>
                    <th scope="col">{{__('ui.category')}}</th>
                    <th scope="col">{{__('ui.created')}}</th>
                    <th scope="col">{{__('ui.status')}}</th>
                    <th scope="col">{{__('ui.actions')}}</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($ads as $ad)
                    <tr>
                        <th scope="row">{{$ad->id}}</th>
                        <td>{{$ad->title}}</td>
                        <td>
                          @if (app()->getLocale() == 'it')
                          {{ $ad->category->title_it }}
                          @elseif (app()->getLocale() == 'en')
                            {{ $ad->category->title_en }}
                          @elseif (app()->getLocale() == 'es')
                            {{ $ad->category->title_es }}
                          @else
                            {{ $ad->category->title_en }} 
                          @endif
                        </td>
                        <td>{{Carbon::parse($ad->created_at)->diffForHumans()}}</td>
                        <td>
                            @if ($ad->is_accepted)
                                <span class="text-success">{{__('ui.accepted')}}</span>
                            @elseif ($ad->trashed())
                                <span class="text-danger">{{__('ui.rejected')}}</span>
                            @else
                                <span class="text-warning">{{__('ui.in_review')}}</span>
                            @endif
                        </td>
                        <td class="d-flex gap-2">
                            <a class="btn btn-warning py-1" href={{route('ad.edit',$ad->id)}}>{{__('ui.edit')}}</a>
                            <form action={{route('ad.delete',$ad->id)}} method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger py-1" type="submit">{{__('ui.delete')}}</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                
                </tbody>
              </table>
        </div>
    </div>
</x-main>