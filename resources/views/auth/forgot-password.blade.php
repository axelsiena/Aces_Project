<x-main title="{{config('app.name')}} | Forgot password">
  @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
  @endif

  <div class="shadow bg-body-tertiary p-3 col-12 col-md-8 col-lg-6 m-auto">

    <h2 class="text-center my-3">{{__('ui.forgot_password_page')}}</h2>
    <form action={{route('password.email')}} method="post">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label mb-0 small ms-2 fst-italic">Email</label>
        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value={{old('email')}}>
        @error('email') 
          <div class="small text-danger">{{$message}}</div>                
        @enderror 
      </div>
  
      <button type="submit" class="btn btn-primary col-12">{{__('ui.submit')}}</button>
    </form>

  </div>


</x-main>