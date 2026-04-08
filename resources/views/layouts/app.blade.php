<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Мокронос') }}</title>

        
        <link rel="stylesheet" href="{{asset('assets/css/normalize.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/advantages.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/cart.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/catalog.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/faq.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/footer.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/header.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/hero.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/modal-login.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/process.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/product_preview.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/product.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/reviews.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/profile.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/form.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/product__visual.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/category_visual.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/aboute.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/pay.css')}} ">
    <link rel="stylesheet" href="{{asset('assets/css/order__check.css')}} ">
        <!-- Scripts -->
       <script src="{{asset('assets/js/catalog.js')}}" defer></script>
       <script src="{{asset('assets/js/cart-page.js')}}" defer></script>
       <script src="{{asset('assets/js/modal.js')}}" defer></script>
       <script src="{{asset('assets/js/check_auth.js')}}" defer></script>
       <script src="{{asset('assets/js/script.js')}}" defer></script>
    
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body class="font-sans antialiased">
        @include('partials.header')

            <!-- Page Content -->
            <main class="min-h-screen">
                @yield('content')
            </main>
        
            @include('partials.footer')
    </body>
</html>
