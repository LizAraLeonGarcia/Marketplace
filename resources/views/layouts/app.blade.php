<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Vaquita Marketplace')</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/productos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/editarCuenta.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Times New Roman', serif;
        }

        .container-fluid, .content {
            min-height: 100vh; /* Asegura altura completa */
            width: 100%;      /* Asegura ancho completo */
        }

        .row {
            min-height: 100%; /* Ocupa todo el alto dentro del contenedor */
        }

        .custom-menu {
            height: 100vh;
            overflow-y: auto;
        }

        .content {
            padding-top: 20px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Menú lateral -->
            <div class="col-md-3 col-lg-2 custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') || request()->is('cuenta/mi-cuenta/editar') ? 'd-none' : '' }}">
                @include('partials.menu-lateral')
            </div>
            <!-- Contenido principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="content">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <!-- ------------------------------------------------------------ JAVASCRIPS ------------------------------------------------------------ -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
</body>
</html>
