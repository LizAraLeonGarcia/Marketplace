@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Menú lateral -->
        <div class="custom-menu {{ request()->is('productos/create') || request()->is('productos/*/edit') || request()->is('productos/*') ? 'd-none' : '' }}">
            @include('partials.menu-lateral') <!-- Menú lateral -->
        </div>
        <!-- Contenido -->
        <div class="contenidoPrincipal">
            <h2 class="mb-4 text-center display-4">¿Algún problema?</h1>
            <p class="text-center">No te preocupes, a continuación tendrás una sección de preguntas y respuestas, quizás la solución a tu inconveniente esté ahí.</p>
            <!-- Carrousel de preguntas y respuestas -->
            <div id="faqCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner text-center">
                    <div class="carousel-item">
                        <h5>¿Cómo edito mi cuenta?</h5>
                        <p>Puedes editar tu cuenta yendo a la opción <em>Mi cuenta</em> en el menú lateral de tu Dashboard, ahí encontrarás la opción <em>Editar Cuenta</em> 
                            si ya has editado tu cuenta anteriormente, pero si es tu primera vez en cuanto selecciones la opción <em>Dashboard</em> se te dirigirá 
                            inmediatamente a la vista sin necesidad de opciones intermedias. Asimismo entre los datos que puedes editar están tu nombre, apellido, 
                            apodo, foto, descripción, sexo, país y fecha de nacimiento.</p>
                    </div>
                    <div class="carousel-item">
                        <h5>¿Qué es el perfil de comprador?</h5>
                        <p>Tu perfil como comprador abarca desde el historial de tus compras hasta las reseñas que los vendedores a quienes les has comprado algún
                            producto han hecho sobre ti. Además se muestran varios de tus datos personales como el nombre, apodo si es que tienes, país y tu ID de
                            usuario.</p>
                    </div>
                    <div class="carousel-item">
                        <h5>¿Qué es el perfil de vendedor?</h5>
                        <p>Tu perfil como vendedor abarca desde tus productos publicados hasta las reseñas que los compradores a quienes les has vendido algún producto
                            han hecho sobre ti. Además se muestran varios de tus datos personales como el nombre, apodo si es que tienes, país y tu ID de usuario.</p>
                    </div>
                    <div class="carousel-item active">
                        <h5>¿Cómo creo un producto?</h5>
                        <p>Puedes crearlo directamente en la opción <em>Crear Producto</em> que aparece en el menú lateral de tu Dashboard.</p>
                    </div>
                    <div class="carousel-item">
                        <h5>¿Cómo edito un producto?</h5>
                        <p>Hay dos opciones, la primera es en la opción <em>Editar</em> que sale en la parte derecha de cada uno de tus producto del Dashboard, la
                            segunda es yendo a la sección <em>Ver Productos</em> y buscar el producto que necesitas para escoger la opción de <strong>Editar</strong>,
                            también ubicada a la derecha del producto.</p>
                    </div>
                    <div class="carousel-item">
                        <h5>¿Cómo veo un producto?</h5>
                        <p>Hay varias maneras, la primera está en tu <em>Dashboard</em>, donde puedes ver cada uno de tus productos escogiendo la opción <strong>Ver</strong>
                            que aparece a la derecha de cada uno de ellos, la segunda opción es en la sección <em>Ver Productos</em>, ahí verás todos los productos
                            disponibles y podrás filtrar según tus necesidades, además de también poder ver uno por uno escogiendo la opción <strong>Ver</strong> que
                            también está a la derecha de cada prodcuto, por último, pero no menos importante, puedes ver un producto que esté ya en tu <em>carrito</em>, 
                            igual que en las demás formas también tendrás un botón a la derecha llamado <strong>Ver</strong>.</p>
                    </div>
                    <div class="carousel-item">
                        <h5>¿Cómo elimino un producto?</h5>
                        <p>Hay varias maneras, la primera está en tu <em>Dashboard</em>, donde puedes eliminar cada uno de tus productos escogiendo la opción <strong>Eliminar
                            </strong> que aparece a la derecha de cada uno de ellos, la segunda opción y más tediosa, es ir a la sección <em>Ver Productos</em>, ahí
                            verás todos los productos disponibles y podrás filtrar según tus necesidades, mientras escogiendo la opción <strong>Eliminar</strong> que
                            también está a la derecha de cada producto, podrás borrar el producto que desees; por último, pero no menos importante, puedes eliminar un 
                            producto que esté ya en tu <em>carrito</em>, igual que en las demás formas también tendrás un botón a la derecha llamado <strong>Eliminar</strong>.</p>
                    </div>
                    <div class="carousel-item">
                        <h5>¿Cómo compro un producto?</h5>
                        <p>Basta con seleccionar la opción de <strong>Agregar al carrito</strong> en el producto que desees comprar, después debes dirigirte a la sección
                            de <em>Mi carrito</em>, ahí podrás escoger si deseas pagar uno, todos o algunos; además de también poder modificar la cantidad. Pero siempre
                            recuerda colocar tus datos en el método de pago de forma correcta y ¡no compartirlos con nadie!.</p>
                    </div>
                    <div class="carousel-item">
                        <h5>¿Cómo veo mis reseñas como vendedor?</h5>
                        <p>Sólo necesitas ir a la sección <em>Ver mi perfil como vendedor</em>, ahí encontrarás tus reseñas en la parte de abajo, además podrás 
                            filtrarlas por puntuación o por las más recientes.</p>
                    </div>
                    <div class="carousel-item">
                        <h5>¿Cómo veo mis reseñas como comprador?</h5>
                        <p>Sólo necesitas ir a la sección <em>Ver mi perfil como comprador</em>, ahí encontrarás tus reseñas en la parte de abajo, además podrás
                            filtrarlas por puntuación o por las más recientes.</p>
                    </div>
                    <div class="carousel-item">
                        <h5>¿ pregunta ?</h5>
                        <p>Respuesta.</p>
                    </div>
                </div>
                <!-- Controles personalizados -->
                <div class="carousel-controls">
                    <button class="carousel-control-prev" type="button" data-target="#faqCarousel" data-slide="prev">
                        <span aria-hidden="true">&lt;</span> <!-- símbolo "<" -->
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#faqCarousel" data-slide="next">
                        <span aria-hidden="true">&gt;</span> <!-- símbolo ">" -->
                    </button>
                </div>
            </div>
            <div class="row mt-4 align-items-center d-flex"> 
                <div class="col-md-6 d-flex flex-column">
                    <p class="justificado">¿Tu problema no se resolvió en la sección anterior? ¡Contáctanos! Abajo tendrás todas las formas en que puedes comunicarte con nosotros para hacernos llegar tus dudas.</p>
                    <ol class="contact-list">
                        <li class="contact-item">
                            <div class="contact-info">
                                <i class="fas fa-envelope contact-icon"></i>
                                <span class="contact-text">Correo:</span>
                                <a class="contact-link" href="mailto:vaquitamarketplace@gmail.com"> vaquitamarketplace@gmail.com</a>
                            </div>
                        </li>
                        <li class="contact-item">
                            <div class="contact-info">
                                <i class="fab fa-facebook-f contact-icon"></i>
                                <span class="contact-text">Facebook:</span>
                                <a class="contact-link" href="https://www.facebook.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                            </div>
                        </li>
                        <li class="contact-item">
                            <div class="contact-info">
                                <i class="fab fa-whatsapp contact-icon"></i>
                                <span class="contact-text">WhatsApp:</span>
                                <a class="contact-link" href="https://wa.me/523323242223" target="_blank"> +52 1 33 2324 2223</a>
                            </div>
                        </li>
                        <li class="contact-item">
                            <div class="contact-info">
                                <i class="fab fa-twitter contact-icon"></i>
                                <span class="contact-text">Twitter / X:</span>
                                <a class="contact-link" href="https://twitter.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                            </div>
                        </li>
                        <li class="contact-item">
                            <div class="contact-info">
                                <i class="fab fa-instagram contact-icon"></i>
                                <span class="contact-text">Instagram:</span>
                                <a class="contact-link" href="https://www.instagram.com/VaquitaMarketplace" target="_blank"> Vaquita Marketplace</a>
                            </div>
                        </li>
                    </ol>
                </div>
                <div class="col-md-6 d-flex flex-column">
                    <img src="{{ asset('assets/img/ayuda.png') }}" alt="Ilustración de soporte" class="img-fluid" style="width: 100%; max-width: 400px;">
                </div>
            </div>
            <h3 class="text-center">¡No tardaremos en ayudarte!, por favor, ¡sé paciente!</h5>
        </div>
    </div>
</div>
@endsection
