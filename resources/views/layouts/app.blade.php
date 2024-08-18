@include('inc.function')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setTitle($page_name) }}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('storage/img/favicon.ico')}}"/>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/elements/alert.css')}}">
    <style>
        .btn-light { border-color: transparent; }
    </style>
    <link href="{{ asset('assets/css/elements/miscellaneous.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/noUiSlider/custom-nouiSlider.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/bootstrap-range-Slider/bootstrap-slider.css') }}" rel="stylesheet" type="text/css">
    
        <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/custom_dt_html5.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
        <!-- END PAGE LEVEL CUSTOM STYLES -->
    
    
    <!-- Styles -->
    @include('inc.styles')  
</head>
<body class="alt-menu sidebar-noneoverflow">
    
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->
    {{-- @if(Auth::guard('Client_seller')->check()==false) --}}
        @include('inc.navbar')
    {{-- @endif --}}
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>
        {{-- @if(Auth::guard('Client_seller')->check()==false) --}}
         @include('inc.sidebar')
        {{-- @endif --}}
        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">

            @yield('content')

            {{-- @if ($page_name != 'account_settings') --}}
                @include('inc.footer')
            {{-- @endif --}}
        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->
{{-- @endif --}}
    @include('inc.scripts')

</body>
</html>
