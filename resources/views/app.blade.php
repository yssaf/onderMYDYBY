<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="description" content="MyMDb">
    <meta name="author" content="Yusuf Hajjar">
    <meta name="format-detection" content="telephone=no"/>
    {{--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi">--}}
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="MyMDb">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="_token" content="{{ csrf_token() }}" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ URL::asset('images/app-icon.png') }}">
    {{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>--}}
    <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ URL::asset('myicon.ico') }}">


    <link href="{{asset('css/mymdb.css')}}" rel="stylesheet">

</head>

<body>

@include('layouts.navbars.nav')

@include('layouts.navbars.subnav')

<div class="container">
    <div class="filtered-content"></div>
</div>

<div class="container">

    <div class="main-content">
        @yield('content')
    </div>

    <div class="modal fade" id="empty-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

    <script src="{{asset('js/mymdb.js')}}"></script>

    <script>
        @yield('jquery')
    </script>

    @yield('extensions')

    @include('layouts.padding.padding')

</div>

</body>

</html>
