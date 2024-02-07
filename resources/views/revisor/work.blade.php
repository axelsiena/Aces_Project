<x-main>
    <div class="row mt-3 align-items-center">
        <h1 class="text-primary text-center mb-5">{{__('ui.join_us')}}</h1>
        <div class="col-12 col-md-7 text-center text-lg-start">
            <p>{{__('ui.join_us_text')}}</p>
        </div>
        <div class="col-12 col-md-5">
            <form action="{{route('work.mail')}}" method="POST">
                @csrf
                {{-- <input type="text" class="d-none" name="email" value={{auth()->user()->email}}> --}}
                <button class="btn btn-primary w-75 d-block mx-auto" type="submit">{{__('ui.apply')}}</button>
            </form>
        </div>
                
    </div>
</x-main>