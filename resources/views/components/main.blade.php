<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ $title ?? config('app.name') }}</title>
        {{-- cdn fontawesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon" href="{{ asset('media/altrologo.png') }}" type="image/png">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    </head>

    <body>
        <x-navbar/> 

        <main class="container-lg d-flex flex-column min-screen my-5 position-main">  
            
            @if(Route::currentRouteName() == 'home')      
            <x-header/>
            @endif
           
            {{-- messaggi di successo/errore --}}
            <div class="row mt-lg-5">
                <div class="col-12 mt-2">
                    @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {!!session('success')!!}
                    </div>
                    @endif
            
                    @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {!!session('error')!!}
                    </div>
                    @endif
                </div>
            </div>
            {{-- fine messaggi --}}

            {{$slot}}
        </main>
        <div class="mt-auto container-fluid">            
            <x-footer/>            
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    </body>
</html>
