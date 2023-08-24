<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="font-size: 0.88rem;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('css/prime-theme.css') }}">
        
        <link rel="stylesheet" href="{{ mix('css/primeicons.css') }}">
        <link rel="stylesheet" href="{{ mix('css/primevue.min.css') }}">        
        
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        @routes
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia        
    </body>
</html>


<!DOCTYPE html>
<html>
  
</html>