<x-main title="{{config('app.name')}} | Verify Email">

    <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h2 class="card-title text-center">{{__('ui.email_verification')}}</h2>
                <p class="card-text">
                  {{__('ui.email_verification_text1')}}
                </p>
                <p class="card-text pb-3">
                  {{__('ui.email_verification_text2')}}
                </p>
                <form action="/email/verification-notification" method="POST" class="mb-4">
                    @csrf
                    <button class="btn btn-primary w-100" type="submit"><span class="small">{{__('ui.resend_email')}}</span></button>
                </form>
        
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success small py-2">
                      {{__('ui.new_mail')}}
                    </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
</x-main>