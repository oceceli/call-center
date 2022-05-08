<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('css/prime-theme.css') }}">
        <link rel="stylesheet" href="{{ mix('css/primevue.min.css') }}">
        <link rel="stylesheet" href="{{ mix('css/primeicons.css') }}">
        {{-- <link href="https://unpkg.com/primeflex@^3/primeflex.min.css" rel="stylesheet" /> --}}
        

        <!-- Scripts -->
        @routes
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
        
        {{-- @env ('local')
        <script src="http://localhost:8080/js/bundle.js"></script>
        @endenv --}}

        {{-- <script src="https://unpkg.com/primevue/core/core.min.js"></script>
        <script src="https://unpkg.com/primevue/slider/slider.min.js"></script> --}}
        
        <script src="{{ mix('js/app.js') }}" defer></script>
    </body>
</html>


<!DOCTYPE html>
<html>
  
</html>