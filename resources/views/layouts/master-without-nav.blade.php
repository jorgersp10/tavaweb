<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | LABPROF GROUP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="SISTEMA DE GESTIÓN LABPROF GROUP" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon {{ URL::asset('assets/images/crediparlogo.png')}}-->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        @include('layouts.head-css')
  </head>

    @yield('body')
    
    @yield('content')

    @include('layouts.vendor-scripts')
    </body>
</html>