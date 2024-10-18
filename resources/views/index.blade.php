<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Liz Ara León García</title>
    <link href="https://fonts.googleapis.com/css2?family=TimesNewRoman:wght@400;700&display=swap" rel="stylesheet"> <!-- Carga de la fuente -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet"> <!-- Ruta de tu CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <!-- ************************************************************** NAVBAR ************************************************************** -->
    <header>
        <nav>
            <div class="nav-container">
                <div class="logo">
                    <img src="{{ asset('img/logo1.gif') }}" alt="Logo vaquita asomandose de lado" />
                    <img src="{{ asset('img/logo2.gif') }}" alt="Logo vaquita bailando" />
                    <img src="{{ asset('img/logo3.gif') }}" alt="Logo vaquita riendo" />
                    <img src="{{ asset('img/logo4.gif') }}" alt="Logo vaquita con brillos" />
                    <img src="{{ asset('img/logo5.gif') }}" alt="Logo vaquita agradeciendo" />
                    <img src="{{ asset('img/logo6.gif') }}" alt="Logo vaquita asomandose" />
                    <img src="{{ asset('img/logo7.gif') }}" alt="Logo vaquita con rosa" />
                </div>
                <ul class="nav-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#productos">Productos</a></li>
                    <!-- <li><a href="#productos") }}">Productos</a></li> -->
                    <li><a href="#soporte">Soporte</a></li>
                    <li><a href="#about">Acerca de</a></li>
                </ul>
            </div>
        </nav>
    </header>
<!-- ************************************************************** SECCIONES ************************************************************** -->
<main>
    <!-- ---------------------------------------------------------------------------------------------------------------------------- inicio -->
    <section id="inicio" class="inicio">
        <div class="container">
            <div class="row align-items-center">
                <!-- Columna para el texto -->
                <div class="col-md-6">
                    <h1 class="display-4 font-weight-bold">¡Bienvenido a Vaquita Marketplace!</h1>
                    <p>Aquí podrá comprar y vender sus productos con total comodidad y confianza. Una página hecha especialmente para aquellos que desean:</p>
                    <ol>
                        <li><i class="fas fa-check-circle"></i> Productos a excelentes precios y en maravillosas condiciones</li>
                        <li><i class="fas fa-check-circle"></i> Tener opciones de sobra</li>
                        <li><i class="fas fa-check-circle"></i> Una interfaz que manejar de forma rápida y fácil</li>
                    </ol>
                    <div class="mt-5">
                        <h5>Muchos productos disponibles y de diversas categorías aguardan. ¡Regístrese ahora y comience a explorar un mundo de productos!</h5>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary">Regístrate ahora</a>
                            <a href="{{ route('login') }}" class="btn btn-success">Iniciar sesión</a>
                        @endguest
                        @auth
                            <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar sesión</a>
                        @endauth
                        <!--<a href="{{ route('register') }}" class="btn btn-primary">Regístrate ahora</a>
                        <a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión</a>-->
                    </div>
                </div>
                <!-- Columna para la imagen -->
                <div class="col-md-6">
                    <img src="{{ asset('img/inicio.png') }}" alt="Ilustración de Marketplace">
                </div>
            </div>
        </div>
    </section>
    <!-- -------------------------------------------------------------------------------------------------------------------------- productos -->
    <section id="productos" class="productos">
        <div class="container">
            <div class="row">
                <!-- Menú lateral (visible para todos los usuarios en la página de productos) -->
                <div class="col-md-3" id="menu-lateral">
                    @if(request()->route()->getName())
                        <h4>Filtrar por</h4>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="{{ route('productos.index') }}">Todos los Productos</a></li>
                            <li class="list-group-item"><a href="{{ route('productos.categoria', ['categoria' => 'accesorios']) }}">Por categoría</a></li>
                            <li class="list-group-item"><a href="{{ route('productos.precio') }}">Por precio</a></li>
                            <li class="list-group-item"><a href="{{ route('productos.mas-vendidos') }}">Más vendidos</a></li>
                            <li class="list-group-item"><a href="{{ route('productos.nuevos') }}">Nuevos productos</a></li>
                        </ul>
                        <!-- Imagen decorativa al final -->
                        <img src="{{ asset('img/productos.png') }}" alt="Adorno" class="menu-adornment">
                    @endif
                </div>
                <!-- Sección principal donde se listan los productos -->
                <div class="col-md-9" id="contenido-productos"> <!-- Se añadió 'offset-md-1' para separar más del menú lateral -->
                    <h1 class="display-7 font-weight-bold text-center mt4">¡Revisa todos los productos con los que contamos!</h1>
                    <p class="text-center">Aquí puedes ver todos los productos disponibles.</p>
                    <!-- Aquí puedes colocar la lista de productos -->
                </div>
            </div>
        </div>
    </section>
    <!-- ---------------------------------------------------------------------------------------------------------------------------- soporte -->
    <section id="soporte" class="soporte">
        <div class="row align-items-center">
            <!-- Columna para el texto -->
            <div class="col-md-6">
                <h1 class="display-7 font-weight-bold">Si necesitas ayuda técnica, ¡contáctanos!</h1>
                <p>Aquí tienes todas las formas en que puedes ponerte en contacto con nosotros para solicitar soporte técnico.</p>
                <ol>
                    <li>
                        <i class="fas fa-envelope"></i> Correo: <a href="mailto:vaquitamarketplace@gmail.com"> vaquitamarketplace@gmail.com</a>
                    </li>
                    <li>
                        <i class="fab fa-facebook-f"></i> Facebook: 
                        <a href="https://www.facebook.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                    </li>
                    <li>
                        <i class="fab fa-whatsapp"></i> WhatsApp: 
                        <a href="https://wa.me/523323242223" target="_blank"> +52 1 33 2324 2223</a>
                    </li>
                    <li>
                        <i class="fab fa-twitter"></i> Twitter / X: 
                        <a href="https://twitter.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                    </li>
                    <li>
                        <i class="fab fa-instagram"></i> Instagram: 
                        <a href="https://www.instagram.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                    </li>
                </ol>
                <div class="mt-5">
                    <h5>¡No tardaremos en ayudarte!, por favor, ¡sé paciente!</h5>
                </div>
            </div>
            <!-- Columna para la imagen -->
            <div class="col-md-6">
                <img src="{{ asset('img/soporte.png') }}" alt="Ilustración de soporte" style="max-width: 80%; height: auto;">
            </div>            
        </div>
    </section>
    <!-- ------------------------------------------------------------------------------------------------------------------------------ about -->
    <section id="about" class="about">
        <div class="container">
            <div class="row align-items-center">
                <!-- Columna para la imagen -->
                <div class="col-md-6">
                    <img src="{{ asset('img/acerca-de.png') }}" alt="Ilustración de Marketplace">
                </div>
                <!-- Columna para el texto -->
                <div class="col-md-6">
                    <h1 class="display-7 font-weight-bold">¿Por qué existimos?</h1>
                    <p>¿Qué hace diferente a está página de todo el montón que ya existe y, encima, con la misma finalldad?. La respuesta es en realidad sencilla, ésta página está hecha con especial cuidado, cuidado tanto para el comprador como para el vendedor. Se busca que ambos puedan sentirse cómodos y hacer tratos sin miedo a la estafa, pero seguramente ahora vienen a tu mente páginas como Amazon, Mercado Libre e inclusive Aliexpress, entonces, quizás ya te preguntaste lo siguiente: ¿por qué nosotros somos más seguros que el propio Amazon siendo una compañía mundialmente conocida?; bueno, aquí la respuesta es:</p>
                    <ol>
                        <li><i></i>Sólo aquellos registrados pueden acceder para comprar.</li>
                        <li><i></i>Por otra parte, si no estas registrado, tendrás un acceso restringido donde sólo puedes revisar los productos.</li>
                        <li><i></i>Las reseñas de los productos se publican por igual, beneficie o no al vendedor.</li>
                        <li><i></i>Tanto vendedor como comprador se pueden calificar y, dicha calficación es visible para cualquier usuario registrado.</li>
                        <li><i></i>No obtendrás spam en tu correo ni se te llenará de nofiticaciones tu cuenta con mil sugerencias de productos.</li>
                        <li><i></i>Para una segura transacción, se toman varias medidas de seguridad antes de realizar el pago.</li>
                    </ol>
                    <div class="mt-5">
                        <h5>No lo pienses más, ésta pagina es una gran opcion para comprar y vender. ¡Regístrate ahora y comienza a explorar un mundo de productos!</h5>
                        <a href="{{ route('register') }}" class="btn btn-primary">Regístrate ahora</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
    <!-- ************************************************************** FOOTER ************************************************************** -->
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p>&copy; 2024 Liz Cheli León García. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
