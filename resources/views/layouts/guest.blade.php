<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

         <!-- Favicon -->
        <link rel="shortcut icon" href="{{vite_asset('resources/template/assets/images/logos/icon-logo.svg')}}" type="image/x-icon">

        @viteReactRefresh
        @vite
        <!-- Custom CSS -->
        @stack('styles')
    </head>

    <body>
                <!-- main-bar -->
        <main class="authentication-wrap">

            {{$slot}}

        </main>


        <!-- Custom Scripts -->
         @stack('scripts')
        <!-- Javascript -->
        <script src="{{vite_asset('resources/template/js/app.js')}}"></script>

    </body>

</html>
