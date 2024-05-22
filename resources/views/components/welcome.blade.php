<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Visioner POS | Front Page</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="{{ asset('assets/images/logo/Logo2.png') }}" rel="icon">
    <link href="{{ asset('assets/welcome/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{ asset('assets/welcome/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/welcome/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/welcome/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/welcome/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/welcome/assets/vendor/remixicon/remixicon.cs') }}s" rel="stylesheet">
    <link href="{{ asset('assets/welcome/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/welcome/assets/css/style.css') }}" rel="stylesheet">
</head>
    <body>
        @include('body.welcome_header')
        <section id="hero" class="hero d-flex align-items-center">
            {{ $slot }}
        </section>
        {{-- @include('body.welcome_hero') --}}
        {{-- <main id="main">
            {{ $slot }}
        </main> --}}
        {{-- @include('body.welcome_footer') --}}
    </body>
    <script src="{{ asset('assets/welcome/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/welcome/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/welcome/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/welcome/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/welcome/assets/js/main.js') }}""></script>
</html>
