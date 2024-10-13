<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Liz Ara León García</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet"> <!-- Ruta de tu CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        <!-- MI CUENTA -->
        <section id="mi-cuenta" class="mi-cuenta">
            <h2>Mi Cuenta</h2>
            <p>Accede a tu perfil y ajusta la configuración de tu cuenta.</p>
        </section>

        <!-- SOPORTE -->
        <section id="soporte" class="soporte">
            <div class="row align-items-center">
                <!-- Columna para el texto -->
                <div class="col-md-6">
                    <h1 class="display-4 font-weight-bold">Si necesitas soporte, ¡contáctanos!</h1>
                    <p>Aquí tienes todas las formas en que puedes ponerte en contacto con nosotros para solicitar soporte técnico.</p>
                    <ol>
                        <li>
                            <i class="fas fa-envelope"></i> Correo: <a href="mailto:vaquitamarketplace@gmail.com">vaquitamarketplace@gmail.com</a>
                        </li>
                        <li>
                            <i class="fab fa-facebook-f"></i> Facebook: 
                            <a href="https://www.facebook.com/VaquitaMarketplace" target="_blank">Vaquita Marketplace</a>
                        </li>
                        <li>
                            <i class="fab fa-whatsapp"></i> WhatsApp: 
                            <a href="https://wa.me/523323242223" target="_blank">+52 1 33 2324 2223</a>
                        </li>
                        <li>
                            <i class="fab fa-twitter"></i> Twitter / X: 
                            <a href="https://twitter.com/VaquitaMarketplace" target="_blank">Vaquita Marketplace</a>
                        </li>
                        <li>
                            <i class="fab fa-instagram"></i> Instagram: 
                            <a href="https://www.instagram.com/VaquitaMarketplace" target="_blank">Vaquita Marketplace</a>
                        </li>
                    </ol>
                    <div class="mt-5">
                        <h5>¡No tardaremos en ayudarte!, por favor, ¡sé paciente!</h5>
                    </div>
                </div>
                <!-- Columna para la imagen -->
                <div class="col-md-6">
                    <img src="{{ asset('img/soporte.jpg') }}" class="img-fluid mt-4 rounded shadow" alt="Ilustración de soporte" style="max-width: 80%; height: auto;">
                </div>            
            </div>
        </section>

        <!-- ABOUT -->
        <section id="about" class="about">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Columna para la imagen -->
                    <div class="col-md-6">
                        <img src="{{ asset('img/acerca-de.jpg') }}" class="img-fluid mt-4 rounded shadow" alt="Ilustración de Marketplace">
                    </div>
                    <!-- Columna para el texto -->
                    <div class="col-md-6">
                        <h1 class="display-4 font-weight-bold">¿Por qué existo?</h1>
                        <p>¿Qué hace diferente a está página de todo el montón que ya existe con la misma finalldad? Pues esta página esta hecha con especial cuidado, cuidado tanto para el comprador como para el vendedor. Ambos pueden sentirse cómodos aquí y hacer tratos sin miedo a la estafa.</p>
                        <ol>
                            <li><i></i>Para una segura transacción se toman varias medidas de seguridad.</li>
                            <li><i></i>Sólo aquellos registrados pueden acceder por completo al cátalogo de productos disponibles para comprar.</li>
                            <li><i></i>Si no estas registrado tendrás un acceso restringido.</li>
                        </ol>
                        <div class="mt-5">
                            <h5>No lo pienses más, esta pagina es una gran opcion para comprar y vender. ¡Regístrese ahora y comience a explorar un mundo de productos!</h5>
                            <a href="{{ route('register') }}" class="btn btn-primary">Regístrate ahora</a>
                        </div>
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
