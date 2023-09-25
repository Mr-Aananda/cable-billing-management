<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('/') }}">

        <title>@yield('title') | {{ config('app.name') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{vite_asset('resources/template/assets/images/logos/icon-logo.svg')}}" type="image/x-icon">

        @viteReactRefresh
        @vite
        <!-- Custom CSS -->
        @stack('styles')
    </head>

    <body>

        <!-- start aside-bar -->
        @include('layouts.partials.aside')
        <!-- end aside-bar -->


        <!--start main -->
        <main class="main-bar" id="main-bar">

                <!-- Start navigation =================================== -->
                @include('layouts.partials.navbar')
                <!-- End navigation =================================== -->

                <!--start content -->
                <div class="container-fluid mt-3 mb-5">
                    {{-- message handler area --}}
                     {{-- <div class="col-12 mt-2">
                        <x-alert-handler/>
                    </div> --}}

                    {{-- message handler area --}}
                    <div class="col-12 mt-2">
                         @if(session()->has('success'))
                            <x-alert-components :messages="session()->get('success')"/>
                        @else
                            @if ($errors->any())
                                <x-alert-components type="danger" :messages="$errors->all()"/>
                            @endif
                        @endif
                    </div>


                    {{$slot}}

                </div>
                <!--end content -->

        </main>
        <!--end start main -->


        <!-- Javascript -->
        <script src="{{vite_asset("resources/template/js/app.js")}}"></script>
        <script src="{{vite_asset("resources/template/js/aside.js")}}"></script>
        <!-- Custom Scripts -->
        @stack('scripts')

    </body>

</html>
