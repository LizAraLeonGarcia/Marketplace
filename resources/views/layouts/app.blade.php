<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Vaquita Marketplace')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- Cargar Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <!-- CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Incluir la barra de navegación solo en las rutas que pertenecen a la sección productos -->
        @if(request()->is('productos*'))
            @include('layouts.navigation') <!-- Incluir la barra de navegación solo en rutas que son productos -->
        @endif

        @yield('content') <!-- Sección donde se cargan las vistas específicas -->
    </div>

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
