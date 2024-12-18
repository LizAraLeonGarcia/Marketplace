<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - Liz Ara León García</title>
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
                <!-- Botón de menú para pantallas pequeñas -->
                <button class="nav-toggle" aria-label="Toggle navigation"> ☰ </button>
                <!-- Enlaces de navegación -->
                <ul class="nav-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#soporte">Soporte</a></li>
                    <li><a href="#about">Conoce la página</a></li>
                </ul>
            </div>
        </nav>
    </header>
<!-- ************************************************************** SECCIONES ************************************************************** -->
<main>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('status') == 'verification-link-sent')
        <div class="alert alert-info">
            {{ __('Un nuevo enlace de verificación ha sido enviado a tu correo electrónico.') }}
        </div>
    @endif
    <!-- ---------------------------------------------------------------------------------------------------------------------------- inicio -->
    <section id="inicio" class="inicio">
        <div class="container">
            <div class="row">
                <h1 class="display-4 font-weight-bold">¡Bienvenido a Vaquita Marketplace!</h1>
                <!-- Columna para el texto -->
                <div class="col-md-6">
                    <p class="justificado">Aquí podrá comprar y vender sus productos con total comodidad y confianza. Una página hecha especialmente para aquellos que desean:</p>
                    <ol>
                        <li><i class="fas fa-check-circle"></i> Productos nuevos a excelentes precios y en maravillosas condiciones.</li>
                        <li><i class="fas fa-check-circle"></i> Opciones de sobra pues, la oferta y demanda es importante.</li>
                        <li><i class="fas fa-check-circle"></i> Una interfaz que manejar de forma rápida y fácil.</li>
                    </ol>
                    <p class="justificado">Pero, aún con todo lo anterior, ¿qué hace diferente a está página de todo el montón que ya existe y, encima, con la misma finalldad?. La respuesta es en realidad sencilla, ésta página está hecha con especial cuidado, cuidado tanto para el comprador como para el vendedor. Aquí se busca que ambos puedan sentirse cómodos y hacer tratos sin miedo a la estafa, pero seguramente ahora vienen a tu mente páginas como Amazon, Mercado Libre e inclusive Aliexpress, entonces, quizás ya te preguntaste lo siguiente: ¿por qué nosotros somos tan seguros?; bueno, aquí la respuesta es:</p>
                    <ol>
                        <li class="justificado"><i class="fas fa-check-circle"></i>Sólo aquellos registrados pueden acceder a la página, ya sea que quieran comprar o vender, o ambas.</li>
                        <li class="justificado"><i class="fas fa-check-circle"></i>Las reseñas de los productos se publican por igual, beneficie o no al vendedor, además son compras verificadas.</li>
                        <li class="justificado"><i class="fas fa-check-circle"></i>Tanto vendedor como comprador se pueden calificar y, dicha calficación es visible para cualquier usuario registrado.</li>
                        <li class="justificado"><i class="fas fa-check-circle"></i>No obtendrás spam en tu correo ni se te llenará de nofiticaciones tu cuenta con mil sugerencias de productos.</li>
                        <li class="justificado"><i class="fas fa-check-circle"></i>Para una segura transacción, se toman varias medidas de seguridad antes de realizar el pago.</li>
                    </ol>
                </div>
                <!-- Columna para la imagen -->
                <div class="col-md-6">
                    <img src="{{ asset('img/inicio.png') }}" alt="Ilustración de Marketplace">
                    <div class="mt-5 text-center">
                        <h5>Muchos productos disponibles y de diversas categorías aguardan. ¡Regístrese ahora y comience a explorar un mundo de productos!</h5>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-registro">Regístrate ahora</a>
                            <a href="{{ route('login') }}" class="btn btn-inicioSesion">Iniciar sesión</a>
                        @endguest
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-custom-dashboard">Ir al Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-custom-logout">Cerrar sesión</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ---------------------------------------------------------------------------------------------------------------------------- soporte -->
    <section id="soporte" class="soporte">
        <div class="row">
            <h1 class="display-7 font-weight-bold">Si necesitas ayuda técnica, ¡contáctanos!</h1>
            <!-- Columna para la imagen -->
            <div class="col-md-6">
                <img src="{{ asset('img/soporte.png') }}" alt="Ilustración de soporte" style="max-width: 80%; height: auto;">
            </div>      
            <!-- Columna para el texto -->
            <div class="col-md-6">
                <p class="justicado">Aquí tienes todas las formas en que puedes ponerte en contacto con nosotros para solicitar soporte técnico.</p>
                <ol>
                    <li>
                        <i class="fas fa-envelope" style="margin-right: 10px;"></i> <strong>Correo:</strong> 
                        <a href="mailto:vaquitamarketplace@gmail.com"> vaquitamarketplace@gmail.com</a>
                    </li>
                    <li>
                        <i class="fab fa-facebook-f" style="margin-right: 10px;"></i> <strong>Facebook:</strong>
                        <a href="https://www.facebook.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                    </li>
                    <li>
                        <i class="fab fa-whatsapp" style="margin-right: 10px;"></i> <strong>WhatsApp:</strong> 
                        <a href="https://wa.me/523323242223" target="_blank"> +52 1 33 2324 2223</a>
                    </li>
                    <li>
                        <i class="fab fa-twitter" style="margin-right: 10px;"></i> <strong>Twitter / X:</strong> 
                        <a href="https://twitter.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                    </li>
                    <li>
                        <i class="fab fa-instagram" style="margin-right: 10px;"></i> <strong>Instagram:</strong> 
                        <a href="https://www.instagram.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                    </li>
                </ol>
                <div class="mt-5">
                    <h5>¡No tardaremos en ayudarte!, por favor, ¡sé paciente!</h5>
                </div>
            </div>          
        </div>
    </section>
    <!-- ------------------------------------------------------------------------------------------------------------------------------ about -->
    <section id="about" class="about">
        <div class="container">
            <h1 class="display-7 font-weight-bold">Acerca de Vaquita Marketplace...</h1>
            <div class="row">
                <!-- Columna para el texto -->
                <div class="col-md-6">
                    <p class="justificado">Es una página intuitiva con una interfaz estétitca y fácil de manejar. Cómo ya te habrás dado cuenta,
                    especialmente si leíste el Inicio, sólo los usuarios registrados pueden acceder aquí, esto se hace para otorgarte una mayor
                    confianza y seguridad, así que, si deseas saber que te aguarda sin registrarte sólo para eso, te contamos; una vez que te
                    registras y haces Login, se te muestra:
                    </p>
                    <ol>
                        <li><i class="fas fa-info-circle"></i> Una sección llamada Dashboard,</li>
                            <p class="justificado">donde tú manejarás tus productos al mostrartelos en toda la pantalla, ahí cada producto 
                            tiene las opciones para editarlo, verlo o eliminarlo.</p>
                        <li><i class="fas fa-info-circle"></i> Un menú lateral en tu Dashboard,</li>
                            <p class="justificado">con opciones para ir a ver tu cuenta de usuario, tu perfil como vendedor, tu perfil como
                            comprador, los productos disponibles, crear un producto, ver tu carrito de compras, la sección de ayuda con preguntas
                            y respuestas a las dudas más comunes, además de un apartado con todas las formas en que puedes contactarnos, y hasta
                            el final una opción para cerrar sesión.</p>
                    </ol>
                    <h5>No lo pienses más, ésta pagina es una gran opcion para comprar y vender. ¡Regístrate ahora y comienza a explorar un mundo de productos!</h5>
                </div>
                <!-- Columna para la imagen -->
                <div class="col-md-6">
                    <img src="{{ asset('img/acerca-de.png') }}" alt="Ilustración de Marketplace">
                    <div class="mt-5">
                        <a href="{{ route('register') }}" class="btn btn-registro">Regístrate ahora</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
    <!-- ************************************************************** FOOTER ************************************************************** -->
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p>&copy; 2024B Lizbeth Araceli León García. Todos los derechos reservados.</p>
        </div>
    </footer>
    <!-- ************************************************************* SCRIPTS ************************************************************* -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleButton = document.querySelector(".nav-toggle");
        const navLinks = document.querySelector(".nav-links");

        toggleButton.addEventListener("click", function () {
            navLinks.classList.toggle("active");
        });
    });
  </script>
</body>
</html>
