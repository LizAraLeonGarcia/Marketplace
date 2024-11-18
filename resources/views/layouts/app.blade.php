<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Vaquita Marketplace')</title>
    <!-- *************************************************************** CSS *************************************************************** -->
    <!-- ************************************************************************************************************************* Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- ********************************************************************************************************** para la página de inicio -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <!-- ************************************************************************************************************** para el menu lateral -->
    <link href="{{ asset('assets/css/menu-lateral.css') }}" rel="stylesheet">
    <!-- ********************************************************************** para la sección del dashboard = página de inicio del usuario -->
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
    <!-- ****************************************************************************************************** para la sección de mi cuenta -->
    <link href="{{ asset('assets/css/miCuenta.css') }}" rel="stylesheet">
    <!-- ------------------------------------------------------------------------------------------------------------------ editar mi cuenta -->
    <link href="{{ asset('assets/css/editarCuenta.css') }}" rel="stylesheet">
    <!-- ---------------------------------------------------------------------------------------------------------------- cambiar contraseña -->
    <link href="{{ asset('assets/css/cambiarContraseña.css') }}" rel="stylesheet">
    <!-- -------------------------------------------------------------------------------------------------------------------- metodo de pago -->
    <link href="{{ asset('assets/css/metodoPago.css') }}" rel="stylesheet">
    <!-- ------------------------------------------------------------------------------------------------------------------- eliminar cuenta -->
    <link href="{{ asset('assets/css/eliminarCuenta.css') }}" rel="stylesheet">
    <!-- **************************************************************************************************************** para los productos -->
    <link href="{{ asset('assets/css/productos.css') }}" rel="stylesheet">
    <!-- --------------------------------------------------------------------------------------------------------------- mostrar un producto -->
    <link href="{{ asset('assets/css/productShow.css') }}" rel="stylesheet">
    <!-- -------------------------------------------------------------------------------------------------------------------- crear producto -->
    <link href="{{ asset('assets/css/productCreate.css') }}" rel="stylesheet">
    <!-- ---------------------------------------------------------------------------------------------------------------- editar un producto -->
    <link href="{{ asset('assets/css/productEdit.css') }}" rel="stylesheet">
    <!-- ------------------------------------------------------------------------------------------------------ index de todos los productos -->
    <link href="{{ asset('assets/css/productIndex.css') }}" rel="stylesheet">
    <!-- ******************************************************************************************************* para la sección del carrito -->
    <link href="{{ asset('assets/css/carritoIndex.css') }}" rel="stylesheet">
    <!-- ********************************************************************************************************** para la sección de ayuda -->
    <link href="{{ asset('assets/css/ayuda.css') }}" rel="stylesheet">
    <!-- ************************************************************************************************************************ paginación -->
    <link href="{{ asset('css/custom-pagination.css') }}" rel="stylesheet">
    <!-- *********************************************************************************************************************************** -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        html, body, .container-fluid {
            background-color: #c1c6ca;
            width: 100%;
            height: 100%;
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
        }

        .contenidoPrincipal {
            display: flex;
            flex-direction: column;
            flex-grow: 1; /* Asegura que ocupe el espacio restante */
            max-width: 100%; /* Impide que el contenido se expanda más allá del 100% */
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- ------------------------------------------------------------------------------------------ botón de toggle para el menú lateral -->
        <button id="menu-toggle" class="menu-toggle"> <i class="fas fa-bars"></i> Menú </button>
        <div class="row no-gutters">
            <!-- ------------------------------------------------------------------------------------------------------------------ Menú lateral -->
            <div class="col-md-3 col-lg-2 custom-menu">
                @include('partials.menu-lateral')
            </div>
            <!-- ----------------------------------------------------------------------------------------------------------- Contenido principal -->
            <main class="col contenidoPrincipal">
                <div class="content">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    <!-- ------------------------------------------------------------ JAVASCRIPS ------------------------------------------------------------ -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- reemplazo del menu lateral en pantallas pequeñas -->
    <script src="{{ asset('assets/js/menuToggle.js') }}"></script>

    <script src="{{ asset('assets/js/carritoIndex.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
</body>
</html>
