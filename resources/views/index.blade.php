<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Liz Ara León García</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet"> <!-- Ruta de tu CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <header>
        <nav>
            <div class="container">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo de Marketplace" />
                <ul class="nav-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li>
                        <a href="#">Productos</a>
                        <ul class="submenu">
                            <li><a href="#todos-productos">Todos los Productos</a></li>
                            <li><a href="#por-categoria">Por categoría</a></li>
                            <li><a href="#por-precio">Por precio</a></li>
                            <li><a href="#mas-vendidos">Más vendidos</a></li>
                            <li><a href="#nuevos-productos">Nuevos productos</a></li>
                        </ul>
                    </li>
                    <li><a href="#vender">Vender</a></li>
                    <li><a href="#mi-cuenta">Mi cuenta</a></li>
                    <li><a href="#soporte">Soporte</a></li>
                    <li><a href="#about">Acerca de</a></li>
                    <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                    <li><a href="{{ route('register') }}">Registrarse</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <section id="inicio" class="inicio">
        <div class="container">
            <div class="row align-items-center">
                <!-- Columna para el texto -->
                <div class="col-md-6">
                    <h1 class="display-4 font-weight-bold">¡Bienvenido a Marketplace!</h1>
                    <p>Aquí podrá comprar y vender sus productos con total comodidad y confianza. Una página hecha especialmente para aquellos que desean:</p>
                    <ol>
                        <li><i class="fas fa-check-circle"></i> Productos a excelentes precios y en maravillosas condiciones</li>
                        <li><i class="fas fa-check-circle"></i> Tener opciones de sobra</li>
                        <li><i class="fas fa-check-circle"></i> Una interfaz que manejar de forma rápida y fácil</li>
                    </ol>
                    <div class="mt-5">
                        <h5>Muchos productos disponibles y de diversas categorías aguardan. ¡Regístrese ahora y comience a explorar un mundo de productos!</h5>
                        <a href="{{ route('register') }}" class="btn btn-primary">Regístrate ahora</a>
                    </div>
                </div>
                <!-- Columna para la imagen -->
                <div class="col-md-6">
                    <img src="{{ asset('img/inicio.jpeg') }}" class="img-fluid mt-4 rounded shadow" alt="Ilustración de Marketplace">
                </div>
            </div>
        </div>
    </section>

        <!-- PRODUCTOS -->
        <section id="productos" class="productos">
            <h2>Productos</h2>
            <p>Aquí puedes ver todos los productos disponibles.</p>
            <ul class="submenu">
                <li id="todos-productos"><h3>Todos los Productos</h3></li>
                <li id="por-categoria"><h3>Por Categoría</h3></li>
                <li id="por-precio"><h3>Por Precio</h3></li>
                <li id="mas-vendidos"><h3>Más Vendidos</h3></li>
                <li id="nuevos-productos"><h3>Nuevos Productos</h3></li>
            </ul>
        </section>

        <!-- VENDER -->
        <section id="vender" class="vender">
            <h2>Vender</h2>
            <p>Aquí puedes aprender cómo vender tus productos.</p>
        </section>

        <!-- MI CUENTA -->
        <section id="mi-cuenta" class="mi-cuenta">
            <h2>Mi Cuenta</h2>
            <p>Accede a tu perfil y ajusta la configuración de tu cuenta.</p>
        </section>

        <!-- SOPORTE -->
        <section id="soporte" class="soporte">
            <h2>Soporte</h2>
            <p>Contáctanos si necesitas ayuda o soporte técnico.</p>
        </section>

        <!-- ABOUT -->
        <section id="about" class="about">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Columna para el texto -->
                    <div class="col-md-6">
                        <h1 class="display-4 font-weight-bold">¡Bienvenido a Marketplace!</h1>
                        <p>Aquí podrá comprar y vender sus productos con total comodidad y confianza. Una página hecha especialmente para aquellos que desean:</p>
                        <ol>
                            <li><i class="fas fa-check-circle"></i> Productos a excelentes precios y en maravillosas condiciones</li>
                            <li><i class="fas fa-check-circle"></i> Tener opciones de sobra</li>
                            <li><i class="fas fa-check-circle"></i> Una interfaz que manejar de forma rápida y fácil</li>
                        </ol>
                        <div class="mt-5">
                            <h5>Muchos productos disponibles y de diversas categorías aguardan. ¡Regístrese ahora y comience a explorar un mundo de productos!</h5>
                            <a href="{{ route('register') }}" class="btn btn-primary">Regístrate ahora</a>
                        </div>
                    </div>
                    <!-- Columna para la imagen -->
                    <div class="col-md-6">
                        <img src="{{ asset('img/inicio.jpeg') }}" class="img-fluid mt-4 rounded shadow" alt="Ilustración de Marketplace">
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p>&copy; 2024 Lizbeth León. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
